<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $solution->name }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>
<a href="/">Back to problems</a>
<h1>{{ $solution->name }}</h1>

<h2>Products and services</h2>

<form method="GET" action="/solutions/{{ $solution->id }}" id="tag-filter">
    <fieldset>
        <legend>Filter by tags (product must have all selected)</legend>
        @forelse ($tags as $tag)
            <label>
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                    @checked(in_array($tag->id, $selectedTags, true))>
                {{ $tag->name }}
            </label>
        @empty
            <em>No tags available.</em>
        @endforelse
    </fieldset>
    <button type="submit">Filter</button>
    <a href="/solutions/{{ $solution->id }}" id="clear-filter">Clear</a>
</form>

<p id="product-count">{{ $products->count() }} products</p>
<p id="no-products" @if ($products->isNotEmpty()) hidden @endif>No products match the selected tags.</p>

<ul id="product-list">
    @foreach ($products as $product)
        <li data-tags="{{ $product->tags->pluck('id')->join(',') }}">
            {{ $product->name }} ({{ $product->vendor }}) -
            Tags: {{ $product->tags->pluck('name')->join(', ') }}
        </li>
    @endforeach
</ul>
</body>
</html>
