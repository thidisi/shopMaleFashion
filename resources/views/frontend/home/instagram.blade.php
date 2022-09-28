<!-- Instagram Section Begin -->
<section class="instagram spad">
    <div class="container">
        <div class="row">
            @foreach ($instagram as $each)
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        @foreach (json_decode($each->image) as $images)
                            <div class="instagram__pic__item set-bg" data-setbg="{{ asset("storage/$images") }}"></div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <h2>{{ $each->title }}</h2>
                        <p>{{ $each->slug }}</p>
                        <h3>#Male_Fashion</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Instagram Section End -->
