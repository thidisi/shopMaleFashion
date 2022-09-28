<!-- Banner Section Begin -->
<section class="banner spad">
    <div class="container">
        <div class="row">
            @foreach ($banners as $banner)
                <div @if ($banner->id % 2 != 0) class="col-lg-7 @if($banner->id % 3 == 2) offset-lg-4 @endif" @else class="col-lg-5" @endif>
                    <div class="banner__item  @if ($banner->id % 2 == 0) banner__item--middle @endif @if($banner->id % 3 == 1) banner__item--last @endif">
                        <div class="banner__item__pic">
                            <img src="@foreach (json_decode($banner->image) as $images){{ asset("storage/$images") }} @endforeach"
                                alt="banner.img">
                        </div>
                        <div class="banner__item__text">
                            <h2>{{ $banner->title }}</h2>
                            <a href="{{ route('menu', $banner->menu_slug) }}">Shop now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Banner Section End -->
