@if (!empty($discountProduct))
    <!-- Categories Section Begin -->
    <section class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>
                            @if ($discountProduct->menu != 'footwears' && $discountProduct->menu != 'accessories')
                                <span>Clothings Hot</span>
                            @else
                                Clothings Hot
                            @endif
                            <br />
                            @if ($discountProduct->menu == 'footwears')
                                <span>Shoe Collection</span>
                            @else
                                Shoe Collection
                            @endif
                            <br />
                            @if ($discountProduct->menu == 'accessories')
                                <span>Accessories</span>
                            @else
                                Accessories
                            @endif
                        </h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="{{ asset("storage/$discountProduct->productImage") }}" alt="">
                        <div class="hot__deal__sticker">
                            <span>Sale Of</span>
                            <h5>$
                                {{ currency_format(($discountProduct->productions->price * (100 - $discountProduct->discounts->discount_price)) / 100) }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <span>Deal Of The Week</span>
                        <h2>{{ $discountProduct->productions->name }}</h2>
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
                        <a href="{{ route('productDetail', Str::slug($discountProduct->productions->name, '-')) }}"
                            class="primary-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->
    @push('js')
        <script>
            var countDownDate = new Date("{{ $discountProduct->discounts->date_end }}").getTime();
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
