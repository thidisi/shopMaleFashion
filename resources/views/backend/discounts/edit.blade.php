@extends('backend.layout_admin')
@php
$title = 'Discounts';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">Discounts edit</h1>
                        <form action="{{ route('admin.discounts.update', $each) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        @if ($errors->has('date_start'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('date_start') }}</p>
                                        @endif
                                        <input type="text" class="form-control" data-provide="datepicker"
                                            data-date-format="d-M-yyyy" data-date-autoclose="true" name="date_start" value="{{ $each->format_date_start }}">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Due Date</label>
                                        @if ($errors->has('date_end'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('date_end') }}</p>
                                        @endif
                                        <input type="text" class="form-control" data-provide="datepicker"
                                            data-date-format="d-M-yyyy" data-date-autoclose="true" name="date_end" value="{{ $each->format_date_end }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Discount Price</label>
                                        @if ($errors->has('discount_price'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('discount_price') }}
                                            </p>
                                        @endif
                                        <select class="form-control select2" data-toggle="select2" name="discount_price">
                                            @foreach ($promotions as $value)
                                                <option value="{{ $value }}" @if($value == $each->discount_price) selected @endif>
                                                    {{ $value }}%
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Status</label>
                                        <div class="float-right">
                                            <input type="checkbox" id="switch3" @if ($each->status == 'active') checked @endif data-switch="success"
                                                name="status" />
                                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                    <button type="submit" class="float-right ml-1 mt-2 btn btn-primary">Update</button>
                                    <a href="{{ route('admin.discounts') }}"
                                        class="float-right mt-2 btn btn-info">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
