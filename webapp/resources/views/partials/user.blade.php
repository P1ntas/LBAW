<div class="users1" class="color1">
    <div>
        <p class="pclass">{{ $user->name }}</p>
        <a href="/users/{{ $user->id }}/purchases">
            <iconify-icon icon="material-symbols:shopping-cart-outline-rounded" class="space"></iconify-icon>
        </a>
        <a href="/users/{{ $user->id }}/edit">
            <iconify-icon icon="mdi:pencil" class="space"></iconify-icon>
        </a>
    </div>
    <a href="/users/{{ $user->id }}">
        <img src="{{ URL::asset('images/avatar.jpg') }}" alt="bookPhoto" id="imgPurchase">
    </a>
</div>