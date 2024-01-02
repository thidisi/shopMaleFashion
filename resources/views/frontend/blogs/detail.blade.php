@extends('frontend.layouts')
@php
$title = 'Blogs';
@endphp
@section('container')
<!-- Blog Details Hero Begin -->
<section class="blog-hero spad">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-9 text-center">
                <div class="blog__hero__text">
                    <h2>{{ $blog->title }}</h2>
                    <ul>
                        <li>By Deercreative</li>
                        <li>{{ $blog->format_date }}</li>
                        <li>8 Comments</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Hero End -->

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                {!! $blog->content !!}
            </div>
            {{-- <div class="col-lg-8">
                    <div class="blog__details__content">
                        <div class="blog__details__comment">
                            <h4>Leave A Comment</h4>
                            <form action="#">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Name">
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Email">
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Phone">
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <textarea placeholder="Comment"></textarea>
                                        <button type="submit" class="site-btn">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
            <div class="col-lg-10">
                <div class="blog__details__btns">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            @if(!empty($data['previous']))
                            <a href="{{ route('blogs.detail', $data['previous']->slug) }}" class="blog__details__btns__item">
                                <p><span class="arrow_left"></span> Previous Pod</p>
                                <h5>{{ $data['previous']->title }}</h5>
                            </a>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            @if(!empty($data['next']))
                            <a href="{{ route('blogs.detail', $data['next']->slug) }}" class="blog__details__btns__item blog__details__btns__item--next">
                                <p>Next Pod <span class="arrow_right"></span></p>
                                <h5>{{ $data['next']->title }}</h5>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->
@endsection
