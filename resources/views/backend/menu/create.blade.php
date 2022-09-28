@extends('backend.layout_admin')
@php
$title = 'Menu';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">Menu create</h1>
                        <form action="{{ route('admin.major-categories.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                @if ($errors->has('name'))
                                    <p class="text-capitalize text-danger">{{ $errors->first('name') }}</p>
                                @endif
                                @empty(!session('NameMajorCategory'))
                                    <p class="text-capitalize text-danger">{{ session('NameMajorCategory') }}</p>
                                @endempty
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="">
                                    @foreach ($status as $key => $value)
                                        <option value="{{ $key + 1 }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="float-right mt-2 ml-1 btn btn-primary">Create</button>
                            <a href="{{ route('admin.major-categories') }}"
                                        class="float-right mt-2 btn btn-info">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
