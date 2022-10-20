@extends('frontend.layout_frontend')
@php
$title = 'Products';
@endphp
@section('container')
<!-- Shop Details Section Begin -->
<section class="shop-details">
    <div class="product__details__pic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__details__breadcrumb">
                        <a href="./index.html">Home</a>
                        <a href="./shop.html">Shop</a>
                        <span>Product Details</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <ul class="nav nav-tabs nice-scroll" role="tablist">

                        @foreach (json_decode($each->image) as $key => $images)
                        <li class="nav-item" style="cursor: pointer;">
                            <a class="nav-link @if (head(json_decode($each->image)) == $images) active @endif" data-toggle="tab" href="#tabImages-{{ $key + 1 }}" role="tab">
                                <div class="product__thumb__pic set-bg" @if ($each->statusImage == ACTIVE) data-setbg="{{ asset("storage/$images") }}" @endif>
                                    @if (last(json_decode($each->image)) == $images)
                                    <i class="fa fa-play"></i>
                                    @endif
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-6 col-md-9">
                    <div class="tab-content">
                        @foreach (json_decode($each->image) as $key => $images)
                        @if (last(json_decode($each->image)) == $images)
                        <div class="tab-pane" id="tabImages-{{ $key + 1 }}" role="tabpanel">
                            <div class="product__details__pic__item">
                                @if ($each->statusImage == ACTIVE)
                                <img src="{{ asset("storage/$images") }}" alt="product_img">
                                @endif
                                <a href="https://www.youtube.com/watch?v=3O19l0_la5M&list=RDMM3O19l0_la5M&start_radio=1" class="video-popup"><i class="fa fa-play"></i></a>
                            </div>
                        </div>
                        @endif
                        <div class="tab-pane @if (head(json_decode($each->image)) == $images) active @endif" id="tabImages-{{ $key + 1 }}" role="tabpanel">
                            <div class="product__details__pic__item">
                                @if ($each->statusImage == ACTIVE)
                                <img id="wishlist_productimage{{ $each->id }}" src="{{ asset("storage/$images") }}" alt="product_img">
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product__details__content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="product__details__text">
                        <h4>{{ $each->name }}
                            @if ($each->statusDiscount == ACTIVE)
                            (<em class="text-danger">Sale: {{ $each->discountPrice }}%</em>)
                            @endif
                        </h4>
                        <input type="hidden" id="wishlist_productname{{ $each->id }}" value="{{ $each->name }}">
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++) <i class="fa @if ($i <= $rating_avg) fa-star star @else fa-star-o @endif">
                                </i>
                                @endfor
                                <span> - {{ $count_review }} Reviews / Purchases: {{ $each->count_view }}</span>
                        </div>
                        <h3>
                            @if ($each->statusDiscount == ACTIVE)
                            {{ currency_format(($each->price * (100 - $each->discountPrice)) / 100) }}
                            <span id="wishlist_productpriceold{{ $each->id }}" name="priceDiscount">{{ currency_format($each->price) }}</span>
                            @else
                            {{ currency_format($each->price) }}
                            @endif
                            <input type="hidden" id="wishlist_productprice{{ $each->id }}" value="{{ currency_format(($each->price * (100 - $each->discountPrice)) / 100) }}">
                        </h3>
                        <form data-route="{{ route('cart.store') }}" id="cart-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $each->id }}">
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Size:</span>
                                    @foreach ($each->infos as $value)
                                    @if ($value->status == ACTIVE)
                                    <label class="@if (head($each->infos)[0]->name == $value->name) active @endif" for="{{ $value->name }}">
                                        {{ $value->name }}
                                        <input type="radio" id="{{ $value->name }}" @if (head($each->infos)[0]->name == $value->name) checked @endif
                                        value="{{ $value->name }}" name="size">
                                        <input type="hidden" id="wishlist_productsize{{ $each->id }}" value="{{ $value->name }}">
                                    </label>
                                    @endif
                                    @endforeach

                                </div>
                                <div class="product__details__option__color">
                                    <span>Color:</span>

                                    @foreach ($each->infos2 as $value)
                                    @if ($value->status == ACTIVE)
                                    <label class="{{ $value->class }}" for="{{ $value->name }}">
                                        <input type="radio" id="{{ $value->name }}" @if (head($each->infos2)[0]->name == $value->name) checked @endif
                                        value="{{ $value->name }}" name="color">
                                    </label>
                                    <input type="hidden" id="wishlist_productcolor{{ $each->id }}" value="{{ $value->name }}">
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" name="quantity">
                                    </div>
                                </div>
                                @if ($each->quantity > 0)
                                <button class="primary-btn @if (session('sessionIdCustomer') == null) signIn @endif" @if (session('sessionIdCustomer') !==null) type="submit" @else type="button" data-toggle="modal" data-target="#loginModal" @endif>add
                                    to
                                    cart
                                </button>
                                @else
                                <button type="button" class="primary-btn">out of stock</button>
                                @endif
                            </div>
                        </form>
                        <div class="product__details__btns__option">
                            <button class="button_wishlist border-0 p-0" style="background-color: initial" data-id="{{ $each->id }}"><i class="fa fa-heart"></i> add to wishlist</button>
                            <a href="#"><i class="fa fa-exchange"></i> Add To Compare</a>
                        </div>
                        <div class="product__details__last__option">
                            <h5><span>Guaranteed Safe Checkout</span></h5>
                            {{-- <img src="img/shop-details/details-payment.png" alt=""> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist" style="cursor: pointer;">
                            <li class="nav-item">
                                <span class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Description</span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Customer
                                    Previews({{ $count_review }})</span>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                <div class="product__details__tab__content">
                                    {!! $each->descriptions !!}
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-6" role="tabpanel">
                                <div class="product__details__tab__content">
                                    <div class="product__details__tab__content__item">
                                        <div class="p-2" style="border: 1px solid #e5e7eb;border-radius: 20px;box-shadow: 0px 2px 2px #ccc;">
                                            <div class="d-flex align-items-center p-2">
                                                <h5 class="">Reviews & Comments {{ $each->name }}</h5>
                                            </div>
                                            <div class="row row-review">
                                                <div class="d-flex justify-content-center align-items-center flex-column" style="width:40%; border-right: 1px solid #cccccc6e;">
                                                    <h4 class="font-weight-bold m-0 p-1">{{ $rating }}/5</h4>
                                                    <div>
                                                        @for ($i = 1; $i <= 5; $i++) <div class="icon" style="cursor: pointer;font-size: 1rem;">
                                                            <i class="fa fa-star @if (!empty($rating_avg)) @if ($i <= $rating_avg) star @endif @endif"></i>
                                                    </div>
                                                    @endfor
                                                </div>
                                                <p class="p-1" style="font-size:1rem;">
                                                    <strong>{{ $count_review }}</strong>
                                                    review and comment
                                                </p>
                                            </div>
                                            <div class="d-flex flex-column" style="justify-content: space-evenly;width:60%">
                                                @for ($i = 5; $i >= 1; $i--)
                                                <div class="d-flex align-items-center" style="justify-content: space-evenly;">
                                                    <div class="d-flex align-items-center">
                                                        <span style="font-size: 0.9rem;
                                                                    margin-right: 3px;
                                                                    font-weight: 700;">{{ $i }}</span>
                                                        <i class="fa fa-star star" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                    <progress max="{{ $count_review }}" value="{{ $reviews["$i"] }}" class="progress is-small m-0" style="max-width: 72%;
                                                                            height: 8px;
                                                                            width:100%;
                                                                            border-radius: 5px;"></progress>
                                                    <span style="width: 70px;font-size: 0.85rem;">{{ $reviews["$i"] }}
                                                        review</span>
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center p-2">
                                            <p class="text-review">How would you rate this product</p>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <button type="button" class="btn-review 
                                            @if (session('sessionIdCustomer') == null) signIn @endif" 
                                            @if (session('sessionIdCustomer') !==null) 
                                            @if (!in_array(session('sessionIdCustomer'), $check_review['customer_id'])) 
                                            data-toggle="modal" data-target="#centermodal" 
                                            @else onClick="alert('Bạn đã review sản phẩm này rồi!!')" @endif @else data-toggle="modal" data-target="#loginModal" @endif>Review</button>
                                            <div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog full-width modal-dialog-centered">
                                                    <div class="modal-content p-0">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="font-size: 1.05rem;
                                                                    font-weight: 700;" id="myCenterModalLabel">
                                                                Product reviews & comments</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('reviewProducts') }}" method="post" enctype="multipart/form-data" id="review-form">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $each->id }}">
                                                                <input type="hidden" name="customer_id" value="{{ session('sessionIdCustomer') }}">

                                                                <div class="d-flex align-items-center mb-3 ml-4 mr-4">
                                                                    @for ($count = 1; $count <= 5; $count++) <div class="rating" style="font-size: 1.5rem;padding:0 12px;" data-index="{{ $count }}" data-product_id="{{ $each->id }}">
                                                                        <i id="{{ $each->id }}-{{ $count }}" class="fa fa-star" style="cursor: pointer;">
                                                                        </i>
                                                                </div>
                                                                @endfor
                                                                <input type="hidden" name="ratings" value="1">
                                                        </div>
                                                        <div class="group-input d-flex mb-3">
                                                            <input id="image-text" type="text" class="form-control" style="flex: 8;border-bottom-right-radius: 0;border-top-right-radius: 0;" placeholder="Reality image">
                                                            <input id="image-comments" accept="image/x-png,image/gif,image/jpeg" multiple="multiple" type="file" class="d-none" name="images[]">
                                                            <label for="image-comments" class=" d-flex align-items-center mb-0 p-2" style="font-size: 0.9rem;flex: 2;height:38px;justify-content: space-evenly;background-color: #cccccc7d;border-bottom-right-radius: 0.25rem;border-top-right-radius: 0.25rem;cursor: pointer;">
                                                                <div style="width:18px">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                                        <path d="M147.8 192H480V144C480 117.5 458.5 96 432 96h-160l-64-64h-160C21.49 32 0 53.49 0 80v328.4l90.54-181.1C101.4 205.6 123.4 192 147.8 192zM543.1 224H147.8C135.7 224 124.6 230.8 119.2 241.7L0 480h447.1c12.12 0 23.2-6.852 28.62-17.69l96-192C583.2 249 567.7 224 543.1 224z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                                More photos
                                                            </label>
                                                        </div>
                                                        <div class="content-review mb-3">
                                                            <textarea class="form-control" placeholder="Please share some product reviews" rows="5" name="review_content"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn-review" style="width: 100%; padding: 5px; font-size: 0.9rem;">Submit
                                                            review</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <div class="boxReview-comment my-3 mx-2">
                                        @if (count($show_reviews) > 0)
                                        @foreach ($show_reviews as $value)
                                        @if ($value->action === ACTIVE)
                                        <div class="boxReview-comment-item">
                                            <div class="boxReview-comment-item-title d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <p class="mr-2 d-flex align-items-center justify-content-center name-letter text-uppercase">
                                                        {{ substr($value->name, 0, 1) }}</p>
                                                    <span class="name_user text-capitalize">{{ $value->name }}</span>
                                                </div>
                                                <p class="date-time">{{ $value->created_at }}</p>
                                            </div>
                                            @if ($value->images !== null)
                                            @php $images_review = json_decode($value->images)['0'] @endphp

                                            <div class="p-2" style="margin-left: 40px; width: 100px">
                                                <img src="{{ asset("storage/$images_review") }}" alt="" style="display: block; width:100%;height:100%">
                                            </div>
                                            @endif
                                            <div class="boxReview-comment-item-review my-2 p-2">
                                                <div class="item-review-rating d-flex align-items-center">
                                                    <strong>Review: </strong>
                                                    <div class="ml-2">
                                                        @for ($i = 1; $i <= 5; $i++) <i class="fa @if ($i <= $value->review) fa-star star @else fa-star-o @endif"></i>
                                                            @endfor
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between flex-column">
                                                    <div>
                                                        <p><strong>Comment: </strong>
                                                            {{ $value->content }}
                                                        </p>
                                                    </div>
                                                    {{-- <div class="comment-image d-flex"></div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        @else
                                        <div class="boxReview-no-comment my-2 d-flex justify-content-center align-items-center">
                                            There are currently no reviews. Be the first to comment
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-2 mt-3" style="border: 1px solid #e5e7eb;border-radius: 20px;box-shadow: 0px 2px 2px #ccc;background-color: #f3f4f6;">
                                    <div class="d-flex align-items-center p-2">
                                        <h5 class="">Ask and answer</h5>
                                    </div>
                                    <div class="comment-form-content">
                                        <form class="form-group mx-2" data-route="{{ route('addComments') }}" id="comment-form">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ session('sessionIdCustomer') }}">
                                            <input type="hidden" name="product_id" value="{{ $each->id }}">
                                            <div class="textarea-comment">
                                                <textarea placeholder="Please leave a question, ShopMaleFashion will reply in 1h, questions after 10pm - 8am will be answered the next morning" class="form-control" name="content"></textarea>
                                                <button class="button-comment @if (session('sessionIdCustomer') === null) signIn @endif" @if (session('sessionIdCustomer') !==null) type="submit" @else type="button" data-toggle="modal" data-target="#loginModal" @endif>
                                                    <div class="icon-paper-plane"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                    Send
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="boxComment my-3 mx-2">
                                        @if (count($show_comments) > 0)
                                        @foreach ($show_comments as $show_comment)
                                        <div class="boxComment-item" @if ($show_comment->status === NOT_ACTIVE) style="opacity: 0.7;" @endif>
                                            <div class="boxComment-content">
                                                <div class="boxReview-comment-item-title d-flex justify-content-between align-items-center my-3">
                                                    <div class="d-flex align-items-center">
                                                        <p class="mr-2 d-flex align-items-center justify-content-center name-letter text-uppercase">
                                                            {{ substr($show_comment->name, 0, 1) }}
                                                        </p>
                                                        <span class="name_user text-capitalize">{{ $show_comment->name }}</span>
                                                    </div>
                                                    <p class="date-time">
                                                        {{ $show_comment->created_at }}
                                                    </p>
                                                </div>
                                                <div class="boxComment-item-form">
                                                    <div class="comment-content">
                                                        <p>
                                                            {{ $show_comment->content }}
                                                        </p>
                                                    </div>
                                                    <button @if ($show_comment->status === ACTIVE) onclick="rep_cmt({{ $show_comment->id }})" @endif
                                                        class="btn-rep-cmt">
                                                        <div><svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 12 10.8">
                                                                <path id="chat" d="M3.48,8.32V4.6H1.2A1.2,1.2,0,0,0,0,5.8V9.4a1.2,1.2,0,0,0,1.2,1.2h.6v1.8l1.8-1.8h3A1.2,1.2,0,0,0,7.8,9.4V8.308a.574.574,0,0,1-.12.013H3.48ZM10.8,1.6H5.4A1.2,1.2,0,0,0,4.2,2.8V7.6H8.4l1.8,1.8V7.6h.6A1.2,1.2,0,0,0,12,6.4V2.8a1.2,1.2,0,0,0-1.2-1.2Z" transform="translate(0 -1.6)" fill="#fa2f2f"></path>
                                                            </svg></div>&nbsp;Reply
                                                    </button>
                                                </div>
                                                @if ($show_comment->status === NOT_ACTIVE)
                                                <span class="ml-3 p-1 d-block" style="font-size: 0.9rem;font-weight: 600;">->*This
                                                    comment is currently pending
                                                    approval*</span>
                                                @endif
                                                <div class="boxComment-list-items">
                                                    @if (count($show_comment->parents) > 0)
                                                    @foreach ($show_comment->parents as $comment_parent)
                                                    <div class="boxComment-list-item" @if ($comment_parent->status !== ACTIVE) style="opacity: 0.7;" @endif>
                                                        <div class="boxReview-comment-item-title d-flex justify-content-between align-items-center my-3">
                                                            <div class="d-flex align-items-center">
                                                                <p class="mr-2 d-flex align-items-center justify-content-center name-letter text-uppercase">
                                                                    {{ substr($comment_parent->name, 0, 1) }}
                                                                </p>
                                                                <span class="name_user text-capitalize">{{ $comment_parent->name }}</span>
                                                            </div>
                                                            <p class="date-time">
                                                                {{ $comment_parent->created_at }}
                                                            </p>
                                                        </div>
                                                        <div class="boxComment-item-form">
                                                            <div class="comment-content">
                                                                <p>
                                                                    {{ $comment_parent->content }}
                                                                </p>
                                                            </div>
                                                            <button @if ($comment_parent->status === ACTIVE) onclick="rep_cmt ({{ $comment_parent->parent_id }})" @endif
                                                                class="btn-rep-cmt">
                                                                <div><svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 12 10.8">
                                                                        <path id="chat" d="M3.48,8.32V4.6H1.2A1.2,1.2,0,0,0,0,5.8V9.4a1.2,1.2,0,0,0,1.2,1.2h.6v1.8l1.8-1.8h3A1.2,1.2,0,0,0,7.8,9.4V8.308a.574.574,0,0,1-.12.013H3.48ZM10.8,1.6H5.4A1.2,1.2,0,0,0,4.2,2.8V7.6H8.4l1.8,1.8V7.6h.6A1.2,1.2,0,0,0,12,6.4V2.8a1.2,1.2,0,0,0-1.2-1.2Z" transform="translate(0 -1.6)" fill="#fa2f2f">
                                                                        </path>
                                                                    </svg></div>
                                                                &nbsp;Reply
                                                            </button>
                                                        </div>
                                                        @if ($comment_parent->status === NOT_ACTIVE)
                                                        <span class="ml-3 p-1 d-block" style="font-size: 0.9rem;font-weight: 600;">-&gt;*This
                                                            comment is currently pending
                                                            approval*</span>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <form class="form-group mx-2" data-route="{{ route('addComments') }}" id="comment-form2">
                                                <input type="hidden" name="comment_id" value="{{ $show_comment->id }}">
                                                <input type="hidden" name="user_id" value="{{ session('sessionIdCustomer') }}">
                                                <div id="comment-text-{{ $show_comment->id }}" class="textarea-comment mt-2 d-none" style="width: calc(100% - 25px);
                                                                            margin-left: auto;">
                                                    <textarea placeholder="Please leave a question, ShopMaleFashion will reply in 1h, questions after 10pm - 8am will be answered the next morning" class="form-control" name="content"></textarea>
                                                    <button class="button-comment @if (session('sessionIdCustomer') === null) signIn @endif" @if (session('sessionIdCustomer') !==null) type="submit" @else type="button" data-toggle="modal" data-target="#loginModal" @endif>
                                                        <div class="icon-paper-plane"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                        Send
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="boxReview-no-comment my-2 d-flex justify-content-center align-items-center">
                                            There are currently no reviews. Be the first to comment
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</section>
<!-- Shop Details Section End -->

<!-- Related Section Begin -->
<section class="related spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="related-title">Related Product</h3>
            </div>
        </div>
        <div class="row">
            @if (!empty($productRelated))
            @foreach ($productRelated as $value)
            @php
            $image = json_decode($value->image)[0];
            $productPrice = 1;
            if ($value->statusDiscount == ACTIVE && $value->discountPrice != null) {
            $productPrice = $value->discountPrice;
            }

            $date = $value->created_at;
            $date_end = Carbon\Carbon::now()->addDays(-7);
            @endphp
            <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" id="wishlist_productimage{{ $value->id }}" @if ($value->statusImage == ACTIVE) data-setbg="{{ asset("storage/$image") }}" @endif>
                        @if ($value->discountPrice != null && $value->statusDiscount == ACTIVE)
                        <span class="item-sale">-{{ (1 - $value->discountPrice) * 100 }}%</span>
                        @endif
                        @if ($date >= $date_end)
                        <span class="label">New</span>
                        @endif
                        <ul class="product__hover">
                            <li>
                                <button class="button_wishlist  border-0 p-0 bg-gradient-light" data-id="{{ $value->id }}"><img src="{{ asset('frontend/img/icon/heart.png') }}" alt=""></button>
                            </li>
                            <li><a href="#"><img src="{{ asset('frontend/img/icon/compare.png') }}" alt="">
                                    <span>Compare</span></a></li>
                            <li><a id="wishlist_producturl{{ $value->id }}" href="{{ route('productDetail', Str::slug($value->name, '-')) }}"><img src="{{ asset('frontend/img/icon/search.png') }}" alt=""></a>
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" id="wishlist_productname{{ $value->id }}" value="{{ $value->name }}">
                    <div class="product__item__text">
                        <h6>{{ $value->name }}</h6>
                        <a href="{{ route('productDetail', Str::slug($value->name, '-')) }}" class="add-cart">+
                            Add To Cart</a>
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++) <i class="fa @if ($i <= $value->review) fa-star star @else fa-star-o @endif"></i>
                                @endfor
                        </div>
                        <h5>
                            {{ currency_format($value->price * $productPrice) }}
                            @if ($value->discountPrice != null && $value->statusDiscount == ACTIVE)
                            <em id="wishlist_productpriceold{{ $value->id }}" style="text-decoration:line-through">{{ currency_format($value->price) }}</em>
                            @endif
                        </h5>
                        <input type="hidden" id="wishlist_productprice{{ $value->id }}" value="{{ currency_format($value->price * $productPrice) }}">
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
<!-- Related Section End -->
@endsection
@push('js')
<script type="text/javascript">
    function remove_class(product_id) {
        for (var count = 0; count <= 5; count++) {
            $('#' + product_id + '-' + count).removeClass('star');
        }
    }

    function rep_cmt(id) {
        $('#comment-text-' + id).removeClass('d-none');
        $('html, body').animate({
            scrollTop: $('#comment-text-' + id).offset().top - $('#comment-text-' + id).prop("scrollHeight") *
                2
        }, 1500);
    }
    $(document).ready(function() {
        $('#cart-form').on('submit', function(e) {
            e.preventDefault();
            let userId = $("input[name=userId]").val();
            let id = $("input[name=id]").val();
            let size = $("input:radio[name=size]:checked").val();
            let color = $("input:radio[name=color]:checked").val();
            let quantity = $("input[name=quantity]").val();
            let discount = "{{ $each->discountPrice }}";
            let image = "{{ head(json_decode($each->image)) }}";
            let price = "{{ $each->price }}";
            let name = "{{ $each->name }}";
            $.ajax({
                type: "POST"
                , url: $(this).data('route')
                , data: {
                    userId: userId
                    , id: id
                    , size: size
                    , color: color
                    , quantity: quantity
                    , discount: discount
                    , image: image
                    , price: price
                    , name: name
                , }
                , success: function(response, textStatus, xhr) {
                    if (xhr.status == 200) {
                        $.toast({
                            heading: 'Add Product!'
                            , text: (response)
                            , showHideTransition: 'slide'
                            , position: 'top-right'
                            , icon: 'success'
                        });
                        var total = Number(quantity);
                        $(".carts-total").each(function() {
                            total += parseFloat($(this).text());
                            $(this).text(total);
                        });
                        $(".carts-total_mobi").each(function() {
                            $(this).text(total);
                        });

                        $(".carts-price").each(function() {
                            price = price * (100 - discount) / 100;
                            newPrice = (price * quantity) + $(this).data("price");
                            $(this).data("price", newPrice);
                            newPrice = newPrice.toLocaleString('vi', {
                                style: 'currency'
                                , currency: 'VND'
                            });
                            $(this).text(newPrice);
                        });
                        $(".carts-price_mobi").each(function() {
                            $(this).text(newPrice);
                        });
                    } else {
                        $.toast({
                            heading: 'Add Product Warning!'
                            , text: (response)
                            , showHideTransition: 'slide'
                            , position: 'top-right'
                            , icon: 'warning'
                        });
                    }
                }
                , error: function(response) {
                    $.toast({
                        heading: 'Add Product Error!'
                        , text: (response)
                        , showHideTransition: 'slide'
                        , position: 'top-right'
                        , icon: 'error'
                    });
                }
            });

        });

        $('#image-comments').change(function(e) {
            e.preventDefault();
            // var fileName = e.target.files;
            var names = [];
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            $("#image-text").val(names);
        });

        $('.rating').on('mouseenter', function(e) {
            e.preventDefault();
            var index = $(this).data('index');
            var product_id = $(this).data('product_id');
            remove_class(product_id);
            for (var count = 0; count <= index; count++) {
                $('#' + product_id + '-' + count).addClass('star');
            }
            $("input[name*='ratings']").val(index);
        });

        $('#review-form').on('submit', function(e) {
            var content = $(this).find("textarea[name='review_content']");
            var checkStr = content.val().length >= 6;
            if (content.val().length === 0) {
                $(this).find('.text-danger').remove();
                $(this).find('.content-review').append(
                    '<p class="text-danger ml-2 mt-2"></p>');
                $(this).find('.text-danger').text("Please enter content(*Required)").show()
                    .fadeOut(
                        3000);
                e.preventDefault();
                return false;
            }
            if (!checkStr) {
                $(this).find('.text-danger').remove();
                $(this).find('.content-review').append(
                    '<p class="text-danger ml-2 mt-2"></p>');
                $(this).find('.text-danger').text("Please enter more than 6 characters").show().fadeOut(
                    3000);
                e.preventDefault();
                return false;
            }
            $('.btn-review').prop("disabled", true);
        });

        $('#comment-form').on('submit', function(e) {
            e.preventDefault();
            let userId = $("input[name=user_id]").val();
            let productId = $("input[name=product_id]").val();
            var content = $(this).find("textarea[name=content]").val();
            var checkStr = content.length >= 6;
            if (content.length === 0) {
                $(this).find('.text-danger').remove();
                $(this).append(
                    '<p class="text-danger ml-2 mt-1"></p>');
                $(this).find('.text-danger').text("Please enter content(*Required)").show()
                    .fadeOut(
                        3000);
                return false;
            }
            if (!checkStr) {
                $(this).find('.text-danger').remove();
                $(this).append(
                    '<p class="text-danger ml-2 mt-1"></p>');
                $(this).find('.text-danger').text("Please enter more than 6 characters").show().fadeOut(
                    3000);
                return false;
            }
            $('.button-comment').prop("disabled", true);
            $.ajax({
                type: "POST"
                , url: $(this).data('route')
                , data: {
                    customer_id: userId
                    , product_id: productId
                    , content: content
                }
                , success: function(response, textStatus, xhr) {
                    $.toast({
                        heading: 'Add Comments success!'
                        , text: (response)
                        , showHideTransition: 'slide'
                        , position: 'top-right'
                        , icon: 'success'
                    });
                    window.location.reload(true);
                }
                , error: function(response) {
                    $.toast({
                        heading: 'Add Comments Error!'
                        , text: (response)
                        , showHideTransition: 'slide'
                        , position: 'top-right'
                        , icon: 'error'
                    });
                }
            });
        });

        $('#comment-form2').on('submit', function(e) {
            e.preventDefault();
            let comment_id = $("input[name=comment_id]").val();
            let user_id = $("input[name=user_id]").val();
            var content = $(this).find("textarea[name=content]").val();
            var checkStr = content.length >= 6;
            if (content.length === 0) {
                $(this).find('.text-danger').remove();
                $(this).append(
                    '<p class="text-danger ml-2 mt-1"></p>');
                $(this).find('.text-danger').text("Please enter content(*Required)").show()
                    .fadeOut(
                        3000);
                return false;
            }
            if (!checkStr) {
                $(this).find('.text-danger').remove();
                $(this).append(
                    '<p class="text-danger ml-2 mt-1"></p>');
                $(this).find('.text-danger').text("Please enter more than 6 characters").show().fadeOut(
                    3000);
                return false;
            }
            $('.button-comment').prop("disabled", true);
            $.ajax({
                type: "POST"
                , url: $(this).data('route')
                , data: {
                    comment_id: comment_id
                    , customer_id: user_id
                    , content: content
                }
                , success: function(response, textStatus, xhr) {
                    $.toast({
                        heading: 'Add Comments success!'
                        , text: (response)
                        , showHideTransition: 'slide'
                        , position: 'top-right'
                        , icon: 'success'
                    });
                    window.location.reload(true);
                }
                , error: function(response) {
                    $.toast({
                        heading: 'Add Comments Error!'
                        , text: (response)
                        , showHideTransition: 'slide'
                        , position: 'top-right'
                        , icon: 'error'
                    });
                }
            });
        });
    });

</script>
@endpush
