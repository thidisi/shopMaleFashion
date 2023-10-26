@extends('frontend.layout_frontend')
@php
$title = 'Orders detail';
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
                            <span>Order details</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="shop spad">
        <div class="container">
            <div class="row">
                @if ($order_details != '[]')
                    <div class="table-responsive my-3">
                        <table class="table shopping__cart__table">
                            <thead>
                                <tr class="text-center text-uppercase" style="display: table;width: 100%;">
                                    <th class="text-center">#</th>
                                    <th>Productions</th>
                                    <th>Info</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="nice-scroll"
                                style="overflow-y: hidden; outline: none;display: block; max-height: 900px;">
                                @foreach ($order_details as $value)
                                    <tr style="display: table;width: 100%;">
                                        <td class="align-middle text-center" style="width: 7%;">
                                            {{ $value->id }}
                                        </td>
                                        <td class="align-middle" style="width:50%;">
                                            @foreach ($value->productions as $each)
                                                <div class="mb-2 d-flex align-items-center">
                                                    <img class="mt-1 mb-1 ml-1" src="{{ asset("storage/$each->image") }}"
                                                        alt="contact-img" title="contact-img" class="rounded mr-3"
                                                        height="100" />
                                                    <div class="ml-3">
                                                        <p>{{ $each->name }} ({{ $each->pivot->attr }})</p>
                                                        <span>Quantity: {{ $each->pivot->quantity }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="float-right mr-3 font-weight-bold">Total: <span
                                                    class="text-danger">{{ currency_format($value->total_money) }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="mt-3">
                                                <p class="mb-2">Name :{{ $value->name_receiver }}</p>
                                                <p class="mb-2">Phone :{{ $value->phone_receiver }}</p>
                                                <p class="mb-2">Address :{{ $value->address_receiver }}</p>
                                                <p>Note :{{ $value->note }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            @switch($value->action)
                                                @case('active')
                                                    <span class="text-success font-weight-bold text-center">Order approved</span>
                                                @break

                                                @case('inactive')
                                                    <span class="text-danger font-weight-bold text-center">Order has been
                                                        cancelled</span>
                                                @break

                                                @default
                                                    <span class="text-warning font-weight-bold text-center">Waiting for
                                                        approval</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-lg-12" style="min-height: 500px">
                        <div class="text-center" style="margin-top: 100px;">
                            <img src="{{ asset('frontend/img/cart-icon-transparent-18.png') }}" width="160"
                                height="160" class="img-fluid mb-4 mr-3">
                            <h3><strong>You Haven't Placed Any Orders Yet</strong></h3>
                            <h4>Add something to make me happy :)</h4>
                            <a href="{{ route('shop') }}" class=" mt-3 btn btn-light btn-rounded5">continue shopping <i
                                    style="transform: rotate(-170deg);" class="ml-1 fa fa-share" aria-hidden="true"></i></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
