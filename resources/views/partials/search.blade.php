{{-- Search box. Expects $action (page to search), $q (current term) and $label. --}}
<form class="search" method="GET" action="{{ $action }}" role="search">
    <label class="sr-only" for="q">{{ $label }}</label>
    <input id="q" type="search" name="q" value="{{ $q }}" placeholder="{{ $label }}" maxlength="100">
    <button class="btn" type="submit">Search</button>
    @if ($q !== '')
        <a href="{{ $action }}">Clear</a>
    @endif
</form>
