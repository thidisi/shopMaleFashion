<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">Best Sellers</li>
                    <li data-filter=".new-arrivals">New Arrivals</li>
                    <li data-filter=".hot-sales">Hot Sales</li>
                </ul>
            </div>
        </div>
        <div class="row product__filter">
            @if (!empty($products) > 0)
                @foreach ($products as $each)
                    @php
                        $date = $each->created_at;
                        $date_end = Carbon\Carbon::now()->addDays(-7);
                    @endphp
                    <div
                        class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix @if ($each->discount != 1 && $each->discountStatus == 'active') hot-sales @endif @if ($date >= $date_end) new-arrivals @endif">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" id="wishlist_productimage{{ $each->id }}"
                                @if ($each->product_images->status == 'active') data-setbg="{{ asset("storage/$each->image") }}" @endif>
                                @if ($each->quantity <= 0 && $each->discountStatus == 'active')
                                    <div
                                        style="
                            background-color: #ffffff5e;
                            position: absolute;
                            width: 100%;
                            height: 100%;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            font-weight: 700;
                            color: #0d0d0d;
                            font-size: 1.6rem;">
                                        Hết hàng</div>
                                @endif
                                @if ($each->discount != 1 && $each->discountStatus == 'active')
                                    <span class="item-sale">-{{ (1 - $each->discount) * 100 }}%</span>
                                @endif
                                @if ($date >= $date_end)
                                    <span class="label">New</span>
                                @endif
                                <ul class="product__hover">
                                    <li>
                                        <button class="button_wishlist border-0 p-0 bg-gradient-light"
                                            data-id="{{ $each->id }}"><img
                                                src="{{ asset('frontend/img/icon/heart.png') }}"
                                                alt=""></button>
                                    </li>
                                    <li><a href="#"><img src="{{ asset('frontend/img/icon/compare.png') }}"
                                                alt="">
                                            <span>Compare</span></a></li>
                                    <li><a id="wishlist_producturl{{ $each->id }}"
                                            href="{{ route('productDetail', Str::slug($each->name, '-')) }}"><img
                                                src="{{ asset('frontend/img/icon/search.png') }}" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" id="wishlist_productname{{ $each->id }}"
                                value="{{ $each->name }}">
                            <div class="product__item__text">
                                <h6>{{ $each->name }}</h6>
                                <a href="{{ route('productDetail', Str::slug($each->name, '-')) }}" class="add-cart">+
                                    Add
                                    To Cart</a>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fa @if ($i <= $each->review) fa-star star @else fa-star-o @endif"></i>
                                    @endfor
                                </div>
                                <h5>
                                    {{ currency_format($each->price * $each->discount) }}
                                    @if ($each->discount != 1 && $each->discountStatus == 'active')
                                        <em id="wishlist_productpriceold{{ $each->id }}"
                                            style="text-decoration:line-through">{{ currency_format($each->price) }}</em>
                                    @endif
                                </h5>
                                <input type="hidden" id="wishlist_productprice{{ $each->id }}"
                                    value="{{ currency_format($each->price * $each->discount) }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- Product Section End -->
