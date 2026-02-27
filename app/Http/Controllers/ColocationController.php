<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreColocationRequest;

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

            $colocation->users()->attach(Auth::id(), ['group_role' => 'admin']);
        });

        return redirect()->route('dashboard')->with('success', 'House created successfully!');
    }
}