@extends('frontend.layouts')
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
                        <a href="./carts.html">Carts</a>
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
            <div class="col-lg-12">
                <div class="text-center">
                    <img src="{{ asset('frontend/img/cart-icon-transparent-18.png') }}" width="160" height="160" class="img-fluid mb-4 mr-3">
                    <h4>There are no products in the cart to proceed with the order</h4>
                    <h5>Add something to make me happy :)</h5>
                    <a href="{{ route('shop') }}" class=" mt-3 btn btn-light btn-rounded5">continue shopping <i style="transform: rotate(-170deg);" class="ml-1 fa fa-share" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
@endsection
