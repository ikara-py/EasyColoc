<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\Settlement;
use App\Models\User;

class SettlementController extends Controller
{
    public function store(Request $request, Expense $expense, User $user)
    {
        $colocation = Auth::user()->colocations()->where('colocations.status', 'active')->first();

        if (!$colocation || $expense->colocation_id !== $colocation->id) {
            return back()->with('error', 'Access Denied.');
        }

        if (Auth::id() !== $expense->paid_by) {
            return back()->with('error', 'Only the person who paid this expense can mark someone as paid.');
        }

        $totalMembers = $colocation->users()->count();
        $splitAmount = $totalMembers > 0 ? $expense->amount / $totalMembers : $expense->amount;

        Settlement::create([
            'colocation_id' => $colocation->id,
            'payer_id' => $user->id,
            'payee_id' => Auth::id(),
            'amount' => $splitAmount
        ]);

        return back()->with('success', "Marked " . $user->name . ' as paid!');
    }
}
