<a href="{{ url('/keranjang') }}" class="floating-cart" aria-label="Buka keranjang belanja">
    <i class="bi bi-cart3" aria-hidden="true"></i>
    <span id="cart-count" class="floating-cart-count {{ collect(session('cart', []))->sum('quantity') > 0 ? '' : 'hidden' }}">
        {{ collect(session('cart', []))->sum('quantity') }}
    </span>
</a>
