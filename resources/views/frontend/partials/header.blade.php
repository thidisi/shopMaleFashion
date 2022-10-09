<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        <p><i class="fa fa-phone" aria-hidden="true"></i> Hotline: <a class="text-light" href="tel:{{ $about->phone }}" title="Male fashion Hot Line" rel="nofollow">0{{ number_format($about->phone, 0, ',', '.') }}</a></p>
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
                                <button class="btn-menu" type="button" data-toggle="modal" data-target="#loginModal">
                                    Sign in
                                </button>
                                @endif
                            </div>
                            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom-0">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="show_signIn">
                                            <div class="form-title text-center">
                                                <h4>Login</h4>
                                            </div>
                                            <div class="d-flex flex-column text-center">
                                                <form data-route="{{ route('handleLogin') }}" id="login-form">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" placeholder="Your email address..." name="emailUser">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" class="form-control" placeholder="Your password..." name="passwordUser">
                                                    </div>
                                                    <div class="form-group row mt-1">
                                                        <div class="col-md-6 d-flex justify-content-center">
                                                            <div class="form-check mb-3 mb-md-0">
                                                                <input class="form-check-input" type="checkbox" name="remember" id="loginCheck" style="cursor: pointer;">
                                                                <label class="form-check-label" for="loginCheck" style="cursor: pointer;"> Remember
                                                                    me </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex justify-content-center">
                                                            <button type="button" id="modal_forgot_password" class="text-primary" style="border: none;
                                                            outline: none;background-color: initial;">Forgot
                                                                password ?</button>
                                                        </div>
                                                    </div>
                                                    <button type="submit" id="submit-login" class="btn btn-info btn-block btn-round">Login</button>
                                                </form>

                                                <div class="text-center text-muted delimiter">or use a social
                                                    network
                                                </div>
                                                <div class="d-flex justify-content-center social-buttons">
                                                    <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip" data-placement="top" title="Twitter">
                                                        <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip" data-placement="top" title="Facebook">
                                                        <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip" data-placement="top" title="Linkedin">
                                                        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body d-none" id="show_signUp">
                                            <div class="form-title text-center">
                                                <h4>Sign Up</h4>
                                            </div>
                                            <div class="d-flex flex-column text-center">
                                                <form data-route="{{ route('signUp') }}" id="signUp-form">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="name" placeholder="Your name...">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" id="email1" placeholder="Your email address..." name="email">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" class="form-control" id="password1" placeholder="Your password..." name="password">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="phone" placeholder="Your phone...">
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea name="address" class="form-control" placeholder="Your address..."></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-info btn-block">Sign
                                                        Up</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-body d-none" id="show_forgot_password">
                                            <div class="form-title text-center">
                                                <h4>Forgot Password</h4>
                                            </div>
                                            <div class="d-flex flex-column text-center">
                                                <form data-route="{{ route('forgotPassword') }}" id="forgot_password">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="emailReset">
                                                    </div>
                                                    <button type="submit" id="forgot_password-btn" class="btn btn-info btn-block">Send
                                                        password change mail</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-body d-none" id="show_change_password">
                                            <div class="form-title text-center">
                                                <h4>Changer Password</h4>
                                            </div>
                                            <div class="d-flex flex-column text-center">
                                                <form data-route="{{ route('changePassword') }}" id="change_password">
                                                    @csrf
                                                    <div class="form-group form-error">
                                                        <input type="text" class="form-control" placeholder="Code..." name="token">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" class="form-control" placeholder="Enter Change Password..." name="newPassword">
                                                    </div>
                                                    <button type="submit" id="change_password-btn" class="btn btn-info btn-block">
                                                        Change password</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <div class="signup-section" id="modal_footer-signIn">You have no
                                                account?
                                                <a class="text-info" type="button" id="modal_signIn">Sign Up</a>
                                            </div>
                                            <div class="signup-section d-none" id="modal_footer-signUp">You had
                                                account?
                                                <a class="text-info" type="button" id="modal_signUp">Sign In</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">FAQs</a>
                        </div>
                        <div class="header__top__hover">
                            <span>Usd <i class="arrow_carrot-down"></i></span>
                            <ul>
                                <li>USD</li>
                                <li>EUR</li>
                                <li>USD</li>
                            </ul>
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
                    <a href="{{ route('index') }}"><img src="{{ asset("storage/$about->logo") }}" alt=""></a>
                </div>
                <div class="canvas__open"><i class="fa fa-bars"></i></div>
            </div>
            <div class="col-lg-6 col-md-6">
                @include('frontend.menu.index')
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <a href="#" class="search-switch"><img src="{{ asset('frontend/img/icon/search.png') }}" alt=""></a>
                    <a href="#"><img src="{{ asset('frontend/img/icon/heart.png') }}" alt=""></a>
                    <a href="{{ route('cart') }}"><img src="{{ asset('frontend/img/icon/cart.png') }}" alt="">
                        <span class="carts-total">{{ Cart::getTotalQuantity() }}</span></a>
                    <div class=" price"><span class="carts-price" data-price="{{ Cart::getSubTotal() }}">{{ currency_format(Cart::getSubTotal()) }}</span>
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
                onfocusout: false
                , onkeyup: false
                , onclick: false
                , rules: {
                    "name": {
                        required: true
                        , maxlength: 15
                    }
                    , "email": {
                        required: true
                        , email: true
                    }
                    , "password": {
                        required: true
                        , validatePassword: true
                        , minlength: 6
                    }
                    , "phone": {
                        required: true
                        , validatePhone: true
                    , }
                    , address: "required"
                , }
                , messages: {
                    "name": {
                        required: "Vui lòng nhập tên của bạn"
                        , maxlength: "Nhập tối đa 15 kí tự"
                    }
                    , "email": {
                        required: "Vui lòng nhập email của bạn"
                        , email: "Eamil không đúng định dạng!!"
                    }
                    , "password": {
                        required: "Vui lòng nhập mật khẩu của bạn"
                    }
                    , "phone": {
                        required: "Vui lòng nhập số điện thoại của bạn"
                    , }
                    , "address": {
                        required: "Vui lòng nhập địa chỉ của bạn"
                    }
                , }
                , submitHandler: function(form) {
                    $('#signUp-form').prop("disabled", true);
                    var name = $("input[name=name]").val();
                    var email = $("input[name=email]").val();
                    var password = $("input[name=password]").val();
                    var phone = $("input[name=phone]").val();
                    var address = $("textarea[name=address]").val();
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST"
                        , url: url
                        , data: {
                            name: name
                            , email: email
                            , password: password
                            , phone: phone
                            , address: address
                            , _token: _token
                        }
                        , success: function(response, textStatus, xhr) {
                            $.toast({
                                heading: 'Sign up!'
                                , text: (response)
                                , showHideTransition: 'slide'
                                , position: 'top-right'
                                , icon: 'success'
                            });
                            $("#signUp-form")[0].reset();
                        }
                        , error: function(response) {
                            $("#signUp-login").prop("disabled", false);
                            $.toast({
                                heading: 'Sign up!'
                                , text: (response.responseText)
                                , showHideTransition: 'slide'
                                , position: 'top-right'
                                , icon: 'warning'
                            });
                        }
                    });
                }
            });
            $.validator.addMethod("validatePassword", function(value, element) {
                    return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,16}$/i
                        .test(value);
                }
                , "Hãy nhập password từ 6 đến 16 ký tự bao gồm chữ hoa, chữ thường và ít nhất một chữ số"
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
                onfocusout: false
                , onkeyup: false
                , onclick: false
                , rules: {
                    "emailUser": {
                        required: true
                        , email: true
                    }
                    , "passwordUser": {
                        required: true
                    , }
                , }
                , messages: {
                    "emailUser": {
                        required: "Vui lòng nhập email của bạn"
                        , email: "Email không đúng định dạng!!"
                    }
                    , "passwordUser": {
                        required: "Vui lòng nhập mật khẩu của bạn"
                    }
                , }
                , submitHandler: function(form) {
                    $("#submit-login").prop("disabled", true);
                    var emailUser = $("input[name=emailUser]").val();
                    var passwordUser = $("input[name=passwordUser]").val();
                    var remember = $("input[name=remember]").serialize() ? true : false;
                    $.ajax({
                        type: "POST"
                        , url: url
                        , data: {
                            emailUser: emailUser
                            , passwordUser: passwordUser
                            , remember: remember
                        , }
                        , success: function(response, textStatus, xhr) {
                            $.toast({
                                heading: 'Log in!'
                                , text: (response)
                                , showHideTransition: 'slide'
                                , position: 'top-right'
                                , icon: 'success'
                            });
                            window.location.reload(true);
                        }
                        , error: function(response) {
                            $("#submit-login").prop("disabled", false);
                            $("#login-form").find('input[type=password]').val(
                                '');
                            $.toast({
                                heading: 'Log in!'
                                , text: (response.responseText)
                                , showHideTransition: 'slide'
                                , position: 'top-right'
                                , icon: 'error'
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
                type: "POST"
                , url: url
                , data: {
                    emailReset: emailReset
                , }
                , success: function(response, textStatus, xhr) {
                    $("#forgot_password").find("input[name=emailReset]").val('');
                    $('#show_forgot_password').addClass('d-none');
                    $('#show_change_password').removeClass('d-none');
                    $.toast({
                        heading: 'Change Password!'
                        , text: (response)
                        , showHideTransition: 'slide'
                        , position: 'top-right'
                        , icon: 'success'
                    });
                    $("#forgot_password-btn").prop("disabled", false);
                }
                , error: function(response, textStatus, xhr) {
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
            $.ajax({
                type: "POST"
                , url: url
                , data: {
                    token: token
                    , newPassword: newPassword
                , }
                , success: function(response, textStatus, xhr) {
                    if (xhr.status == 200) {
                        $("#forgot_password").find("input[name=emailReset]").val('');
                        $('#show_forgot_password').addClass('d-none');
                        $('#show_change_password').removeClass('d-none');
                        $.toast({
                            heading: 'Change Password!'
                            , text: (response)
                            , showHideTransition: 'slide'
                            , position: 'top-right'
                            , icon: 'success'
                        });
                        $("#change_password")[0].reset();
                        $("#change_password-btn").prop("disabled", false);
                    }
                }
                , error: function(response) {
                    $("#change_password")[0].reset();
                    $("#show_change_password").find('.text-danger').remove();
                    $("#show_change_password").find('.form-error').append(
                        '<p class="text-danger ml-2 mt-3"></p>');
                    $("#change_password-btn").prop("disabled", false);
                    $("#show_change_password").find('.text-danger').text(response
                        .responseText).show().fadeOut(2000);
                }
            });
        });

        $(".logout").click(function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to sign out!!")) {
                $.ajax({
                    type: "POST"
                    , url: "{{ route('logout') }}"
                    , success: function(response, textStatus, xhr) {
                        $.toast({
                            heading: 'Log out!'
                            , text: (response)
                            , showHideTransition: 'slide'
                            , position: 'top-right'
                            , icon: 'success'
                        });
                        window.location.reload(true);
                    },

                });
            }
        });

    });

</script>
@endpush
