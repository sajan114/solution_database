<a href="/problems/{{ $problem->id }}">Back</a>
<h1>Edit problem</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/problems/{{ $problem->id }}">
    @csrf
    @method('PUT')
    <p>
        <label>Name<br>
        <input type="text" name="name" value="{{ old('name', $problem->name) }}"></label>
    </p>
    <p>
        <label>Description<br>
        <textarea name="description">{{ old('description', $problem->description) }}</textarea></label>
    </p>
    <button type="submit">Update</button>
</form>