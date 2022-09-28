@extends('backend.layout_admin')
@php
$title = 'Categories';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Categories create</h1>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.categories.update', $each) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                @if ($errors->has('name'))
                                    <p class="text-capitalize text-danger">{{ $errors->first('name') }}</p>
                                @endif
                                <input type="text" class="form-control" name="name" value="{{ $each->name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                @if ($errors->has('slug'))
                                    <p class="text-capitalize text-danger">{{ $errors->first('slug') }}</p>
                                @endif
                                <textarea class="form-control" name="slug" rows="5" placeholder="Enter some brief about category..">{{ $each->slug }}</textarea>
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
                                @if ($each->avatar != '')
                                    <img height="150" src="{{ asset("storage/$each->avatar") }}">
                                @else
                                    <img height="150" src="{{ asset('backend/images/products/product-1.jpg') }}">
                                @endif
                                <input type="hidden" name="photo_old" value="{{ $each->avatar }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Major Category Id</label>
                                <select class="form-control" name="major_category_id" id="">
                                    @foreach ($major_categories as $value)
                                        <option value="{{ $value->id }}" @if ($value->id == $each->major_category_id) selected @endif>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="float-right">
                                    <input type="checkbox" id="switch3" @if ($each->status == 1) checked @endif data-switch="success" name="status" />
                                    <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <button type="submit" class="float-right ml-1 btn btn-primary">Edit</button>
                            <a href="{{ route('admin.categories') }}" class="float-right btn btn-info">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
