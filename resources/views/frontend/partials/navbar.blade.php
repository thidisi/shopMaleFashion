<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="offcanvas__option">
        <div class="offcanvas__links">
            @if (session('sessionCustomerName') !== null)
                <div class="text-capitalize text-dark mr-2" style="display: inline-block;">Hi:
                    {{ session('sessionCustomerName') }}.
                </div>
            @else
                <button class="btn-menu text-dark" type="button" data-toggle="modal" data-target="#loginModal">
                    Sign in
                </button>
            @endif
            {{-- <a href="#">FAQs</a> --}}
        </div>
        {{-- <div class="offcanvas__top__hover">
            <span>Usd <i class="arrow_carrot-down"></i></span>
            <ul>
                <li>USD</li>
                <li>EUR</li>
                <li>USD</li>
            </ul>
        </div> --}}
    </div>
    <div class="offcanvas__nav__option">
        <a href="#" class="search-switch"><img src="{{ asset('frontend/img/icon/search.png') }}"
                alt=""></a>
        <a href="#"><img src="{{ asset('frontend/img/icon/heart.png') }}" alt=""></a>
        <a href="{{ route('cart') }}"><img src="{{ asset('frontend/img/icon/cart.png') }}" alt="">
            <span class="carts-total_mobi">{{ Cart::getTotalQuantity() }}</span></a>
        <div class=" price">$<span class="carts-price_mobi">{{ Cart::getSubTotal() }}</span></div>
    </div>
    <div id="mobile-menu-wrap"></div>
    <div class="offcanvas__text ">
        <p><i class="fa fa-phone" aria-hidden="true"></i> Hotline: <a class="text-dark" href="tel:{{ $about->phone }}"
                title="Male fashion Hot Line" rel="nofollow">{{ $about->phone }}</a></p>

        @if (session('sessionCustomerName') !== null)
            <button class="btn logout">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <span class="text-capitalize">Logout</span>
            </button>
        @else
            <button class="btn btn-menu text-dark" type="button" data-toggle="modal" data-target="#loginModal">
                <i class="fa fa-sign-in" aria-hidden="true"></i>
                Sign in
            </button>
        @endif
    </div>
</div>
