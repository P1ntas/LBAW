<article class="user" data-id="{{ $user->id }}">
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Address: {{ $user->user_address }}</p>
    <p>Phone: {{ $user->phone }}</p>
    <a href="/users/{{ $user->id }}/edit">Edit Profile</a>
</article>