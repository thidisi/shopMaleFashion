@extends('backend.layout_admin')
@php
$title = 'About';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">About list</h1>
                        @empty(!session('EditAboutSuccess'))
                            <div class="alert alert-success mt-2" role="alert">
                                {{ session('EditAboutSuccess') }}
                            </div>
                        @endempty
                        @empty(!session('EditAboutErrors'))
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ session('EditAboutErrors') }}
                            </div>
                        @endempty
                        <form action="{{ route('admin.abouts.update', $each->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        @if ($errors->has('title'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('title') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="title"
                                            value="{{ $each->title }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">New Logo</label>
                                        @if ($errors->has('logo_new'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('logo_new') }}</p>
                                        @endif
                                        <input onchange="chooseFile(this)" class="form-control" type="file"
                                            name="logo_new">
                                        <div class="p-2" id="imageTitle"></div>
                                    </div>
                                    <label for="" class="form-label">Or Logo Old</label>
                                    <div class="mb-3">
                                        @if ($each->logo != '')
                                            <img width="150" src="{{ asset("storage/$each->logo") }}">
                                        @else
                                            <img width="150" src="{{ asset('backend/images/products/product-1.jpg') }}">
                                        @endif
                                        <input type="hidden" name="logo_old" value="{{ $each->logo }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        @if ($errors->has('email'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="email"
                                            value="{{ $each->email }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        @if ($errors->has('phone'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('phone') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ $each->phone }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone Seconds(*)</label>
                                        <input type="text" class="form-control" name="phone_second"
                                            value="{{ $each->phone_second }}">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        @if ($errors->has('address'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('address') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $each->address }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address Seconds(*)</label>
                                        <input type="text" class="form-control" name="address_second"
                                            value="{{ $each->address_second }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Branch</label>
                                        @if ($errors->has('branch'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('branch') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="branch"
                                            value="{{ $each->branch }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Branch Seconds(*)</label>
                                        <input type="text" class="form-control" name="branch_second"
                                            value="{{ $each->branch_second }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Link Address_fb(*)</label>
                                        <input type="text" class="form-control" name="link_address_fb"
                                            value="{{ $each->link_address_fb }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Link Address_youtube(*)</label>
                                        <input type="text" class="form-control" name="link_address_youtube"
                                            value="{{ $each->link_address_youtube }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Link Address_zalo(*)</label>
                                        <input type="text" class="form-control" name="link_address_zalo"
                                            value="{{ $each->link_address_zalo }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Link Address_instagram(*)</label>
                                        <input type="text" class="form-control" name="link_address_instagram"
                                            value="{{ $each->link_address_instagram }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="mt-2 btn btn-danger float-right">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        function chooseFile(fileInput) {
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var srcData = e.target.result;
                    var newImage = document.createElement('img');
                    newImage.style.width = '20%';
                    newImage.src = srcData;
                    document.getElementById('imageTitle').innerHTML = newImage.outerHTML;
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
@endpush
