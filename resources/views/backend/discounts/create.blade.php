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
                        <h1 class="h3 mb-2 text-gray-800">Discounts create</h1>
                        <form action="{{ route('admin.discounts.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        @if ($errors->has('date_start'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('date_start') }}</p>
                                        @endif
                                        <input type="text" class="form-control" data-provide="datepicker"
                                            data-date-format="d-M-yyyy" data-date-autoclose="true" name="date_start">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Due Date</label>
                                        @if ($errors->has('date_end'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('date_end') }}</p>
                                        @endif
                                        <input type="text" class="form-control" data-provide="datepicker"
                                            data-date-format="d-M-yyyy" data-date-autoclose="true" name="date_end">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Discount Price</label>
                                        @if ($errors->has('discount_price'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('discount_price') }}
                                            </p>
                                        @endif
                                        <select class="form-control select2" data-toggle="select2" name="discount_price">
                                            @foreach ($promotions as $value)
                                                <option value="{{ $value }}">
                                                    {{ $value }}%
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="float-right mt-2 ml-1 btn btn-primary">Create</button>
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
