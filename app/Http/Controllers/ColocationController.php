<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\JoinColocationRequest;
use App\Http\Requests\SendInviteRequest;
use App\Mail\InvitationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ColocationController extends Controller
{
    public function create()
    {
        return view('colocations.create');
    }

    public function store(StoreColocationRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $colocation = Colocation::create([
                'name' => $validated['name'],
                'status' => 'active',
            ]);

            $colocation->users()->attach(Auth::id(), ['group_role' => 'owner']);
        });

        return redirect()->route('dashboard')->with('success', 'House created successfully!');
    }

    public function join(JoinColocationRequest $request)
    {
        $token = trim($request->validated()['join_code']);

        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation->isPending()) {
            return back()->withErrors(['join_code' => 'This invitation has already been used or declined.']);
        }

        $colocation = $invitation->colocation;

        $existingMember = $colocation->users()->where('user_id', Auth::id())->first();

        if ($existingMember && is_null($existingMember->pivot->left_at)) {
            return redirect()->route('dashboard')->with('error', 'You are already a member of this house.');
        }

        DB::transaction(function () use ($colocation, $invitation, $existingMember) {
            if ($existingMember) {
                $colocation->users()->updateExistingPivot(Auth::id(), ['left_at' => null, 'group_role' => 'member']);
            } else {
                $colocation->users()->attach(Auth::id(), ['group_role' => 'member']);
            }

            $invitation->accept();
        });

        return redirect()->route('dashboard')->with('success', "You have successfully joined {$colocation->name}!");
    }


    public function sendInvite(SendInviteRequest $request)
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $colocation = $user->colocations()->wherePivotNull('left_at')->first();

        if (!$colocation) {
            return redirect()->route('dashboard')->with('error', 'You must be in a house to invite someone.');
        }

        if ($colocation->pivot->group_role !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'Access Denied: Only the house owner can send invites.');
        }

        $token = strtoupper(Str::random(10));
        $invitation = $colocation->invitations()->create([
            'email' => $request->email,
            'token' => $token,
            'status' => 'pending',
        ]);

        Mail::to($request->email)->send(new InvitationMail($invitation));

        return redirect()->route('dashboard')->with('success', "An invitation has been sent to {$request->email}!");
    }

    public function acceptInvite($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if (!$invitation->isPending()) {
            return redirect()->route('dashboard')->with('error', 'This invitation link has already been used or has expired.');
        }

        $colocation = $invitation->colocation;

        $existingMember = $colocation->users()->where('user_id', Auth::id())->first();

        if ($existingMember && is_null($existingMember->pivot->left_at)) {
            return redirect()->route('dashboard')->with('error', 'You are already a member of this house.');
        }

        DB::transaction(function () use ($colocation, $invitation, $existingMember) {
            if ($existingMember) {
                $colocation->users()->updateExistingPivot(Auth::id(), ['left_at' => null, 'group_role' => 'member']);
            } else {
                $colocation->users()->attach(Auth::id(), ['group_role' => 'member']);
            }
            $invitation->accept();
        });

        return redirect()->route('dashboard')->with('success', "You have successfully joined {$colocation->name}!");
    }

    public function deactivate()
    {
        $colocation = Auth::user()->colocations->first();

        if ($colocation->pivot->group_role !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'Only the owner can delete the house.');
        }

        if ($colocation->users()->count() > 1) {
            return redirect()->route('dashboard')->with('error', 'You must remove all roommates before deleting the house.');
        }

        $colocation->update(['status' => 'cancelled']);

        return redirect()->route('dashboard')->with('success', 'House deleted successfully.');
    }

    public function removeMember($userId)
    {
        $colocation = Auth::user()->colocations->first();

        if (!$colocation || $colocation->pivot->group_role !== 'owner') {
            return back()->with('error', 'Only the house owner can remove members.');
        }

        $balance = $colocation->getUserBalance($userId);
        if ($balance < 0) {
            User::where('id', $userId)->decrement('reputation_score');
        }

        $colocation->users()->updateExistingPivot($userId, ['left_at' => now()]);

        return back()->with('success', 'Roommate removed successfully.');
    }

    public function leave()
    {
        $colocation = Auth::user()->colocations->first();

        if ($colocation->pivot->group_role === 'owner') {
            return back()->with('error', 'As the owner, you must delete the house instead of leaving.');
        }

        $userId = Auth::id();
        $balance = $colocation->getUserBalance($userId);

        if ($balance < 0) {
            Auth::user()->decrement('reputation_score');
        }

        $colocation->users()->updateExistingPivot($userId, ['left_at' => now()]);

        return redirect()->route('dashboard')->with('success', 'You have successfully left the house.');
    }
}
