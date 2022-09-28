@extends('backend.layout_admin')
@php
$title = 'Silde';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">Slide create</h1>
                        <form action="{{ route('admin.slides.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        @if ($errors->has('title'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('title') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Image (May multiple upload)</label>
                                        @if ($errors->has('fileData'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('fileData') }}</p>
                                        @endif
                                        <input multiple class="form-control" type="file" name="fileData[]" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">sortOrder</label>
                                        <select class="form-control select2" data-toggle="select2" name="sort_order" id="">
                                            @foreach ($sortOrder as $key => $value)
                                                <option value="{{ $key + 1 }}">
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label">Menu</label>
                                        <select class="form-control select2" data-toggle="select2" name="major_category_id" id="">
                                            @foreach ($menu as $each)
                                                <option value="{{ $each->id }}">
                                                    {{ $each->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Slug</label>
                                        @if ($errors->has('slug'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('slug') }}</p>
                                        @endif
                                        <textarea class="form-control" name="slug" rows="8" placeholder="Enter some brief about slide.."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="float-right">
                                            <input type="checkbox" id="switch3" checked data-switch="success"
                                                name="status" />
                                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="mt-2 ml-1 btn btn-primary float-right">Create</button>
                            <a href="{{ route('admin.slides') }}" class="float-right mt-2 btn btn-info">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection