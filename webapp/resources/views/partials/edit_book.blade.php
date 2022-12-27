<article class="book" data-id="{{ $book->id }}">
    <form method="POST" action="/api/books/{{$book->id}}/edit">
        {{ csrf_field() }}

        <label for="title">Title</label>
        <input id="title" type="text" name="title" value="{{$book->name}}">
        @if ($errors->has('title'))
        <span class="error">
            {{ $errors->first('title') }}
        </span>
        @endif

        <label for="isbn">ISBN</label>
        <input id="isbn" type="text" name="isbn" value="{{$book->isbn}}">
        @if ($errors->has('isbn'))
        <span class="error">
            {{ $errors->first('isbn') }}
        </span>
        @endif

        <label for="year">Year</label>
        <input id="year" type="text" name="year" value="{{$book->year}}">
        @if ($errors->has('year'))
        <span class="error">
            {{ $errors->first('year') }}
        </span>
        @endif

        <label for="price">Price</label>
        <input id="price" type="text" name="price" value="{{$book->price}} €">
        @if ($errors->has('price'))
        <span class="error">
            {{ $errors->first('price') }}
        </span>
        @endif

        <label for="stock">Stock</label>
        <input id="stock" type="text" name="stock" value="{{$book->stock}} units">
        @if ($errors->has('stock'))
        <span class="error">
            {{ $errors->first('stock') }}
        </span>
        @endif

        <label for="book_edition">Edition</label>
        <input id="book_edition" type="text" name="book_edition" value="{{$book->book_edition}}">
        @if ($errors->has('book_edition'))
        <span class="error">
            {{ $errors->first('book_edition') }}
        </span>
        @endif

        <label for="book_description">Description</label>
        <input id="book_description" type="text" name="book_description" value="{{$book->book_description}}">
        @if ($errors->has('book_description'))
        <span class="error">
            {{ $errors->first('book_description') }}
        </span>
        @endif
        <label for="category">Category</label>
        <input id="category" type="text" name="category" value="{{$category->name}}">
        @if ($errors->has('category_id'))
        <span class="error">
            {{ $errors->first('category_id') }}
        </span>
        @endif

        <label for="publisher">Publisher</label>
        <input id="publisher" type="text" name="publisher" value="{{$publisher->name}}">
        @if ($errors->has('publisher'))
        <span class="error">
            {{ $errors->first('publisher') }}
        </span>
        @endif

        <label for="author">Author(s)</label>
        <input id="author" type="text" name="author" value="{{$author->name}}">
        @if ($errors->has('author'))
        <span class="error">
            {{ $errors->first('author') }}
        </span>
        @endif


        <input type="hidden" name="blocked" value="FALSE">

        <button type="submit">Confirm</button>
        <a class="button button-outline" href="/books/{{$book->id}}">Cancel</a>
    </form>
</article>