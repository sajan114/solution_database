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

        // Products of this solution; each one carries pivot->is_partial.
        $products = $solution->products()
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

    // Flip a product between "solves it fully" and "solves it only in part" for this solution.
    public function togglePartial(Solution $solution, Product $product)
    {
        $link = $solution->products()->whereKey($product->id)->first();
        abort_if($link === null, 404);

        $makePartial = ! $link->pivot->is_partial;
        $solution->products()->updateExistingPivot($product->id, ['is_partial' => $makePartial]);

        $message = $makePartial
            ? $product->name . ' is now marked as a partial solution.'
            : $product->name . ' is now marked as a full solution.';

        return redirect()->back()->with('message', $message);
    }
}
