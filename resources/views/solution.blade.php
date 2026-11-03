<a href="/">Back to problems</a>
<h1>{{ $solution->name }}</h1>
<h2>Products and services</h2>
<ul>
    @foreach ($solution->products as $product)
        <li>
            {{ $product->name }} ({{ $product->vendor }}) -
            Tags: {{ $product->tags->pluck('name')->join(', ') }}
        </li>
    @endforeach
</ul>