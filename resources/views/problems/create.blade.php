<a href="/">Back to problems</a>
<h1>Add problem</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/problems">
    @csrf
    <p>
        <label>Name<br>
        <input type="text" name="name" value="{{ old('name') }}"></label>
    </p>
    <p>
        <label>Description<br>
        <textarea name="description">{{ old('description') }}</textarea></label>
    </p>
    <button type="submit">Save</button>
</form>