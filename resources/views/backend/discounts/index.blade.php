@extends('backend.layout_admin')
@php
$title = 'Discounts';
@endphp
@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-0 p-1 text-gray-800">Discounts list</h1>
    @empty(!session('EditDiscountStatus'))
    <div class="alert alert-success mt-2" role="alert">
        {{ session('EditDiscountStatus') }}
    </div>
    @endempty
    @empty(!session('addDiscountStatus'))
    <div class="alert alert-success mt-2" role="alert">
        {{ session('addDiscountStatus') }}
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
                            <a href="{{ route('admin.discounts.create') }}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Add Discounts</a>
                        </div>
                    </div>
                    <div class="table-responsive my-3">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="discounts-datatable">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Date start</th>
                                    <th>Date end</th>
                                    <th>Discount price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discounts as $value)
                                <tr class="text-center">
                                    <td>
                                        {{ $value->id }}
                                    </td>
                                    <td>
                                        {{ $value->date_start }}
                                    </td>
                                    <td>
                                        {{ $value->date_end }}
                                    </td>

                                    <td>{{ $value->discount_price }}%</td>

                                    <td class="table-action">
                                        @if($value->status == 'active')
                                            <small class="mdi mdi-checkbox-blank-circle text-success align-middle mr-1 mb-1 d-inline-block"></small>
                                        @else
                                            <small class="mdi mdi-checkbox-blank-circle text-danger align-middle mr-1 mb-1 d-inline-block"></small>
                                        @endif
                                        <a href="{{ route('admin.discounts.edit', $value->id) }}" class="action-icon ml-1">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                        <form class="d-inline-block ml-1 formd-submit" action="{{ route('admin.discounts.destroy', $value) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-icon" style="border: none;background: none;"><i class="mdi mdi-delete"></i></button>
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
<script src="{{ asset('backend/js/backend/demo.discounts.js') }}"></script>
@endpush
