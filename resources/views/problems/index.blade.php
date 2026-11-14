@extends('layouts.app')

@section('title', 'Problems')

@section('content')
    <div class="page-head">
        <h1>Problems</h1>
        <a class="btn btn-primary" href="/problems/create">Add problem</a>
    </div>
    <p class="lead">Pick the problem you found in the discussion to see solutions that could help.</p>

    <div class="card">
        @if ($problems->isEmpty())
            <p class="empty">No problems yet. Add the first one.</p>
        @else
            <ul class="list">
                @foreach ($problems as $problem)
                    <li class="row">
                        <div class="row-main">
                            <a class="row-title" href="/problems/{{ $problem->id }}">{{ $problem->name }}</a>
                            @if ($problem->description)
                                <div class="muted">{{ \Illuminate\Support\Str::limit($problem->description, 100) }}</div>
                            @endif
                        </div>
                        <a href="/problems/{{ $problem->id }}/edit">Edit</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
