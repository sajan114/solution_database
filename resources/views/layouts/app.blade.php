<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Solution Database</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="site-header">
    <div class="container">
        <a class="brand" href="/">Solution Database</a>
        <nav class="site-nav" aria-label="Main">
            <a href="/" @if (request()->is('/', 'problems*')) aria-current="page" @endif>Problems</a>
            <a href="/solutions" @if (request()->is('solutions*')) aria-current="page" @endif>Solutions</a>
        </nav>
    </div>
</header>

<main class="container">
    @if (session('message'))
        <p class="flash" role="status">{{ session('message') }}</p>
    @endif

    @include('partials.errors')

    @yield('content')
</main>
</body>
</html>
