@extends('frontend.layout_frontend')
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
                <div class="col-lg-12">
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
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->
@endsection
