@extends('backend.layout_admin')
@php
$title = 'Blogs';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">Blogs edit</h1>
                        <form action="{{ route('admin.blogs.update', $each) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        @if ($errors->has('title'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('title') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="title" value="{{ $each->title}}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">New Avatar</label>
                                        @if ($errors->has('photo_new'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('photo_new') }}</p>
                                        @endif
                                        <input class="form-control" type="file" name="photo_new">
                                    </div>
                                    <label for="" class="form-label">Or Avatar Old</label>
                                    <div class="mb-3">
                                        @if ($each->image != '')
                                            <img height="150" src="{{ asset("storage/$each->image") }}">
                                        @else
                                            <img height="150" src="{{ asset('backend/images/products/product-1.jpg') }}">
                                        @endif
                                        <input type="hidden" name="photo_old" value="{{ $each->image }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="float-right">
                                            <input type="checkbox" id="switch3" @if ($each->status == 1) checked @endif data-switch="success"
                                                name="status" />
                                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Content</label>
                                        @if ($errors->has('content'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('content') }}</p>
                                        @endif
                                        <textarea id="ckeditor-blog" class="form-control" name="content" rows="8" placeholder="Enter some brief about blog..">{{ $each->content }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="mt-2 ml-1 btn btn-primary float-right">Edit</button>
                            <a href="{{ route('admin.blogs') }}" class="mt-2 float-right btn btn-info">Back</a>
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
            if(fileInput.files && fileInput.files[0]){
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
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('ckeditor-blog');
            
        });
    </script>
@endpush
