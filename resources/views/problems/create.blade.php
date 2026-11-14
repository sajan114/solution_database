@extends('layouts.app')

@section('title', 'Add problem')

@section('content')
    <a class="breadcrumb" href="/">&lsaquo; All problems</a>
    <h1 style="margin-bottom: 20px;">Add problem</h1>

    <div class="card">
        <form class="card-body" method="POST" action="/problems">
            @csrf
            <div class="field">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="255" autofocus>
            </div>
            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="/">Cancel</a>
            </div>
        </form>
    </div>
@endsection
