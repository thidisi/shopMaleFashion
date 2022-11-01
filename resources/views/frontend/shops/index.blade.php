@extends('frontend.layout_frontend')
@php
$title = 'Shop';
@endphp
@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <div class="breadcrumb__links">
                            <a href="{{ route('index') }}">Home</a>
                            @if (!empty($breadCrumb))
                                <a href="{{ route('shop') }}">Shop</a>
                                <span>{{ $breadCrumb }}</span>
                            @else
                                <span>Shop</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    @if (!empty($categories))
                                                        @foreach ($categories as $each)
                                                            <li><a href="#{{ $each->id }}">{{ $each->name }}
                                                                    ({{ $each->count }})
                                                                </a></li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                    <li><a href="#">$0.00 - $50.00</a></li>
                                                    <li><a href="#">$50.00 - $100.00</a></li>
                                                    <li><a href="#">$100.00 - $150.00</a></li>
                                                    <li><a href="#">$150.00 - $200.00</a></li>
                                                    <li><a href="#">$200.00 - $250.00</a></li>
                                                    <li><a href="#">250.00+</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseFour">Size</a>
                                    </div>
                                    <div id="collapseFour" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__size">
                                                <label for="xs">xs
                                                    <input type="radio" id="xs">
                                                </label>
                                                <label for="sm">s
                                                    <input type="radio" id="sm">
                                                </label>
                                                <label for="md">m
                                                    <input type="radio" id="md">
                                                </label>
                                                <label for="xl">xl
                                                    <input type="radio" id="xl">
                                                </label>
                                                <label for="2xl">2xl
                                                    <input type="radio" id="2xl">
                                                </label>
                                                <label for="xxl">xxl
                                                    <input type="radio" id="xxl">
                                                </label>
                                                <label for="3xl">3xl
                                                    <input type="radio" id="3xl">
                                                </label>
                                                <label for="4xl">4xl
                                                    <input type="radio" id="4xl">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseFive">Colors</a>
                                    </div>
                                    <div id="collapseFive" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__color">
                                                <label class="c-1" for="sp-1">
                                                    <input type="radio" id="sp-1">
                                                </label>
                                                <label class="c-2" for="sp-2">
                                                    <input type="radio" id="sp-2">
                                                </label>
                                                <label class="c-3" for="sp-3">
                                                    <input type="radio" id="sp-3">
                                                </label>
                                                <label class="c-4" for="sp-4">
                                                    <input type="radio" id="sp-4">
                                                </label>
                                                <label class="c-5" for="sp-5">
                                                    <input type="radio" id="sp-5">
                                                </label>
                                                <label class="c-6" for="sp-6">
                                                    <input type="radio" id="sp-6">
                                                </label>
                                                <label class="c-7" for="sp-7">
                                                    <input type="radio" id="sp-7">
                                                </label>
                                                <label class="c-8" for="sp-8">
                                                    <input type="radio" id="sp-8">
                                                </label>
                                                <label class="c-9" for="sp-9">
                                                    <input type="radio" id="sp-9">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    {{-- <p>Showing 1–12 of 126 results</p> --}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select class="niceSelect">
                                        <option value="">Low To High</option>
                                        <option value="">$0 - $55</option>
                                        <option value="">$55 - $100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (!empty($products))
                        <div class="row">
                            @foreach ($products as $product)
                                @php
                                    $productPrice = 1;
                                    if ($product->statusDiscount == 'active' && $product->discountPrice != null) {
                                        $productPrice = $product->discountPrice;
                                    }
                                    
                                    $date = $product->created_at;
                                    $date_end = Carbon\Carbon::now()->addDays(-7);
                                @endphp
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item sale">
                                        <div class="product__item__pic set-bg"
                                            id="wishlist_productimage{{ $product->id }}"
                                            @if ($product->statusImage == ACTIVE) data-setbg="{{ asset("storage/$product->image") }}" @endif>
                                            @if ($product->discountPrice != null && $product->statusDiscount == 'active')
                                                <span class="item-sale">
                                                    -{{ (1 - $product->discountPrice) * 100 }}%</span>
                                            @endif
                                            @if ($date >= $date_end)
                                                <span class="label">New</span>
                                            @endif
                                            <ul class="product__hover">
                                                <li>
                                                    <button class="button_wishlist border-0 p-0 bg-gradient-light"
                                                        {{-- style="background-color: initial;" --}}
                                                        data-id="{{ $product->id }}"><img
                                                            src="{{ asset('frontend/img/icon/heart.png') }}"
                                                            alt=""></button>
                                                </li>
                                                <li><a href="#"><img
                                                            src="{{ asset('frontend/img/icon/compare.png') }}"
                                                            alt="">
                                                        <span>Compare</span></a>
                                                </li>
                                                <li><a id="wishlist_producturl{{ $product->id }}"
                                                        href="{{ route('productDetail', Str::slug($product->name, '-')) }}"><img
                                                            src="{{ asset('frontend/img/icon/search.png') }}"
                                                            alt=""></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <input type="hidden" id="wishlist_productname{{ $product->id }}"
                                            value="{{ $product->name }}">
                                        <div class="product__item__text">
                                            <h6>{{ $product->name }}</h6>
                                            <a href="{{ route('productDetail', Str::slug($product->name, '-')) }}"
                                                class="add-cart">+ Mua
                                                ngay</a>
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa @if ($i <= $product->review) fa-star star @else fa-star-o @endif"></i>
                                                @endfor
                                            </div>
                                            <h5>
                                                {{ currency_format($product->price * $productPrice) }}
                                                @if ($product->discountPrice != null && $product->statusDiscount == 'active')
                                                    <em id="wishlist_productpriceold{{ $product->id }}"
                                                        style="text-decoration:line-through">{{ currency_format($product->price) }}</em>
                                                @endif
                                            </h5>
                                            <input type="hidden" id="wishlist_productprice{{ $product->id }}"
                                                value="{{ currency_format($product->price * $productPrice) }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product__pagination">
                                    {{ $products->render('pagination::semantic-ui') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection
