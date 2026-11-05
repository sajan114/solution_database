<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Solution;
use App\Models\Tag;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function show(Request $request, Solution $solution)
    {
        $selectedTags = array_map('intval', (array) $request->query('tags', []));

        $products = Product::query()
            ->whereHas('solutions', fn ($q) => $q->whereKey($solution->id))
            ->withAllTags($selectedTags)
            ->with('tags')
            ->orderBy('name')
            ->get();

        // Tags offered as filters: those used by any product of this solution.
        $tags = Tag::query()
            ->whereHas('products.solutions', fn ($q) => $q->whereKey($solution->id))
            ->orderBy('name')
            ->get();

        return view('solution', [
            'solution' => $solution,
            'products' => $products,
            'tags' => $tags,
            'selectedTags' => $selectedTags,
        ]);
    }
}
