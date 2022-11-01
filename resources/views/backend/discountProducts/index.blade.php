@extends('backend.layout_admin')
@php
$title = 'DiscountProducts';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">DiscountProducts list</h1>
        @empty(!session('editDiscountProductStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('editDiscountProductStatus') }}
            </div>
        @endempty
        @empty(!session('addDiscountProductStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('addDiscountProductStatus') }}
            </div>
        @endempty
        @empty(!session('deleteSuccess'))
            <div class="alert alert-danger mt-2" role="alert">
                {{ session('deleteSuccess') }}
            </div>
        @endempty
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <a href="{{ route('admin.discountProducts.create') }}" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle mr-2"></i> Add DiscountProducts</a>
                            </div>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="discounts-datatable">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th class="all" style="width: 20px;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Productions</th>
                                        <th>Discounts</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discountProducts as $value)
                                        <tr class="text-center">
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                    <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                {{ $value->product_name }}
                                            </td>
                                            <td>
                                                {{ $value->discount_price }}%
                                            </td>

                                            <td class="table-action">
                                                <a href="{{ route('admin.discountProducts.edit', $value) }}"
                                                    class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                <form class="d-inline-block ml-2 formd-submit"
                                                    action="{{ route('admin.discountProducts.destroy', $value) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-icon"
                                                        style="border: none;background: none;"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backend/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('backend/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendor/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendor/dataTables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('backend/js/backend/demo.discount.js') }}"></script>
@endpush

