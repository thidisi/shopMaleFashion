@extends('backend.layout_admin')
@php
$title = 'Tickets';
@endphp
@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-2 text-gray-800">Tickets create</h1>
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="d-M-yyyy" data-date-autoclose="true" name="date_start">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" class="form-control" name="price">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Customer</label>
                                        <select class="form-control select2" data-toggle="select2" name="customer_id[]" multiple>
                                            @foreach ($customers as $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="float-right mt-2 ml-1 btn btn-primary">Create</button>
                                <a href="{{ route('admin.discounts') }}" class="float-right mt-2 btn btn-info">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
