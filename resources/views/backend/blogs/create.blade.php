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
                        <h1 class="h3 mb-2 text-gray-800">Blogs create</h1>
                        <form action="{{ route('admin.blogs.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        @if ($errors->has('title'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('title') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Image</label>
                                        @if ($errors->has('image'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('image') }}</p>
                                        @endif
                                        <input onchange="chooseFile(this)" class="form-control" type="file" name="image">
                                        <div class="p-2" id="imageTitle"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="float-right">
                                            <input type="checkbox" id="switch3" checked data-switch="success"
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
                                        <textarea id="ckeditor-blog" class="form-control" name="content" rows="8" placeholder="Enter some brief about blog.."></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="mt-2 ml-1 btn btn-primary float-right">Create</button>
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
        CKEDITOR.replace('ckeditor-blog')
    </script>
@endpush
