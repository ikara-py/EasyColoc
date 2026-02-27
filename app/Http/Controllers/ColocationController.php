<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation; // <-- Important: Include your model
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\JoinColocationRequest;

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
                'join_code' => Str::upper(Str::random(8)),
                'status' => 'active',
            ]);

            $colocation->users()->attach(Auth::id(), ['group_role' => 'owner']);
        });

        return redirect()->route('dashboard')->with('success', 'House created successfully!');
    }

    public function join(JoinColocationRequest $request)
    {
        $token = $request->validated()['join_code'];

        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation->isPending()) {
            return back()->withErrors(['join_code' => 'This invitation has already been used or declined.']);
        }

        $colocation = $invitation->colocation;

        if ($colocation->users()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('dashboard')->with('error', 'You are already a member of this house.');
        }

        DB::transaction(function () use ($colocation, $invitation) {
            $colocation->users()->attach(Auth::id(), ['group_role' => 'member']);
            
            $invitation->accept();
        });

        return redirect()->route('dashboard')->with('success', "You have successfully joined {$colocation->name}!");
    }

    
    public function generateInvite(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $colocation = $user->colocations()->first();

        if (!$colocation) {
            return redirect()->route('dashboard')->with('error', 'You must be in a house to invite someone.');
        }

        if ($colocation->pivot->group_role !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'Access Denied: Only the house owner can generate invites.');
        }

        $token = strtoupper(Str::random(8));

        $colocation->invitations()->create([
            'token' => $token,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', "New Invite Code Generated: {$token}. Share this with your roommate!");
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

        $colocation->update(['status' => 'inactive']);

        return redirect()->route('dashboard')->with('success', 'House deleted successfully.');
    }

    public function removeMember($userId)
    {
        $colocation = Auth::user()->colocations->first();

        if (!$colocation || $colocation->pivot->group_role !== 'owner') {
            return back()->with('error', 'Only the house owner can remove members.');
        }

        $colocation->users()->detach($userId);

        return back()->with('success', 'Roommate removed successfully.');
    }
}