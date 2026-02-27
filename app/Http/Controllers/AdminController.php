<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers'       => User::count(),
            'totalColocations' => Colocation::count(),
            'totalExpenses'    => Expense::count(),
            'bannedUsers'      => User::where('is_banned', true)->count(),
            'users'            => User::latest()->paginate(20, ['*'], 'users_page'),
            'colocations'      => Colocation::with('activeMembers')->latest()->paginate(20, ['*'], 'colocations_page'),
        ]);
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function ban(User $user)
    {
        $user->ban();
        
        return back()->with('success', 'User banned.');
    }

    public function unban(User $user)
    {
        $user->unban();
        
        return back()->with('success', 'User unbanned.');
    }
}