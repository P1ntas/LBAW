<article>
    <form method="POST" action="/books/filter">
        @csrf
        <input type="submit" name="category" value="{{ $category->name }}">
    </form>
</article>