<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        <p><i class="fa fa-phone" aria-hidden="true"></i> Hotline: <a class="text-light"
                                href="tel:{{ isset($about->phone) ? $about->phone : '' }}" title="Male fashion Hot Line"
                                rel="nofollow">{{ isset($about->phone) ? '0' . number_format($about->phone, 0, ',', '.') : '' }}</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            <div class="container-modal">
                                @if (session('sessionCustomerName') !== null)
                                    <div class="dropdown">
                                        <div class="text-capitalize" id="dropdownShow">Hi:
                                            {{ session('sessionCustomerName') }}.</div>
                                        <div class="dropdown-menu">
                                            <a href="#">
                                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                                <span class="text-capitalize">My Account</span>
                                            </a>
                                            <a href="{{ route('order_detail') }}">
                                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                <span class="text-capitalize">Order_detail</span>
                                            </a>
                                            <button class="logout">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                <span class="text-capitalize">Logout</span>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <button class="btn-menu" type="button" data-toggle="modal"
                                        data-target="#loginModal">
                                        Sign in
                                    </button>
                                @endif
                            </div>
                            <div class="modal fade pxp-user-modal" id="loginModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body" id="show_signIn">
                                            <div class="pxp-user-modal-fig text-center">
                                                <img src="{{ asset('frontend/img/signin-fig.png') }}" alt="Sign in">
                                            </div>
                                            <h5 class="modal-title text-center mt-4" id="signinModal">Welcome back!
                                            </h5>
                                            <form data-route="{{ route('handleLogin') }}" id="login-form"
                                                class="mt-4">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control" id="pxp-signin-email"
                                                        placeholder=" " name="emailUser">
                                                    <label class="label-input" for="pxp-signin-email">Email
                                                        address</label>
                                                    <span class="fa fa-envelope-o"></span>
                                                </div>
                                                <div class="form-floating mt-3">
                                                    <input type="password" class="form-control" id="pxp-signin-password"
                                                        placeholder=" " name="passwordUser">
                                                    <label class="label-input"
                                                        for="pxp-signin-password">Password</label>
                                                    <span class="fa fa-lock"></span>
                                                </div>
                                                <div class="mt-3 d-flex text-center pxp-modal-small">
                                                    <div class="col-6">
                                                        <div class="form-check mb-3 mb-md-0">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="remember" id="loginCheck"
                                                                style="cursor: pointer;">
                                                            <label class="form-check-label" for="loginCheck"
                                                                style="cursor: pointer;"> Remember
                                                                me </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <button role="button" class="pxp-modal-link" type="button"
                                                            data-toggle="modal" data-target="#modalForgotPassword"
                                                            data-dismiss="modal">Forgot
                                                            password?</button>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <button type="submit" id="submit-login"
                                                        class="btn rounded-pill pxp-modal-cta">Continue</button>
                                                </div>
                                                <div class="mt-3 text-center pxp-modal-small">
                                                    New to Account? <button role="button" class="pxp-modal-link"
                                                        type="button" data-toggle="modal" data-target="#signUpModal"
                                                        data-dismiss="modal">Create an
                                                        account</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade pxp-user-modal" id="signUpModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="pxp-user-modal-fig text-center">
                                                <img src="{{ asset('frontend/img/signup-fig.png') }}" alt="Sign up">
                                            </div>
                                            <h5 class="modal-title text-center mt-4" id="signupModal">Create an
                                                account</h5>
                                            <form data-route="{{ route('signUp') }}" id="signUp-form">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Your name...">
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control" id="email1"
                                                        placeholder="Your email address..." name="email">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" id="password1"
                                                        placeholder="Your password..." name="password">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="phone"
                                                        placeholder="Your phone...">
                                                </div>
                                                <div class="form-group">
                                                    <textarea name="address" class="form-control" placeholder="Your address..."></textarea>
                                                </div>
                                                <button type="submit" class="btn rounded-pill pxp-modal-cta p-1">Sign
                                                    Up</button>
                                            </form>
                                            <div class="mt-3 text-center pxp-modal-small">
                                                You had account? <button role="button" class="pxp-modal-link"
                                                    type="button" data-toggle="modal" data-target="#loginModal"
                                                    data-dismiss="modal">Sign In</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade pxp-user-modal" id="modalForgotPassword" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="pxp-user-modal-fig text-center">
                                                <img src="{{ asset('frontend/img/signup-fig.png') }}" alt="Sign up">
                                            </div>
                                            <h5 class="modal-title text-center mt-4">Forgot Password
                                            </h5>
                                            <form data-route="{{ route('forgotPassword') }}" id="forgot_password">
                                                <div class="form-floating mt-3 mb-3">
                                                    <input type="email" class="form-control"
                                                        id="pxp-forgot_password-email" placeholder=" "
                                                        name="emailReset">
                                                    <label class="label-input" for="pxp-forgot_password-email">Email
                                                        address</label>
                                                    <span class="fa fa-envelope-o"></span>
                                                </div>
                                                <button type="submit" id="forgot_password-btn"
                                                    class="btn rounded-pill pxp-modal-cta ">Send
                                                    password change mail</button>
                                            </form>
                                            <div class="mt-3 text-center pxp-modal-small">
                                                You had account? <button role="button" class="pxp-modal-link"
                                                    type="button" data-toggle="modal" data-target="#loginModal"
                                                    data-dismiss="modal">Sign In</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade pxp-user-modal" id="showChangePassword" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="pxp-user-modal-fig text-center">
                                                <img src="{{ asset('frontend/img/signup-fig.png') }}" alt="Sign up">
                                            </div>
                                            <h5 class="modal-title text-center mt-4" id="signupModal">Change Password
                                            </h5>
                                            <form data-route="{{ route('changePassword') }}" id="change_password">
                                                <div class="form-floating form-group form-error-code mt-3">
                                                    <input type="text" class="form-control"
                                                        id="pxp-change-password-code" placeholder=" " name="token">
                                                    <label class="label-input"
                                                        for="pxp-change-password-code">Code</label>
                                                </div>
                                                <div class="form-floating form-group form-error-pass mt-3">
                                                    <input type="password" class="form-control"
                                                        id="pxp-change-password" placeholder=" " name="newPassword">
                                                    <label class="label-input"
                                                        for="pxp-change-password">Password</label>
                                                </div>
                                                <button type="submit" id="change_password-btn"
                                                    class="btn rounded-pill pxp-modal-cta p-2">
                                                    Change password</button>
                                            </form>
                                            <div class="mt-3 text-center pxp-modal-small">
                                                You had account? <button role="button" class="pxp-modal-link"
                                                    type="button" data-toggle="modal" data-target="#loginModal"
                                                    data-dismiss="modal">Sign In</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('contact') }}">FAQs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 header-mobi">
                <div class="header__logo">
                    <a href="{{ route('index') }}"><img
                            src="{{ isset($about->logo) ? asset("storage/$about->logo") : '' }}" alt=""></a>
                </div>
                <div class="canvas__open"><i class="fa fa-bars"></i></div>
            </div>
            <div class="col-lg-6 col-md-6">
                @include('frontend.menu.index')
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <a href="#" class="search-switch"><img src="{{ asset('frontend/img/icon/search.png') }}"
                            alt=""></a>
                    <a href="#" class="favourite-icon"><img src="{{ asset('frontend/img/icon/heart.png') }}"
                            alt=""></a>
                    <a href="{{ route('cart') }}"><img src="{{ asset('frontend/img/icon/cart.png') }}"
                            alt="">
                        <span class="carts-total">{{ Cart::getTotalQuantity() }}</span></a>
                    <div class=" price"><span class="carts-price"
                            data-price="{{ Cart::getSubTotal() }}">{{ currency_format(Cart::getSubTotal()) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dropdownShow').on('click', function(e) {
                $(".dropdown-menu").toggleClass('show')
            })
            $('#signUp-form').on('submit', function(e) {
                e.preventDefault();
                let url = $(this).data('route');
                $(this).validate({
                    onfocusout: false,
                    onkeyup: false,
                    onclick: false,
                    rules: {
                        "name": {
                            required: true,
                            maxlength: 15
                        },
                        "email": {
                            required: true,
                            email: true
                        },
                        "password": {
                            required: true,
                            validatePassword: true,
                            minlength: 6
                        },
                        "phone": {
                            required: true,
                            validatePhone: true,
                        },
                        address: "required",
                    },
                    messages: {
                        "name": {
                            required: "Vui lòng nhập tên của bạn",
                            maxlength: "Nhập tối đa 15 kí tự"
                        },
                        "email": {
                            required: "Vui lòng nhập email của bạn",
                            email: "Eamil không đúng định dạng!!"
                        },
                        "password": {
                            required: "Vui lòng nhập mật khẩu của bạn"
                        },
                        "phone": {
                            required: "Vui lòng nhập số điện thoại của bạn",
                        },
                        "address": {
                            required: "Vui lòng nhập địa chỉ của bạn"
                        },
                    },
                    submitHandler: function(form) {
                        $('#signUp-form').prop("disabled", true);
                        var name = $("input[name=name]").val();
                        var email = $("input[name=email]").val();
                        var password = $("input[name=password]").val();
                        var phone = $("input[name=phone]").val();
                        var address = $("textarea[name=address]").val();
                        var _token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                name: name,
                                email: email,
                                password: password,
                                phone: phone,
                                address: address,
                                _token: _token
                            },
                            success: function(response, textStatus, xhr) {
                                $.toast({
                                    heading: 'Sign up!',
                                    text: (response),
                                    showHideTransition: 'slide',
                                    position: 'top-right',
                                    icon: 'success'
                                });
                                $("#signUp-form")[0].reset();
                            },
                            error: function(response) {
                                $("#signUp-login").prop("disabled", false);
                                $.toast({
                                    heading: 'Sign up!',
                                    text: (response.responseText),
                                    showHideTransition: 'slide',
                                    position: 'top-right',
                                    icon: 'warning'
                                });
                            }
                        });
                    }
                });
                $.validator.addMethod("validatePassword", function(value, element) {
                        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,16}$/i
                            .test(value);
                    },
                    "Hãy nhập password từ 6 đến 16 ký tự bao gồm chữ hoa, chữ thường và ít nhất một chữ số"
                );
                $.validator.addMethod("validatePhone", function(value, element) {
                    return this.optional(element) ||
                        /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/i.test(
                            value);
                }, "Vui lòng nhập đúng định dạng số điện thoại!!");

            });
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                var url = $(this).data('route');
                $(this).validate({
                    onfocusout: false,
                    onkeyup: false,
                    onclick: false,
                    rules: {
                        "emailUser": {
                            required: true,
                            email: true
                        },
                        "passwordUser": {
                            required: true,
                        },
                    },
                    messages: {
                        "emailUser": {
                            required: "Vui lòng nhập email của bạn",
                            email: "Email không đúng định dạng!!"
                        },
                        "passwordUser": {
                            required: "Vui lòng nhập mật khẩu của bạn"
                        },
                    },
                    submitHandler: function(form) {
                        $("#submit-login").prop("disabled", true);
                        var emailUser = $("input[name=emailUser]").val();
                        var passwordUser = $("input[name=passwordUser]").val();
                        var remember = $("input[name=remember]").serialize() ? true : false;
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                emailUser: emailUser,
                                passwordUser: passwordUser,
                                remember: remember,
                            },
                            success: function(response, textStatus, xhr) {
                                $.toast({
                                    heading: 'Log in!',
                                    text: (response),
                                    showHideTransition: 'slide',
                                    position: 'top-right',
                                    icon: 'success'
                                });
                                window.location.reload(true);
                            },
                            error: function(response) {
                                $("#submit-login").prop("disabled", false);
                                $("#login-form").find('input[type=password]').val(
                                    '');
                                $.toast({
                                    heading: 'Log in!',
                                    text: (response.responseText),
                                    showHideTransition: 'slide',
                                    position: 'top-right',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });

            });

            $("#forgot_password").on('submit', function(e) {
                e.preventDefault();
                $("#forgot_password-btn").prop("disabled", true);
                var url = $(this).data('route');
                var emailReset = $("input[name=emailReset]").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        emailReset: emailReset,
                    },
                    success: function(response, textStatus, xhr) {
                        $("#forgot_password").find("input[name=emailReset]").val('');
                        $('#modalForgotPassword').modal('hide');
                        $('#showChangePassword').modal('show');
                        $.toast({
                            heading: 'Change Password!',
                            text: (response),
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'success'
                        });
                        $("#forgot_password-btn").prop("disabled", false);
                    },
                    error: function(response, textStatus, xhr) {
                        $("#forgot_password").find("input[name=emailReset]").val('');
                        $("#forgot_password").find('.text-danger').remove();
                        $("#forgot_password").find('.form-group').append(
                            '<p class="text-danger ml-2 mt-3"></p>');
                        $("#forgot_password-btn").prop("disabled", false);
                        $("#forgot_password").find('.text-danger').text(response.responseText)
                            .show()
                            .fadeOut(2000);
                    }
                });
            });

            $("#change_password").on('submit', function(e) {
                e.preventDefault();
                $("#change_password-btn").prop("disabled", true);
                var url = $(this).data('route');
                var token = $("input[name=token]").val();
                var newPassword = $("input[name=newPassword]").val();
                if (token != '' && newPassword != '') {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            token: token,
                            newPassword: newPassword,
                        },
                        success: function(response, textStatus, xhr) {
                            if (xhr.status == 200) {
                                $("#change_password").find("input[name=token]").val('');
                                $("#change_password").find("input[name=newPassword]").val('');
                                $.toast({
                                    heading: 'Change Password!',
                                    text: (response),
                                    showHideTransition: 'slide',
                                    position: 'top-right',
                                    icon: 'success'
                                });
                                $("#change_password")[0].reset();
                                $("#change_password-btn").prop("disabled", false);
                                $('#showChangePassword').modal('hide');
                                $('#loginModal').modal('show');

                            }
                        },
                        error: function(response) {
                            $("#change_password")[0].reset();
                            $("#change_password").find('.text-danger').remove();
                            $("#change_password").find('.form-error-code').append(
                                '<p class="text-left text-danger ml-2 mt-1"></p>');
                            $("#change_password-btn").prop("disabled", false);
                            $("#change_password").find('.text-danger').text(response
                                .responseText).show().fadeOut(2000);
                        }
                    });
                } else {
                    $("#change_password")[0].reset();
                    $("#change_password").find('.text-danger').remove();
                    $("#change_password-btn").prop("disabled", false);
                }
                if (token == '') {
                    $("#change_password").find('.form-error-code').append(
                        '<p class="text-left text-danger ml-2 mt-1"></p>');
                    $("#change_password").find('.form-error-code').find('.text-danger').text(
                        'Vui lòng nhập code').show().fadeOut(
                        3000);
                }
                if (newPassword == '') {
                    $("#change_password").find('.form-error-pass').append(
                        '<p class="text-left text-danger ml-2 mt-1"></p>');
                    $("#change_password").find('.form-error-pass').find('.text-danger').text(
                            'Vui lòng nhập password mới').show()
                        .fadeOut(3000);
                }

            });

            $(".logout").click(function(e) {
                e.preventDefault();
                if (confirm("Are you sure you want to sign out!!")) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('logout') }}",
                        success: function(response, textStatus, xhr) {
                            $.toast({
                                heading: 'Log out!',
                                text: (response),
                                showHideTransition: 'slide',
                                position: 'top-right',
                                icon: 'success'
                            });
                            window.location.reload(true);
                        },

                    });
                }
            });

        });
    </script>
@endpush
