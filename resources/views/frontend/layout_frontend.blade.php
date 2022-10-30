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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
        integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .nice-select{
                width: 100%;
            }
            .nice-select.open .list {
                width: 100%;
            }
        </style>
    @stack('css')
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
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
    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('frontend/js/mixitup.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    <script type="text/javascript">
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

        $('#modal_signIn').on('click', function() {
            $('#show_signIn').addClass('d-none')
            $('#show_signUp').removeClass('d-none')
            $('#modal_footer-signIn').addClass('d-none')
            $('#modal_footer-signUp').removeClass('d-none')
            $('#show_forgot_password').addClass('d-none')
            $('#show_change_password').addClass('d-none')
        });
        $('#modal_signUp').on('click', function() {
            $('#show_signIn').removeClass('d-none')
            $('#show_signUp').addClass('d-none')
            $('#modal_footer-signIn').removeClass('d-none')
            $('#modal_footer-signUp').addClass('d-none')
            $('#show_forgot_password').addClass('d-none')
            $('#show_change_password').addClass('d-none')
        });
        $('#modal_forgot_password').on('click', function() {
            $('#show_signIn').addClass('d-none')
            $('#show_forgot_password').removeClass('d-none')
            $('#modal_footer-signIn').addClass('d-none')
            $('#modal_footer-signUp').removeClass('d-none')
            $('#show_change_password').addClass('d-none')
        });

        $(document).ready(function() {
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
                    localStorage.removeItem('data');
                }
            });
        });
    </script>
    @stack('js')
</body>

</html>
