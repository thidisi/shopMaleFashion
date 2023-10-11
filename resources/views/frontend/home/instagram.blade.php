<!-- Instagram Section Begin -->
<section class="instagram spad">
    <div class="container">
        <div class="row">
            @foreach ($slides as $slide)
                @if ($slide->sort_order == $slideOrders['INSTAGRAM'])
                    <div class="col-lg-8">
                        <div class="instagram__pic">
                            @foreach (json_decode($slide->image) as $images)
                                <div class="instagram__pic__item set-bg" data-setbg="{{ asset("storage/$images") }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="instagram__text">
                            <h2>{{ $slide->title }}</h2>
                            <p>{{ $slide->slug }}</p>
                            <h3>#Male_Fashion</h3>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
<!-- Instagram Section End -->
