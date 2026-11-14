<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Solution;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SolutionController extends Controller
{
    // List all solutions, or only those matching ?q=
    public function index(Request $request)
    {
        [$q, $errors] = $this->searchTerm($request);

        $view = view('solutions.index', [
            'solutions' => Solution::search($q)->withCount(['problems', 'products'])->orderBy('name')->get(),
            'q' => $q,
        ]);

        return $errors ? $view->withErrors($errors) : $view;
    }

    public function show(Request $request, Solution $solution)
    {
        // The tag filter comes from the URL, so check it. A bad filter is ignored
        // (all products are shown) and the page explains what was wrong.
        $validator = Validator::make($request->query(), [
            'tags' => 'nullable|array|max:20',
            'tags.*' => 'integer|exists:tags,id',
        ], [
            'tags.array' => 'The tag filter is not valid.',
            'tags.max' => 'You can filter by at most :max tags.',
            'tags.*.integer' => 'Each selected tag must be a number.',
            'tags.*.exists' => 'One of the selected tags does not exist.',
        ]);

        $selectedTags = $validator->fails()
            ? []
            : array_map('intval', $validator->validated()['tags'] ?? []);

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

        $view = view('solution', [
            'solution' => $solution,
            'products' => $products,
            'tags' => $tags,
            'selectedTags' => $selectedTags,
        ]);

        return $validator->fails() ? $view->withErrors($validator) : $view;
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
