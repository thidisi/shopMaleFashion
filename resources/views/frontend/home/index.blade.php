@extends('frontend.layouts')
@php
$title = 'Home';
@endphp
@section('container')
    @include('frontend.home.slider');
    @include('frontend.home.banner');
    @include('frontend.home.product_home');
    @include('frontend.home.categories_sale');
    @include('frontend.home.instagram');
    @include('frontend.home.blog_home');
@endsection
