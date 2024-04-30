<a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown"
    aria-expanded="false">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill"
        viewBox="0 0 16 16">
        <path
            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </svg>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{
        session()->get('cart') ? count(session()->get('cart')) : 0 }}</span>
</a>
<ul class="dropdown-menu">
    <li class="p-2 pb-0">
        <div class="d-flex justify-content-between">
            <strong>CARRINHO</strong>
            <button onclick="deleteCart()" class="btn btn-sm" style="color: #e2742b; padding: 0;"><i
                    class="bi bi-trash"></i></button>
        </div>
        <hr>
        @if (session()->get('cart'))
        @foreach (session()->get('cart') as $item)
        <div class="cart-item">
            {{ $item['product']['name'] }}{{ $item['variation'] ? ' (' . $item['variation'] . ')' : '' }}<br>€{{ !$item['product']['sales_price'] ? $item['product']['price'] : $item['product']['sales_price'] }} X {{ $item['quantity'] }}
        </div>
        @endforeach
        <div class="d-grid gap-2">
            <button onclick="goCart()" class="btn btn-sm btn-orange ">Checkout</button>
        </div>
        @else
        <p style="font-size: 13px;">Adicione o primeiro produto</p>
        @endif
    </li>
</ul>
