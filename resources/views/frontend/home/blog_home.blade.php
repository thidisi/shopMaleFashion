<!-- Latest Blog Section Begin -->
<section class="latest spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Latest News</span>
                    <h2>Fashion New Trends</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($blogs as $each)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="{{ asset("storage/$each->image") }} "></div>
                        <div class="blog__item__text">
                            <span><img src="{{ asset('frontend/img/icon/calendar.png') }}" alt="">{{ $each->format_date }}</span>
                            <h5 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" >{{ $each->title }}</h5>
                            <a href="{{ route('blogs.detail', $each->slug) }}">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Latest Blog Section End -->
