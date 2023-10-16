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
                                <span>{{ $breadCrumb->name }}</span>
                                <input type="hidden" name="breadCrumb" value="{{ $breadCrumb->slug }}">
                            @else
                                <span>Shop</span>
                                <input type="hidden" name="breadCrumb" value="">
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
                                                        @foreach ($categories as $key => $each)
                                                            <li>
                                                                <label for="category_{{ $key }}">
                                                                    <a>
                                                                        {{ $each->name }}({{ $each->count }})
                                                                    </a>
                                                                    <input class="filter" hidden type="checkbox"
                                                                        name="categories" value="{{ $each->id }}"
                                                                        id="category_{{ $key }}">
                                                                </label>
                                                            </li>
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
                                                    @foreach ($filter_price_list as $key => $price)
                                                        <li>
                                                            <label for="price_{{ $key }}">
                                                                <a>{{ $price }}</a>
                                                                <input class="filter" hidden type="checkbox" name="price"
                                                                    value="{{ $key }}"
                                                                    id="price_{{ $key }}">
                                                            </label>
                                                        </li>
                                                    @endforeach
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
                                                    <input type="radio" name="size" value="" id="xs">
                                                </label>
                                                <label for="sm">s
                                                    <input type="radio" name="size" value="" id="sm">
                                                </label>
                                                <label for="md">m
                                                    <input type="radio" name="size" value="" id="md">
                                                </label>
                                                <label for="xl">xl
                                                    <input type="radio" name="size" value="" id="xl">
                                                </label>
                                                <label for="2xl">2xl
                                                    <input type="radio" name="size" value="" id="2xl">
                                                </label>
                                                <label for="xxl">xxl
                                                    <input type="radio" name="size" value="" id="xxl">
                                                </label>
                                                <label for="3xl">3xl
                                                    <input type="radio" name="size" value="" id="3xl">
                                                </label>
                                                <label for="4xl">4xl
                                                    <input type="radio" name="size" value="" id="4xl">
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
                                                @foreach ($filter_color_list as $key => $color)
                                                    <label class="{{ $color->slug }}" for="color_{{ $key }}">
                                                        <input class="filter" type="checkbox" name="color"
                                                            id="color_{{ $key }}" value="{{ $color->slug }}">
                                                    </label>
                                                @endforeach
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
                                {{-- <div class="shop__product__option__left">
                                    <p>Showing 1–12 of 126 results</p>
                                </div> --}}
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select class="niceSelect filter">
                                        <option disabled selected="selected" hidden>Low To High</option>
                                        <option value="DESC">Down</option>
                                        <option value="ASC">High</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (!empty($products))
                        <div class="row" id="productList">
                            @foreach ($products as $each)
                                @php
                                    $date = $each->created_at;
                                    $date_end = Carbon\Carbon::now()->addDays(-7);
                                @endphp
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item sale">
                                        <div class="product__item__pic set-bg"
                                            id="wishlist_productimage{{ $each->id }}"
                                            @if ($each->product_images->status == 'active') data-setbg="{{ asset("storage/$each->image") }}" @endif>
                                            @if ($each->quantity <= 0 && $each->product_images->status == 'active')
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
                                                        {{-- style="background-color: initial;" --}} data-id="{{ $each->id }}"><img
                                                            src="{{ asset('frontend/img/icon/heart.png') }}"
                                                            alt=""></button>
                                                </li>
                                                <li><a href="#"><img
                                                            src="{{ asset('frontend/img/icon/compare.png') }}"
                                                            alt="">
                                                        <span>Compare</span></a>
                                                </li>
                                                <li><a id="wishlist_producturl{{ $each->id }}"
                                                        href="{{ route('productDetail', Str::slug($each->name, '-')) }}"><img
                                                            src="{{ asset('frontend/img/icon/search.png') }}"
                                                            alt=""></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <input type="hidden" id="wishlist_productname{{ $each->id }}"
                                            value="{{ $each->name }}">
                                        <div class="product__item__text">
                                            <h6>{{ $each->name }}</h6>
                                            <a href="{{ route('productDetail', Str::slug($each->name, '-')) }}"
                                                class="add-cart">+ Add
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
@push('js')
    <script type="text/javascript">
        function get_data_filter_jobs() {
            var checkSize = $("input[name='size']:checked"); // returns object of checkeds.
            var size = []
            for (var i = 0; i < checkSize.length; i++) {
                size.push($(checkSize[i]).val())
            };

            var checkColor = $("input[name='color']:checked"); // returns object of checkeds.
            var color = []
            for (var i = 0; i < checkColor.length; i++) {
                color.push($(checkColor[i]).val())
            };

            var checkCategories = $("input[name='categories']:checked"); // returns object of checkeds.
            var categories = []
            for (var i = 0; i < checkCategories.length; i++) {
                categories.push($(checkCategories[i]).val())
            };

            var checkPrice = $("input[name='price']:checked"); // returns object of checkeds.
            var price = []
            for (var i = 0; i < checkPrice.length; i++) {
                price.push($(checkPrice[i]).val())
            };

            let data = [];
            data['categories'] = categories;
            data['price'] = price;
            data['color'] = color;
            data['order_by'] = $('.niceSelect').val();
            // data['size'] = size;
            data['menu_slug'] = $("input[name='breadCrumb']").val();
            return data;
        }

        function api_data(url, categories, price, color, order_by, menu_slug) {
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    categories: categories,
                    price: price,
                    color: color,
                    order_by: order_by,
                    menu_slug: menu_slug,
                },
                dataType: "JSON",
                success: function(response) {
                    $('#productList').html('');
                    $('.product__pagination').html('');
                    response.products.data.forEach((element, index) => {
                        var url = response.url + '/' + element.slug + '.html';
                        var date = element.created_at;
                        var date_end = "{{ Carbon\Carbon::now()->addDays(-7) }}";
                        var image_status = '';
                        if (element.product_images.status == 'active') {
                            var image_status =
                                `data-setbg="${ response.url + '/storage/' + element.image}"`;
                        }
                        var empty_product = '';
                        if (element.quantity <= 0 && element.product_images.status == 'active') {
                            empty_product =
                                `<div style=" background-color: #ffffff5e; position: absolute; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; font-weight: 700; color: #0d0d0d; font-size: 1.6rem;"> Hết hàng</div>`;
                        }
                        var sale_product = '';
                        if (element.discount != 1 && element.discountStatus == 'active') {
                            sale_product =
                                `<span class="item-sale">-${ Math.round((1 - element.discount) * 100) }%</span>`;
                        }
                        var new_product = '';
                        if (date >= date_end) {
                            new_product = `<span class="label">New</span>`;
                        }
                        var rating = '';
                        var star = '';
                        for (let i = 1; i <= 5; i++) {
                            if (i <= element.review) {
                                star = 'fa-star star';
                            } else {
                                star = 'fa-star-o';
                            }
                            rating += `<i class="fa ${star}"></i> `;
                        }
                        var price_total = element.price * element.discount;
                        price_total = price_total.toLocaleString('vi', {
                            style: 'currency',
                            currency: 'VND'
                        });
                        var price = element.price;
                        price = price.toLocaleString('vi', {
                            style: 'currency',
                            currency: 'VND'
                        });
                        var price_old = '';
                        if (element.discount != 1 && element.discountStatus == 'active') {
                            price_old =
                                `<em id="wishlist_productpriceold${element.id}" style="text-decoration:line-through">${price}</em>`;
                        }
                        $('#productList').append(
                            `<div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item sale">
                                        <div class="product__item__pic set-bg"
                                            id="wishlist_productimage${element.id}" ${image_status} >
                                            ${empty_product}
                                            ${sale_product}
                                            ${new_product}
                                            <ul class="product__hover">
                                                <li>
                                                    <button class="button_wishlist button_wishlists border-0 p-0 bg-gradient-light" data-id="${element.id}"><img
                                                            src="${response.url + '/frontend/img/icon/heart.png'}"
                                                            alt=""></button>
                                                </li>
                                                <li><a href="#"><img
                                                            src="${response.url + '/frontend/img/icon/compare.png'}"
                                                            alt="">
                                                        <span>Compare</span></a>
                                                </li>
                                                <li><a id="wishlist_producturl${element.id}"
                                                        href="${url}"><img
                                                            src="${response.url + '/frontend/img/icon/search.png'}"
                                                            alt=""></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <input type="hidden" id="wishlist_productname${element.id}"
                                            value="${element.name}">
                                        <div class="product__item__text">
                                            <h6>${element.name}</h6>
                                            <a href="${url}"
                                                class="add-cart">+ Add
                                                To Cart</a>
                                            <div class="rating">
                                                ${rating}
                                            </div>
                                            <h5>
                                                ${price_total}
                                                ${price_old}
                                            </h5>
                                            <input type="hidden" id="wishlist_productprice${element.id}"
                                                value="${price_total}">
                                        </div>
                                    </div>
                                </div>`
                        );
                        $('.set-bg').each(function() {
                            var bg = $(this).data('setbg');
                            $(this).css('background-image', 'url(' + bg + ')');
                        });
                    });
                    let pagination = response.products.links;
                    pagination[0]['label'] = '&laquo;';
                    pagination.at(-1)['label'] = '&raquo;';
                    if (response.products.data.length > 0) {
                        var pagination_box =
                            `<div class="ui pagination menu justify-content-center" role="navigation">`;
                        pagination.forEach((each, index) => {
                            pagination_box +=
                                `<li class="page-item ${each.active ? 'active' : ''}"><button class="${each.active ? 'active' : ''} page-link" data-page="${ each.url }">${ each.label }</button></li>`
                        });
                        pagination_box += "</div>";
                        $('.product__pagination').append(pagination_box);
                    }
                }
            });
        }
        $(document).ready(function() {
            $(document).on('change', ".filter", function() {
                let resuft = get_data_filter_jobs();
                api_data("{{ route('products.filter') }}", resuft['categories'], resuft['price'], resuft[
                    'color'], resuft['order_by'], resuft['menu_slug'])
            })

            $(document).on('click', '.pagination > li > button', function(event) {
                event.preventDefault();
                let resuft = get_data_filter_jobs();
                api_data($(this).data('page'), resuft['categories'], resuft['price'], resuft[
                    'color'], resuft['order_by'], resuft['menu_slug'])
                let url = window.location.href;
                url = url.split('?')[0];
                history.pushState({}, '', url);
            });
        });
    </script>
@endpush
