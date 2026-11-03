<a href="/">Back to problems</a>
<h1>{{ $problem->name }}</h1>
<h2>Possible solutions</h2>
<ul>
    @foreach ($problem->solutions as $solution)
        <li><a href="/solutions/{{ $solution->id }}">{{ $solution->name }}</a></li>
    @endforeach
</ul>