@extends('backend.layout_admin')
@php
$title = 'Attributes';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">Attributes create</h1>
                        <form action="{{ route('admin.attributes.store') }}" method="post">
                            @csrf
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
                                <input type="text" class="form-control" name="slug">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description(* Can Be Empty)</label>
                                @if ($errors->has('descriptions'))
                                    <p class="text-capitalize text-danger">{{ $errors->first('descriptions') }}</p>
                                @endif
                                <textarea class="form-control" name="descriptions" rows="5" placeholder="Enter some brief about desciption.."></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Replace </label>
                                @if ($errors->has('replace_id'))
                                    <p class="text-capitalize text-danger">{{ $errors->first('replace_id') }}
                                    </p>
                                @endif
                                <select class="form-control select2" data-toggle="select2" name="replace_id">
                                    @foreach ($replace as $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->name}}
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
                            <a href="{{ route('admin.attributes') }}" class="float-right btn btn-info">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
