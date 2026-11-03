<h1>Problems</h1>

@if (session('message'))
    <p><strong>{{ session('message') }}</strong></p>
@endif

<p><a href="/problems/create">Add new problem</a></p>

<ul>
    @foreach ($problems as $problem)
        <li>
            <a href="/problems/{{ $problem->id }}">{{ $problem->name }}</a>
            - <a href="/problems/{{ $problem->id }}/edit">Edit</a>
        </li>
    @endforeach
</ul>