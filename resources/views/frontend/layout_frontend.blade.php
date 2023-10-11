<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/animation.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/styles.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
        integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    @stack('css')
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- Favourite Menu Begin -->
    <div class="favourite_box">
        <div class="favourite_box--chevron">
            <div class="chevron"></div>
            <div class="chevron"></div>
            <div class="chevron"></div>
        </div>
        <div class="favourite_box--container" style="height: 100%;">
            <div class="favourite_container--title">
                <div style="display: flex; height:48px;padding: 12px;">
                    <div>Product</div>
                    <div>Total</div>
                </div>
            </div>
            <ul class="favourite_container--content"
                style="max-height: 100vh;
            overflow: auto;height: calc(100% - 48px - 34px);">
            </ul>
            <div class="favourite_container--footer">
                <div style="text-align: center;"><button>See details</button></div>
            </div>
        </div>
    </div>
    <!-- Favourite Menu End -->

    <div class="favourite" style="z-index: 999;position: fixed;right: 12px;top: 60px;">
        <div class="logo_favourite">
            <img src="{{ asset('frontend/img/logo_favourite.png') }}" alt="Image favourite">
            <button type="button" class="btn_favourite--close">
            </button>
        </div>
    </div>
    <!-- Offcanvas Menu Begin -->
    @include('frontend.partials.navbar')
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    @include('frontend.partials.header')
    <!-- Header Section End -->

    @yield('container')

    <!-- Footer Section Begin -->
    @include('frontend.partials.footer')
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins -->
    {{-- <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('frontend/js/mixitup.min.js') }}"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
        integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        var NotifiSuccess = "{{ session('success') ? session('success') : 'false' }}";
        if (NotifiSuccess !== 'false') {
            $.toast({
                heading: 'Success notification!',
                text: NotifiSuccess,
                showHideTransition: 'slide',
                position: 'top-right',
                icon: 'success'
            });
        }
        $('.signIn').on('click', function(e) {
            e.preventDefault();
            $.toast({
                heading: 'Sign in?',
                text: 'Vui lòng đăng nhập để sử dụng chức năng này!!',
                showHideTransition: 'slide',
                position: 'top-right',
                icon: 'success'
            })
        });

        function updateWishList() {
            $('.favourite_container--content').html('');
            if (Array.isArray(JSON.parse(localStorage.getItem('data')))) {
                for (let each of JSON.parse(localStorage.getItem('data'))) {
                    if (each.size) {
                        $('.favourite_container--content').append(
                            `<li><a href="${each.url}"><div class="" style="margin-right:12px;float: left;"><img src="${each.image}" alt="" width="62"></div><div class="" style="padding-top:0;height: 84px;display: flex;align-items: center;"><div style="padding-top:8px;"><h6 style="font-size:14px; margin-bottom:4px;">${each.name +  "(Size:"+ each.size + "," + each.color + ")"}</h6><h5 style="font-size:14px; "><span class="cart-price">${each.price}</span></h5></div></div><a></li>`
                        );
                    } else {
                        $('.favourite_container--content').append(
                            `<li><a href="${each.url}"><div class="" style="margin-right:12px;float: left;"><img src="${each.image}" alt="" width="62"></div><div class="" style="padding-top:0;height: 84px;display: flex;align-items: center;"><div style="padding-top:8px;"><h6 style="font-size:14px; margin-bottom:4px;">${each.name}</h6><h5 style="font-size:14px; "><span class="cart-price">${each.price}</span></h5></div></div><a></li>`
                        );
                    }

                }
            }
        }
        $(document).ready(function() {
            updateWishList();
            $('.button_wishlist').on('click', function(e) {
                let id = $(this).attr("data-id");
                let name = $('#wishlist_productname' + id).val();
                let image = $('#wishlist_productimage' + id).prop('src') ? $('#wishlist_productimage' + id)
                    .prop('src') : $('#wishlist_productimage' + id).attr("data-setbg");
                let url = $('#wishlist_producturl' + id).prop('href') ? $('#wishlist_producturl' + id).prop(
                    'href') : location.href;
                let size = $('.wishlist_productsize' + id).val() ? $('.wishlist_productsize' + id).val() :
                    false;
                let color = $('#wishlist_productcolor' + id).val() ? $('#wishlist_productcolor' + id)
                    .val() : false;
                let price = $('#wishlist_productprice' + id).val();
                let priceOld = $('#wishlist_productpriceold' + id).text() ? $('#wishlist_productpriceold' +
                    id).text() : false;

                let newItem = {
                    'url': url,
                    'id': id,
                    'name': name,
                    'image': image,
                    'size': size,
                    'color': color,
                    'price': price,
                    'priceOld': priceOld,
                };
                if (localStorage.getItem('data') == null) {
                    localStorage.setItem('data', '[]');
                }
                var old_data = JSON.parse(localStorage.getItem('data'));
                var item = old_data.find(item => item.id == id);
                if (item === undefined) {
                    old_data.push(newItem);
                    $.toast({
                        heading: 'Add ...!',
                        text: 'Bạn đã thêm vào mục yêu thích thành công rồi!!',
                        showHideTransition: 'slide',
                        position: 'top-right',
                        icon: 'success'
                    });
                    localStorage.setItem('data', JSON.stringify(old_data));
                } else {
                    alert('Bạn đã thêm vào mục yêu thích sản phẩm rồi!!');
                    const data_remove = old_data.filter(object => {
                        return object.id != id;
                    });
                    localStorage.setItem('data', JSON.stringify(data_remove));
                }
                updateWishList();
            });
            $('.btn_favourite--close').on('click', function(e) {
                $('.favourite').hide();
                e.stopPropagation();
            });
            $('.favourite-icon').on('click', function(e) {
                $('.favourite').show();
                $('.favourite_box').addClass('show');
            });
            $('.favourite_box--chevron').on('click', function(e) {
                $('.favourite_box').removeClass('show');
            });
            $('.logo_favourite').on('click', function(e) {
                $('.favourite_box').addClass('show');
            });

        });
    </script>
    @stack('js')
</body>

</html>
