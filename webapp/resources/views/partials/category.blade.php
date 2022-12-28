<article>
    <form method="POST" action="/books/filter">
        {{ csrf_field() }}
        <input type="submit" name="category" value="{{ $category->name }}">
    </form>
</article>