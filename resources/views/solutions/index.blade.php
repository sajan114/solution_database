@extends('layouts.app')

@section('title', 'Solutions')

@section('content')
    <h1>Solutions</h1>
    <p class="lead">Every solution in the database. Open one to see its products and services.</p>

    @include('partials.search', ['action' => '/solutions', 'q' => $q, 'label' => 'Search solutions'])

    @if ($q !== '')
        <p class="count">{{ $solutions->count() }} {{ \Illuminate\Support\Str::plural('solution', $solutions->count()) }} found for “{{ $q }}”</p>
    @endif

    <div class="card">
        @if ($solutions->isEmpty())
            <p class="empty">{{ $q !== '' ? 'No solutions match “' . $q . '”.' : 'No solutions yet.' }}</p>
        @else
            <ul class="list">
                @foreach ($solutions as $solution)
                    <li>
                        <a class="row" href="/solutions/{{ $solution->id }}" style="text-decoration: none;">
                            <div class="row-main">
                                <span class="row-title">{{ $solution->name }}</span>
                                @if ($solution->description)
                                    <div class="muted">{{ \Illuminate\Support\Str::limit($solution->description, 100) }}</div>
                                @endif
                            </div>
                            <span class="muted">
                                {{ $solution->problems_count }} {{ \Illuminate\Support\Str::plural('problem', $solution->problems_count) }}
                                · {{ $solution->products_count }} {{ \Illuminate\Support\Str::plural('product', $solution->products_count) }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
