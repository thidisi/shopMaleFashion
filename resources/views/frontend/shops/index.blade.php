@extends('frontend.layout_frontend')
@php
    $title = 'Shop';
@endphp
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/custom_paginate.css') }}" type="text/css">
@endpush
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
                            <form>
                                <input type="text" name="search" placeholder="Search...">
                                <button type="button" id="search_product"><span class="icon_search"></span></button>
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
                                                                        id="category_{{ $key }}"
                                                                        style="pointer-events:auto;">
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
                                                                <input class="filter" hidden type="radio" name="price"
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
                    <div class="row" id="productList">
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection
@push('js')
    <script type="text/javascript">
        function get_data_filter_jobs() {
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
            data['search'] = $("input[name='search']").val();
            return data;
        }

        function api_data(url, categories, price, color, order_by, menu_slug, search) {
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    categories: categories,
                    price: price,
                    color: color,
                    order_by: order_by,
                    menu_slug: menu_slug,
                    search: search,
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
                                                <li class="button_wishlists">
                                                    <button class="button_wishlist border-0 p-0 bg-gradient-light" data-id="${element.id}"><img
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

        function get_data(search) {
            if(search != null){
                $("input[name='search']").val(search);
            }
            let resuft = get_data_filter_jobs();
            api_data("{{ route('products.filter') }}", resuft['categories'], resuft['price'], resuft[
                'color'], resuft['order_by'], resuft['menu_slug'], resuft['search']);
        }
        $(document).ready(function() {
            let searchParams = new URLSearchParams(window.location.search)
            get_data(searchParams.get('search'));
            $(".filter").change(function() {
                get_data();
            });
            $("body").on('click', '.pagination > li > button', function(event) {
                event.preventDefault();
                get_data();
                let url = window.location.href;
                url = url.split('?')[0];
                history.pushState({}, '', url);
            });
            $("body").on('click', '.shop__sidebar__price label', function(e) {
                $('.shop__sidebar__price label.active').removeClass("active");
                $(this).addClass("active");
            });
            $(".shop__sidebar__search button").click(function(e) {
                e.preventDefault();
                get_data();
            })
            $('.shop__sidebar__categories label').change(function() {
                $(this).toggleClass('active');
            });
            $('.shop__sidebar__color label').change(function() {
                $(this).toggleClass('active');
            });
        });
    </script>
@endpush
