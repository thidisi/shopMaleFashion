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
                                    <input class="mb-0" type="text" name="name_receiver" value="{{ $customer->name }}" placeholder="Name...">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Số điện thoại<span>*</span></p>
                                    <input class="mb-0" type="text" name="phone_receiver" value="{{ $customer->phone }}" placeholder="Phone...">
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
                                    <input class="mb-0" type="text" name="note" placeholder="Những lưu ý đặc biệt khi giao hàng.">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__input" id="input_discount">
                            <p>Mã giảm giá<span></span></p>
                            <input class="mb-0" type="text" name="discount">
                        </div>
                        <div class="checkout__order mt-3">
                            <h4 class="order__title">Your order</h4>
                            <div class="checkout__order__products">Product <span>Total</span></div>
                            <ul class="checkout__total__products">
                                @foreach($cartItems as $key => $value)
                                <li class="d-flex">
                                    <div class="mr-1">{{ $value->name }} <b class="text-danger">x {{ $value->quantity }}</b></div><span class="font-weight-bold"> {{ currency_format($value->price) }}</span>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="checkout__total__all">
                                <li>Subtotal <span style="text-decoration: line-through;">{{ $data['getSubTotal'] }}</span>
                                </li>
                                <li>Total <span>{{ $data['getTotal'] }}</span></li>
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
        $.ajax({
            url: '{{ route('api.address') }}'
            , dataType: 'json'
            , success: function(response) {
                for (let each of response.data) {
                    $('#provinces').append(`<option value="${each.id}">${each.name}</option>`);
                }
                $("#provinces").change(function() {
                    $('#districts').html('');
                    $('#wards').html('');
                    if ($(this).val() !== '') {
                        selectedProvince = response.data.find(e => e.id == $(this).val())
                        for (let each of selectedProvince.districts) {
                            $('#districts').append(`<option value="${each.id}">${each.name}</option>`);
                        }
                        selectedDistrict = selectedProvince.districts.find(e => e.id == $('#districts').val())
                        for (let each of selectedDistrict.wards) {
                            $('#wards').append(`<option value="${each.id}">${each.path}</option>`);
                        }
                    } else {
                        $('#districts').append(`<option>--- Chọn quận huyện ---</option>`);
                        $('#wards').append(`<option>--- Chọn xã phường ---</option>`);
                    }

                });

                $("#districts").change(function() {
                    $('#wards').html('');
                    selectedDistrict = selectedProvince.districts.find(e => e.id == $(this).val())
                    for (let each of selectedDistrict.wards) {
                        $('#wards').append(`<option value="${each.id}">${each.path}</option>`);
                    }
                });
            }
            , error: function(response) {
                console.log(response);
            }
        , })

        $("#check_out").validate({
            onfocusout: false
            , onkeyup: false
            , onclick: false
            , rules: {
                "name_receiver": {
                    required: true
                    , maxlength: 15
                }
                , "phone_receiver": {
                    required: true
                    , validatePhone: false
                , }
                , "provinces": "required"
                , "districts": "required"
                , "wards": "required"
            , }
            , messages: {
                "name_receiver": {
                    required: "Vui lòng nhập tên của bạn"
                    , maxlength: "Nhập tối đa 15 kí tự"
                }
                , "phone_receiver": {
                    required: "Vui lòng nhập số điện thoại của bạn"
                , }
                , "provinces": {
                    required: "Vui lòng nhập địa chỉ của bạn"
                }
                , "districts": {
                    required: "Vui lòng nhập địa chỉ của bạn"
                }
                , "wards": {
                    required: "Vui lòng nhập địa chỉ của bạn"
                }
            , }
            , submitHandler: function(form) {
                form.submit();
            }
        });
    });

</script>
@endpush
