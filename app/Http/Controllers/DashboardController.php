<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $colocation = $user->colocations()
            ->where('colocations.status', 'active')
            ->wherePivotNull('left_at')
            ->first();

        $activeExpenses = collect();
        $settledExpenses = collect();

        if ($colocation) {
            $activeExpenses = $colocation->expenses()
                ->whereNull('date')
                ->with('paidBy')
                ->orderBy('created_at', 'desc')
                ->get();

            $settledExpenses = $colocation->expenses()
                ->whereNotNull('date')
                ->with('paidBy')
                ->orderBy('date', 'desc')
                ->get();
        }

        return view('dashboard', compact('colocation', 'activeExpenses', 'settledExpenses'));
    }
}
