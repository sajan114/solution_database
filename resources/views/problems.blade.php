<h1>Problems</h1>
<ul>
    @foreach ($problems as $problem)
        <li><a href="/problems/{{ $problem->id }}">{{ $problem->name }}</a></li>
    @endforeach
</ul>