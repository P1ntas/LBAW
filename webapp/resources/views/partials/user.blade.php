<article class="user" data-id="{{ $user->id }}">
    <a href="/users/{{ $user->id }}">{{ $user->name }}</a>
    <p>Email: {{ $user->email }}</p>
</article>