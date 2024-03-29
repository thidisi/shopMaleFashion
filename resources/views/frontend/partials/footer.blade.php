<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="#"><img src="{{ isset($about->logo) ? asset("storage/$about->logo") : '' }}" alt=""></a>
                    </div>
                    <p>{{ isset($about->title) ? $about->title : '' }}</p>
                    <a href="#"><img src="{{ asset('frontend/img/payment.png') }}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Shopping</h6>
                    <ul class="dropdown">
                        @if (!empty($menus))
                            @foreach ($menus as $each)
                                <li><a href="{{ route('menu', $each->slug) }}"> {{ $each->name }} </a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Bonus</h6>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Blogs</a></li>
                        <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> Email:
                                {{ isset($about->email) ? $about->email : '' }}</a></li>
                        <li><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></i> Phone:
                                {{ isset($about->phone) ? '0' . number_format($about->phone, 0, ',', '.') : '' }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>NewLetter</h6>
                    <div class="footer__newslatter">
                        <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                        <form action="#">
                            <input type="text" placeholder="Your email">
                            <button type="submit"><span class="icon_mail_alt"></span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="footer__copyright__text">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <p>Copyright ©
                        2020 -
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        All rights reserved | This template is made with <i class="fa fa-heart-o"
                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    </p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
        </div>
    </div>
</footer>
