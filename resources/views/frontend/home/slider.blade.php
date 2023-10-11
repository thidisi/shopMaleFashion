<!-- Hero Section Begin -->
<section class="hero">
    <div class="hero__slider owl-carousel">
        @foreach ($slides as $slide)
            @if ($slide->sort_order == $slideOrders['SLIDER'])
                <div class="hero__items set-bg"
                    data-setbg="@foreach (json_decode($slide->image) as $images){{ asset("storage/$images") }} @endforeach">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-5 col-lg-7 col-md-8">
                                <div class="hero__text">
                                    {{-- <h6>Summer Collection</h6> --}}
                                    <h2>{{ $slide->title }}</h2>
                                    <p>{{ $slide->slug }}</p>
                                    <a href="{{ route('menu', $slide->major_categories->slug) }}" class="primary-btn">Shop
                                        now<span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>
<!-- Hero Section End -->
