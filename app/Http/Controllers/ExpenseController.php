<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function create()
    {
        return view('expenses.create');
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
            'date' => $request->date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense logged successfully!');
    }
}