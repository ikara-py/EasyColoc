<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        $colocation = Auth::user()->colocations()->where('colocations.status', 'active')->first();

        if (!$colocation) {
            return back()->with('error', 'You must be in a house to create a category.');
        }

        Category::create([
            'name' => $request->validated('name'),
            'colocation_id' => $colocation->id,
        ]);

        return back()->with('success', 'Category created successfully!');
    }
}
