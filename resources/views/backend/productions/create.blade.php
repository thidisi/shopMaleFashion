@extends('backend.layout_admin')
@php
$title = 'Productions';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <h1 class="h3 text-gray-800">Productions create</h1>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.productions.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        @if ($errors->has('name'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Price</label>
                                        @if ($errors->has('price'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('price') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="price">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Quantity</label>
                                        @if ($errors->has('quantity'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('quantity') }}</p>
                                        @endif
                                        <input type="number" class="form-control" name="quantity">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Description(* Can Be Empty)</label>
                                        @if ($errors->has('descriptions'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('descriptions') }}</p>
                                        @endif
                                        <textarea id="ckeditor-product" class="form-control" name="descriptions" rows="8" placeholder="Enter some brief about desciption.."></textarea>
                                    </div>
                                    
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <select class="form-control select2" data-toggle="select2" name="category_id" id="">
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Image(*May Multie)</label>
                                        <div class="float-right">
                                            <input type="checkbox" id="switch4" checked data-switch="success"
                                                name="status_image" />
                                            <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                        @if ($errors->has('fileData'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('fileData') }}</p>
                                        @endif
                                        <input multiple class="form-control" type="file" name="fileData[]" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Choose Size</label>
                                        <select class="form-control select2" data-toggle="select2" name="attrValue1[]" multiple>
                                            @foreach ($attrValueSize as $each)
                                                <option value="{{ $each->id }}">
                                                    {{ $each->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Choose Color</label>
                                        <select class="form-control select2" data-toggle="select2" name="attrValue">
                                            @foreach ($attrValueColor as $each)
                                                <option value="{{ $each->id }}">
                                                    {{ $each->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
                            <button type="submit" class="float-right ml-1 btn btn-primary">Create</button>
                            <a href="{{ route('admin.productions') }}" class="float-right btn btn-info">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('ckeditor-product')
    </script>
@endpush

