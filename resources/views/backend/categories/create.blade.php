@extends('backend.layout_admin')
@php
$title = 'Categories';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <h1 class="h3 mb-2 text-gray-800">Categories create</h1>
                <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        @if ($errors->has('name'))
                            <p class="text-capitalize text-danger">{{ $errors->first('name') }}</p>
                        @endif
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        @if ($errors->has('slug'))
                            <p class="text-capitalize text-danger">{{ $errors->first('slug') }}</p>
                        @endif
                        <textarea class="form-control" name="slug" rows="5" placeholder="Enter some brief about category.."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Avatar</label>
                        @if ($errors->has('avatar'))
                            <p class="text-capitalize text-danger">{{ $errors->first('avatar') }}</p>
                        @endif
                        <input class="form-control" type="file" name="avatar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Major Category Id</label>
                        <select class="form-control" name="major_category_id" id="">
                            @foreach ($major_categories as $value)
                                <option value="{{ $value->id }}">
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="float-right">
                            <input type="checkbox" id="switch3" checked data-switch="success" name="status" />
                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                    <button type="submit" class="float-right ml-1 btn btn-primary">Create</button>
                    <a href="{{ route('admin.categories') }}" class="float-right btn btn-info">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
