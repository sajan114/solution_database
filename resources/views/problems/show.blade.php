@extends('layouts.app')

@section('title', $problem->name)

@section('content')
    <a class="breadcrumb" href="/">&lsaquo; All problems</a>

    <div class="page-head">
        <h1>{{ $problem->name }}</h1>
        <div class="actions">
            <a class="btn" href="/problems/{{ $problem->id }}/edit">Edit</a>
            <form method="POST" action="/problems/{{ $problem->id }}"
                  onsubmit="return confirm('Delete this problem?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        </div>
    </div>

    <p class="lead">{{ $problem->description ?: 'No description.' }}</p>

    <h2>Possible solutions</h2>
    <div class="card">
        @if ($problem->solutions->isEmpty())
            <p class="empty">No solutions are linked to this problem yet.</p>
        @else
            <ul class="list">
                @foreach ($problem->solutions as $solution)
                    <li>
                        <a class="row" href="/solutions/{{ $solution->id }}" style="text-decoration: none;">
                            <span class="row-title">{{ $solution->name }}</span>
                            <span class="muted" aria-hidden="true">&rsaquo;</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
