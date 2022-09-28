@extends('backend.layout_admin')
@php
$title = 'DiscountProducts';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">DiscountProducts edit</h1>
                        <form action="{{ route('admin.discountProducts.update', $each) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="form-label">Product Name</label>
                                @if ($errors->has('production_id'))
                                    <p class="text-capitalize text-danger">{{ $errors->first('production_id') }}
                                    </p>
                                @endif
                                <select class="form-control select2" data-toggle="select2" name="production_id" >
                                    @foreach ($products as $value)
                                        <option value="{{ $value->id }}" @if($value->id == $each->production_id) selected @endif>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Discount price</label>
                                @if ($errors->has('discount_id'))
                                    <p class="text-capitalize text-danger">{{ $errors->first('discount_id') }}
                                    </p>
                                @endif
                                <select class="form-control select2" data-toggle="select2" name="discount_id">
                                    @foreach ($discounts as $value)
                                        <option value="{{ $value->id }}" @if($value->id == $each->discount_id) selected @endif>
                                            {{ $value->discount_price . '%' }}
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
                            <a href="{{ route('admin.discountProducts') }}" class="float-right btn btn-info">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
