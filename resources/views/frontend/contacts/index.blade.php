@extends('frontend.layout_frontend')
@php
    $title = 'Contact';
@endphp
@section('container')
    <!-- Map Begin -->
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.6533930573733!2d105.79555331531361!3d21.00652659391189!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aca6992d4aa7%3A0xf7090c41dbefe7ea!2zVHLGsOG7nW5nIFRIUFQgY2h1ecOqbiBIw6AgTuG7mWkgLSBBbXN0ZXJkYW0!5e0!3m2!1svi!2s!4v1661683759425!5m2!1svi!2s"
            height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <!-- Map End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__text">
                        <div class="section-title">
                            <span>Information</span>
                            <h2>Contact Us</h2>
                            <p>As you might expect of a company that began as a high-end interiors contractor, we pay
                                strict attention.</p>
                        </div>
                        <ul>
                            <li>
                                <h4>{{ $about->address }}</h4>
                                <p>{{ $about->branch }} <br />{{ $about->phone }}</p>
                            </li>
                            <li>
                                <h4>{{ $about->address_second }}</h4>
                                <p>{{ $about->branch_second }} <br />{{ $about->phone_second }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact__form">
                        <form action="{{ route('contact.store') }}" method="post" id="form_contact">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Name" name="name"
                                        value="{{ session('sessionCustomerName') }}">
                                    @if ($errors->has('name'))
                                        <p class="text-capitalize text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Email" name="email"
                                        value="{{ session('sessionEmailCustomer') }}">
                                    @if ($errors->has('email'))
                                        <p class="text-capitalize text-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-2">
                                        <textarea placeholder="Message" name="message"></textarea>
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" class="site-btn rounded">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            function Disabled(time,data) {
                if (time > 0) {
                    let times = data ? data : time;
                    $('.site-btn').addClass("bg-secondary").prop("disabled", true)
                    $('.d-flex').append(
                        `<span class="text-light d-block text-center ml-3 rounded-circle bg-dark"style="width: 34px;height:34px;line-height: 34px;margin: auto;">${times}</span>`
                    );
                    var timeleft = time;
                    var downloadTimer = setInterval(function() {
                        if (timeleft > 0) {
                            $('.d-flex').find('span').text(timeleft);
                            localStorage.setItem("timeDisabled", timeleft);
                        } else {
                            clearInterval(downloadTimer);
                            $('.d-flex').find('span').remove();
                            localStorage.removeItem("timeDisabled");
                            $('.site-btn').removeClass("bg-secondary").prop("disabled", false);
                        }
                        timeleft -= 1;
                    }, 1000);
                }
            }
            Disabled(localStorage.getItem("timeDisabled"))
            $('#form_contact').validate({
                rules: {
                    "name": {
                        required: true,
                        minlength: 3
                    },
                    "email": {
                        required: true,
                        email: true
                    },
                    "message": {
                        required: true,
                    },
                },
                messages: {
                    "name": {
                        required: "Không được bỏ trống",
                        minlength: "Tên không được nhỏ hơn 3 kí tự"
                    },
                    "email": {
                        required: "Vui lòng nhập email của bạn",
                        email: "Email không đúng định dạng!!"
                    },
                    "message": {
                        required: "Không được bỏ trống",
                    },
                },
                submitHandler: function(form) {
                    localStorage.setItem("timeDisabled", 29);
                    Disabled(29,30);
                }
            });
        })
    </script>
@endpush
