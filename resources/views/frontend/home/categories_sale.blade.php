@if(!empty($discountProduct))
<!-- Categories Section Begin -->
@php
$image = json_decode($discountProduct->image)[0];
@endphp

<section class="categories spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="categories__text">
                    <h2>Clothings Hot <br /> <span>Shoe Collection</span> <br /> Accessories</h2>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="categories__hot__deal">
                    <img src="{{ asset("storage/$image") }}" alt="">
                    <div class="hot__deal__sticker">
                        <span>Sale Of</span>
                        <h5>$ {{ currency_format($discountProduct->price * (100 - $discountProduct->discount_price) / 100) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-1">
                <div class="categories__deal__countdown">
                    <span>Deal Of The Week</span>
                    <h2>{{ $discountProduct->name }}</h2>
                    {{-- id="countdown" --}}
                    <div class="categories__deal__countdown__timer" id="end">
                        <div class="cd-item">
                            <span id="days"></span>
                            <p>Days</p>
                        </div>
                        <div class="cd-item">
                            <span id="hours"></span>
                            <p>Hours</p>
                        </div>
                        <div class="cd-item">
                            <span id="mins"></span>
                            <p>Minutes</p>
                        </div>
                        <div class="cd-item">
                            <span id="secs"></span>
                            <p>Seconds</p>
                        </div>
                    </div>
                    <a href="{{ route('productDetail',Str::slug($discountProduct->name, '-')) }}" class="primary-btn">Shop now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->
@push('js')
<script>
    var countDownDate = new Date("{{ $discountProduct->date_end }}").getTime();
    var myfunc = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("days").innerHTML = days
        document.getElementById("hours").innerHTML = hours
        document.getElementById("mins").innerHTML = minutes
        document.getElementById("secs").innerHTML = seconds
        if (distance < 0) {
            clearInterval(myfunc);
            document.getElementById("end").innerHTML = "EXPIRED";
        }
    }, 1000);

</script>
@endpush

@endif
