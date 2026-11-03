<a href="/">Back to problems</a>

@if (session('message'))
    <p><strong>{{ session('message') }}</strong></p>
@endif

<h1>{{ $problem->name }}</h1>
<p>{{ $problem->description }}</p>

<p>
    <a href="/problems/{{ $problem->id }}/edit">Edit</a>
</p>

<form method="POST" action="/problems/{{ $problem->id }}"
      onsubmit="return confirm('Delete this problem?');">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>

<h2>Possible solutions</h2>
<ul>
    @foreach ($problem->solutions as $solution)
        <li><a href="/solutions/{{ $solution->id }}">{{ $solution->name }}</a></li>
    @endforeach
</ul>