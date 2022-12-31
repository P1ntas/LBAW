<article class="user" data-id="{{ $user->id }}">
    @if ($user->isBlocked())
        <p>This account is blocked!</p>
    @endif
    <img src="/storage/images/{{ $image->photo_image }}" alt="{{ $image->title }}">
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Address: {{ $user->user_address }}</p>
    <p>Phone: {{ $user->phone }}</p>
    <a href="/users/{{ $user->id }}/edit">Edit Profile</a>
</article>