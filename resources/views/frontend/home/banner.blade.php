<!-- Banner Section Begin -->
<section class="banner spad">
    <div class="container">
        <div class="row">
            @foreach ($slides as $slide)
                @if ($slide->sort_order == $slideOrders['BANNER'])
                    <div @if ($slide->id % 2 != 0) class="col-lg-7 @if ($slide->id % 3 == 2) offset-lg-4 @endif"
                    @else class="col-lg-5" @endif>
                        <div
                            class="banner__item  @if ($slide->id % 2 == 0) banner__item--middle @endif @if ($slide->id % 3 == 1) banner__item--last @endif">
                            <div class="banner__item__pic">
                                <img src="@foreach (json_decode($slide->image) as $images){{ asset("storage/$images") }} @endforeach"
                                    alt="banner.img">
                            </div>
                            <div class="banner__item__text">
                                <h2>{{ $slide->title }}</h2>
                                <a href="{{ route('menu', $slide->major_categories->slug) }}">Shop now</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
<!-- Banner Section End -->
