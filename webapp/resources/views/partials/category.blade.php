<article class="category" data-id="{{ $category->id }}">
    <hr>
    <p>{{ $category->name }}</p>
    @if (Auth::user()->isAdmin())
        <form method="GET" action="/api/categories/{{ $category->id }}/remove">
            <input type="submit" value="Remove category">
        </form>
    @endif
</article>
