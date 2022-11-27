@extends('frontend.layout_frontend')
@php
    $title = 'Checkout';
@endphp
@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Check Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="{{ route('cart.checkout') }}" method="post" id="check_out">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Tên người nhận<span>*</span></p>
                                        <input class="mb-0" type="text" name="name_receiver"
                                            value="{{ $customer->name }}" placeholder="Name...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số điện thoại<span>*</span></p>
                                        <input class="mb-0" type="text" name="phone_receiver"
                                            value="{{ $customer->phone }}" placeholder="Phone...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group checkout__input mt-2">
                                <p>Tỉnh thành<span>*</span></p>
                                <select class="form-control select2" data-toggle="select2" name="provinces" id="provinces">
                                    <option value="">--- Chọn tỉnh thành ---</option>
                                </select>
                            </div>
                            <div class="form-group checkout__input mt-2">
                                <p>Quận huyện/ Thành phố<span>*</span></p>
                                <select class="form-control select2" data-toggle="select2" name="districts" id="districts">
                                    <option value="">--- Chọn quận huyện ---</option>
                                </select>
                            </div>
                            <div class="form-group checkout__input mt-2">
                                <p>Xã phường<span>*</span></p>
                                <select class="form-control select2" data-toggle="select2" name="wards" id="wards">
                                    <option value="">--- Chọn xã phường ---</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input mt-2">
                                        <p>Ghi chú</p>
                                        <input class="mb-0" type="text" name="note"
                                            placeholder="Những lưu ý đặc biệt khi giao hàng.">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__input" id="show_discount">
                                <p>Mã giảm giá<span></span></p>
                                <div class="input_discount">
                                    <input class="mb-0" type="text" id="set_discount" placeholder="Coupon code">
                                    <button class="btn-discount" type="button" id="btn_discount">Apply</button>
                                </div>
                            </div>
                            <div class="checkout__order mt-3">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products">Product <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @foreach ($cartItems as $key => $value)
                                        <li class="d-flex">
                                            <div class="mr-1">{{ $value->name }} <b class="text-danger">x
                                                    {{ $value->quantity }}</b></div><span class="font-weight-bold">
                                                {{ currency_format($value->price) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Subtotal <span
                                            style="text-decoration: line-through;">{{ currency_format($data['getSubTotal']) }}</span>
                                    </li>
                                    <li id="get_discount"></li>
                                    <li>Total <span id="get_total">{{ currency_format($data['getTotal']) }}</span></li>
                                    <input type="hidden" name="get_total" value="{{ $data['getTotal'] }}">
                                    <input type="hidden" name="get_discount">
                                </ul>
                                <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                    ut labore et dolore magna aliqua.</p>
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Check Payment
                                        <input type="checkbox" id="payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Paypal
                                        <input type="checkbox" id="paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#check_out").validate({
                rules: {
                    name_receiver: {
                        required: true,
                        minlength: 3
                    },
                    phone_receiver: {
                        required: true,
                        validatePhone: true,
                    },
                    provinces: {
                        required: true,
                    },
                    districts: {
                        required: true,
                    },
                    wards: {
                        required: true,
                    },
                },
                messages: {
                    name_receiver: {
                        required: "Không được bỏ trống",
                        minlength: "Tên không được nhỏ hơn 3 kí tự"
                    },
                    phone_receiver: {
                        required: "Không được bỏ trống",
                        min: "You must be at least 18 years old"
                    },
                    provinces: {
                        required: "Không được bỏ trống",
                    },
                    districts: {
                        required: "Không được bỏ trống",
                    },
                    wards: {
                        required: "Không được bỏ trống",
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $.validator.addMethod("validatePhone", function(value, element) {
                return this.optional(element) ||
                    /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/i.test(value);
            }, "Vui lòng nhập đúng định dạng số điện thoại!!");
        });
        $("#btn_discount").click(function() {
            let discount = $("#set_discount").val();
            if (discount !== '') {
                $.ajax({
                    type: "POST",
                    url: '{{ route('api.get_discount') }}',
                    data: {
                        discount: discount,
                    },
                    success: function(response, textStatus, xhr) {
                        $("#btn_discount").addClass("bg-secondary").prop("disabled", true);
                        setTimeout(function() {
                            $("#btn_discount").removeClass("bg-secondary").prop("disabled",
                                false);
                        }, 2500);
                        $("#get_discount").find('p').remove();
                        $('#get_discount').append(
                            `<p>Discount <span>- ${response.data.discount}</span></p>`)
                        let sum = $("input[name=get_total]").val() - response.data.slug;
                        $("input[name=get_discount]").val(response.data.slug);
                        sum = sum.toLocaleString('vi', {
                            style: 'currency',
                            currency: 'VND'
                        });
                        $("#get_total").text(sum);
                        $("#set_discount").val('');
                    },
                    error: function(response) {
                        $("#show_discount").find('.text-danger').remove();
                        $("#show_discount").append(
                            '<p class="text-danger ml-2 mt-1"></p>');
                        $("#show_discount").find('.text-danger').text("Mã giảm giá không hợp lệ").show()
                            .fadeOut(
                                3000);
                    }
                });
            } else {
                $("#show_discount").find('.text-danger').remove();
                $("#show_discount").append(
                    '<p class="text-danger ml-2 mt-1"></p>');
                $("#show_discount").find('.text-danger').text("Vui lòng nhập mã giảm giá!").show()
                    .fadeOut(
                        3000);
            }
        });
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('api.address') }}',
                dataType: 'json',
                success: function(response) {
                    for (let each of response.data) {
                        $('#provinces').append(`<option value="${each.id}">${each.name}</option>`);
                    }
                    $("#provinces").change(function() {
                        $('#districts').html('');
                        $('#wards').html('');
                        if ($(this).val() !== '') {
                            selectedProvince = response.data.find(e => e.id == $(this).val())
                            for (let each of selectedProvince.districts) {
                                $('#districts').append(
                                    `<option value="${each.id}">${each.name}</option>`);
                            }
                            selectedDistrict = selectedProvince.districts.find(e => e.id == $(
                                '#districts').val())
                            for (let each of selectedDistrict.wards) {
                                $('#wards').append(
                                    `<option value="${each.id}">${each.path}</option>`);
                            }
                        } else {
                            $('#districts').append(`<option>--- Chọn quận huyện ---</option>`);
                            $('#wards').append(`<option>--- Chọn xã phường ---</option>`);
                        }

                    });

                    $("#districts").change(function() {
                        $('#wards').html('');
                        selectedDistrict = selectedProvince.districts.find(e => e.id == $(this)
                            .val())
                        for (let each of selectedDistrict.wards) {
                            $('#wards').append(
                                `<option value="${each.id}">${each.path}</option>`);
                        }
                    });
                },
                error: function(response) {
                    console.log(response);
                },
            })
        });
    </script>
@endpush
