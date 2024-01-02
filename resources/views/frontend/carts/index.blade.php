@extends('frontend.layouts')
@php
$title = 'Carts';
@endphp
@section('container')
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('index') }}">Home</a>
                            <a href="{{ route('shop') }}">Shop</a>
                            <span>Carts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                @if (!$checkCart)
                    <div class="col-lg-8">
                        <div class="shopping__cart__table">
                            <table id="table_cart">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $each)
                                        @php
                                            $image = $each->attributes['image'];
                                            $sale = $each->attributes['discounts'];
                                            $price = $each->price * (1 - $sale / 100) * $each->quantity;
                                        @endphp
                                        <tr class="row-cart-js" data-id="{{ $each->id }}">
                                            <td class="product__cart__item">
                                                <div class="product__cart__item__pic">
                                                    <a
                                                        href="{{ route('productDetail', Str::slug(explode(' (', $each->name)[0], '-')) }}">
                                                        <img src="{{ asset("storage/$image") }}" alt=""
                                                            width="80">
                                                    </a>
                                                </div>
                                                <div class="product__cart__item__text">
                                                    <h6>{{ $each->name }}</h6>
                                                    <h5><span class="cart-price">{{ currency_format($each->price) }}</span>
                                                    </h5>
                                                </div>
                                            </td>
                                            <td class="quantity__item">
                                                <div class="quantity">
                                                    <div class="pro-qty-2">
                                                        <input type="text" value="{{ $each->quantity }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__price">
                                                <span class="cart-total">{{ currency_format($price) }}</span>
                                                <br>
                                                @if ($sale != 0)
                                                    <em>Sale: <span
                                                            class="text-danger cart-sale">{{ $sale }}</span>%</em>
                                                @endif
                                            </td>
                                            <td class="cart__close">
                                                <form data-route="{{ route('cart.remove', $each->id) }}"
                                                    class="cart-remove">
                                                    <button
                                                        type="submit"style="border: none; outline: none; background-color: initial;">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="p-3 float-right">
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button class="text-uppercase text-dark font-weight-bold border-0 bg-light">Remove
                                            All
                                            Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="continue__btn">
                                    <a href="{{ route('shop') }}">Continue Shopping</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="continue__btn update__btn">
                                    <a href="{{ route('checkout') }}"><i class="fa fa-spinner"></i> Proceed to checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12" style="min-height: 500px">
                        <div class="text-center" style="margin-top: 100px;">
                            <img src="{{ asset('frontend/img/cart-icon-transparent-18.png') }}" width="160"
                                height="160" class="img-fluid mb-4 mr-3">
                            <h3><strong>Your Cart is Empty</strong></h3>
                            <h4>Add something to make me happy :)</h4>
                            <a href="{{ route('shop') }}" class=" mt-3 btn btn-light btn-rounded5">continue shopping <i
                                    style="transform: rotate(-170deg);" class="ml-1 fa fa-share" aria-hidden="true"></i></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var proQty = $('.pro-qty-2');
            proQty.prepend('<span class="fa fa-angle-left dec qtybtn"></span>');
            proQty.append('<span class="fa fa-angle-right inc qtybtn"></span>');
            proQty.on('click', '.qtybtn', function(e) {
                e.preventDefault();
                var $button = $(this);
                var parent_col = $button.parents('.row-cart-js');
                var oldValue = $button.parent().find('input').val();
                var price = parent_col.find('.cart-price').text();
                var sale = parent_col.find('.cart-sale').text() ? parent_col.find('.cart-sale').text() : 0;
                var id = parent_col.data('id');
                var check = true;
                if ($button.hasClass('inc')) {
                    if (oldValue < 10) {
                        var newVal = parseFloat(oldValue) + 1;
                    } else {
                        newVal = 10;
                        $.toast({
                            heading: 'Thông báo!',
                            text: 'Số lượng sản phẩm đã đạt đến mức tối đa!',
                            position: 'top-right',
                        })
                        check = false;
                    }
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                        $.toast({
                            heading: 'Thông báo!',
                            text: 'Số lượng sản phẩm đã giảm đến mức tối thiểu!',
                            position: 'top-right',
                        })
                        check = false;
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('cart.update') }}",
                    data: {
                        id: id,
                        quantity: newVal,
                    },
                    success: function(response, textStatus, xhr) {
                        if (xhr.status == 200) {
                            $button.parent().find('input').val(newVal);
                            price = parseInt(price) * 1000;
                            let sum = (price * newVal * (1 - sale / 100));
                            if (check) {
                                $.toast({
                                    heading: 'Update Cart!',
                                    text: (response.message),
                                    showHideTransition: 'slide',
                                    position: 'top-right',
                                    icon: 'success'
                                });
                                sum = sum.toLocaleString('vi', {
                                    style: 'currency',
                                    currency: 'VND'
                                });
                                parent_col.find('.cart-total').text(sum);
                                $('#total').text(response.data.getTotal);
                                $('#subTotal').text(response.data.getSubTotal);
                            }
                        } else {
                            $button.parent().find('input').val(oldValue);
                            $.toast({
                                heading: 'Update Cart!',
                                text: (response),
                                showHideTransition: 'slide',
                                position: 'top-right',
                                icon: 'warning'
                            });
                        }
                    },
                    error: function(response) {
                        $.toast({
                            heading: 'Update Cart!',
                            text: (response.responseText),
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'error'
                        });
                    }
                });
            });
            $('.cart-remove').on('submit', function(e) {
                e.preventDefault();
                let parent_col = $(this).parents('.row-cart-js');
                if (confirm("Are you sure want to remove?")) {
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: $(this).data('route'),
                        data: {
                            '_method': 'delete'
                        },
                        success: function(response, textStatus, xhr) {
                            $.toast({
                                heading: 'Remove Cart!',
                                text: (response),
                                showHideTransition: 'slide',
                                position: 'top-right',
                                icon: 'success'
                            });
                            parent_col.remove();
                        },
                        error: function(response) {
                            $.toast({
                                heading: 'Remove Cart!',
                                text: (response.responseText),
                                showHideTransition: 'slide',
                                position: 'top-right',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
            // $("#check_out").validate({
            //     onfocusout: false,
            //     onkeyup: false,
            //     onclick: false,
            //     rules: {
            //         "name_receiver": {
            //             required: true,
            //             maxlength: 15
            //         },
            //         "phone_receiver": {
            //             required: true,
            //             validatePhone: false,
            //         },
            //         address_receiver: "required",
            //     },
            //     messages: {
            //         "name_receiver": {
            //             required: "Vui lòng nhập tên của bạn",
            //             maxlength: "Nhập tối đa 15 kí tự"
            //         },
            //         "phone_receiver": {
            //             required: "Vui lòng nhập số điện thoại của bạn",
            //         },
            //         "address_receiver": {
            //             required: "Vui lòng nhập địa chỉ của bạn"
            //         },
            //     },
            //     submitHandler: function(form) {
            //         form.submit();
            //     }
            // });
            // $.validator.addMethod("validatePhone", function(value, element) {
            //     return this.optional(element) ||
            //         /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/i.test(value);
            // }, "Vui lòng nhập đúng định dạng số điện thoại!!");
        });
    </script>
@endpush
