@extends('backend.layout_admin')
@php
    $title = 'AttributeValues';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">AttributeValues edit</h1>
                        <form action="{{ route('admin.attributeValues.update', $each) }}" method="post">
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
                                <input type="text" class="form-control" name="slug" value="{{ $each->slug }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description(* Can Be Empty)</label>
                                @if ($errors->has('descriptions'))
                                    <p class="text-capitalize text-danger">{{ $errors->first('descriptions') }}</p>
                                @endif
                                <textarea class="form-control" name="descriptions" rows="5" placeholder="Enter some brief about desciption..">{{ $each->descriptions }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Attribute</label>
                                <select class="form-control select2" data-toggle="select2" name="attribute_id">
                                    @foreach ($attr as $value)
                                        @foreach ($value->replaces as $valueSize)
                                            <option value="{{ $valueSize->id }}"
                                                @if ($valueSize->id == $each->attribute_id) selected @endif>
                                                {{ $valueSize->name }}
                                            </option>
                                        @endforeach
                                        @if (!(count($value->replaces) > 0))
                                            <option value="{{ $value->id }}"
                                                @if ($value->id == $each->attribute_id) selected @endif>
                                                {{ $value->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="float-right">
                                    <input type="checkbox" id="switch3" @if ($each->status == 'active') checked @endif
                                        data-switch="success" name="status" />
                                    <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <button type="submit" class="float-right ml-1 btn btn-primary">Edit</button>
                            <a href="{{ route('admin.attributes') }}" class="float-right btn btn-info">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
