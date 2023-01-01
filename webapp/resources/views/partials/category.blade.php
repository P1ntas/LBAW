<li>
    <form method="POST" action="/books/filter">
        @csrf
        <input type="submit" name="category" value="{{ $category->name }}">
    </form>
    @if (Auth::check() && Auth::user()->isAdmin())
        <button onclick="showInput({{ $category->id }})">
            <iconify-icon icon="mdi:pencil"></iconify-icon>
        </button>
        <form id="edit-{{ $category->id }}" style="display:none;" 
        onsubmit="updateCategory({{ $category->id }}); return false;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" id="category-{{ $category->id }}" required>
            <button type="submit">Save</button>
        </form>
        <form method="POST" action="/categories/{{ $category->id }}/remove">
            @csrf
            @method('DELETE')
            <button type="submit" 
            onclick="return confirm('This action will delete all books from this category. Proceed?');">
                <iconify-icon icon="ion:trash-outline" class="trash"></iconify-icon>
            </button>
        </form>
    @endif
</li>