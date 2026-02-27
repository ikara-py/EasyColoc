<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $colocation = Auth::user()->colocations()->where('colocations.status', 'active')->first();

        if (!$colocation) {
            return redirect()->route('dashboard')->with('error', 'You must be in an active house to view expenses.');
        }

        $settledExpenses = $colocation->expenses()->whereNotNull('date')->with('paidBy')->orderBy('date', 'desc')->get();

        return view('expenses.index', compact('colocation', 'settledExpenses'));
    }

    public function create()
    {
        $colocation = Auth::user()->colocations()->where('colocations.status', 'active')->first();

        if (!$colocation) {
            return redirect()->route('dashboard')->with('error', 'You must be in an active house to log expenses.');
        }

        $categories = $colocation->categories;

        return view('expenses.create', compact('categories'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $colocation = Auth::user()->colocations()->where('colocations.status', 'active')->first();

        if (!$colocation) {
            return redirect()->route('dashboard')->with('error', 'You must be in an active house to log expenses.');
        }

        $colocation->expenses()->create([
            'paid_by' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense logged successfully!');
    }

    public function settle(Expense $expense)
    {
        $colocation = Auth::user()->colocations()->where('colocations.status', 'active')->first();

        if (!$colocation || $expense->colocation_id !== $colocation->id) {
            return back()->with('error', 'Access Denied.');
        }

        if (Auth::id() !== $expense->paid_by) {
            return back()->with('error', 'Only the person who paid this expense can mark it as settled.');
        }

        $expense->update(['date' => now()]);

        return back()->with('success', 'Expense moved to history!');
    }


    public function show(Expense $expense)
    {
        $colocation = Auth::user()->colocations()->where('colocations.status', 'active')->first();

        if (!$colocation || $expense->colocation_id !== $colocation->id) {
            return redirect()->route('dashboard')->with('error', 'Access Denied.');
        }

        $members = $colocation->users;
        $totalMembers = $members->count();

        $splitAmount = $totalMembers > 0 ? $expense->amount / $totalMembers : $expense->amount;

        return view('expenses.show', compact('expense', 'colocation', 'members', 'splitAmount'));
    }
}