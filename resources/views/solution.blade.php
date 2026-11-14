@extends('layouts.app')

@section('title', $solution->name)

@section('content')
    <a class="breadcrumb" href="/">&lsaquo; All problems</a>
    <h1>{{ $solution->name }}</h1>

    <h2>Products and services</h2>

    <form class="filter card card-body" method="GET" action="/solutions/{{ $solution->id }}" id="tag-filter">
        <fieldset>
            <legend>Filter by tags (a product must have all selected)</legend>
            @if ($tags->isEmpty())
                <span class="muted">No tags available.</span>
            @else
                <div class="tag-options">
                    @foreach ($tags as $tag)
                        <label class="tag-option">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                @checked(in_array($tag->id, $selectedTags, true))>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            @endif
        </fieldset>
        <div class="form-actions">
            <button class="btn" type="submit">Filter</button>
            <a href="/solutions/{{ $solution->id }}" id="clear-filter">Clear</a>
        </div>
    </form>

    <p class="count" id="product-count" aria-live="polite">{{ $products->count() }} products</p>
    <p class="empty card" id="no-products" @if ($products->isNotEmpty()) hidden @endif>No products match the selected tags.</p>

    <div class="card">
        <ul class="list" id="product-list">
            @foreach ($products as $product)
                <li class="row" data-tags="{{ $product->tags->pluck('id')->join(',') }}">
                    <div class="row-main">
                        <span class="row-title">{{ $product->name }}</span>
                        @if ($product->vendor)
                            <span class="muted">by {{ $product->vendor }}</span>
                        @endif
                        @if ($product->pivot->is_partial)
                            <span class="badge badge-partial" title="Solves only part of the need">Partial solution</span>
                        @endif
                    </div>
                    <div class="row-side">
                        <div class="badges">
                            @forelse ($product->tags as $tag)
                                <span class="badge">{{ $tag->name }}</span>
                            @empty
                                <span class="muted">No tags</span>
                            @endforelse
                        </div>
                        <form method="POST" action="/solutions/{{ $solution->id }}/products/{{ $product->id }}/partial">
                            @csrf
                            @method('PATCH')
                            <button class="btn" type="submit">
                                {{ $product->pivot->is_partial ? 'Mark as full solution' : 'Mark as partial' }}
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
