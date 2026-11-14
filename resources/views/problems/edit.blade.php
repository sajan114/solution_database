@extends('layouts.app')

@section('title', 'Edit ' . $problem->name)

@section('content')
    <a class="breadcrumb" href="/problems/{{ $problem->id }}">&lsaquo; Back to problem</a>
    <h1 style="margin-bottom: 20px;">Edit problem</h1>

    <div class="card">
        <form class="card-body" method="POST" action="/problems/{{ $problem->id }}">
            @csrf
            @method('PUT')
            <div class="field">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $problem->name) }}" required maxlength="255" autofocus>
            </div>
            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $problem->description) }}</textarea>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Update</button>
                <a href="/problems/{{ $problem->id }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
