@extends('backend.layout_admin')
@php
    $title = 'Orders';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Orders list</h1>
        @empty(!session('UpdateOrderSuccess'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('UpdateOrderSuccess') }}
            </div>
        @endempty
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="orders-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th class="all">Info Receiver</th>
                                        <th>Total Money</th>
                                        <th>Action</th>
                                        <th>Created_at</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $value)
                                        <tr>
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                Name: {{ $value->name_receiver }}
                                                <br>
                                                Phone: {{ $value->phone_receiver }}
                                                <br>
                                                Address: {{ $value->address_receiver }}
                                                <br>
                                                Note: {{ $value->note }}
                                            </td>
                                            <td>
                                                {{ $value->total_money }}
                                            </td>
                                            <td>
                                                @switch($value->action)
                                                    @case('active')
                                                        <div>
                                                            <span class="text-success font-weight-bold text-center"
                                                                style="max-width: 100px;">Order approved</span>
                                                        </div>
                                                    @break

                                                    @case('inactive')
                                                        <div>
                                                            <span class="text-danger font-weight-bold text-center"
                                                                style="max-width: 100px;">Order has been cancelled</span>
                                                        </div>
                                                    @break

                                                    @default
                                                        <div>
                                                            <span class="text-warning font-weight-bold text-center"
                                                                style="max-width: 100px;">Waiting for approval</span>
                                                        </div>
                                                @endswitch
                                            </td>
                                            <td>
                                                {{ $value->created_at }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $value->id) }}" class="action-icon">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
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
    <script src="{{ asset('backend/js/backend/demo.orders.js') }}"></script>
@endpush
