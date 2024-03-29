@extends('backend.layout_admin')
@php
    $title = 'Production';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Production list</h1>
        @empty(!session('EditProductionStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('EditProductionStatus') }}
            </div>
        @endempty
        @empty(!session('ProductionErrors'))
            <div class="alert alert-danger mt-2" role="alert">
                {{ session('ProductionErrors') }}
            </div>
        @endempty
        @empty(!session('deleteSuccess'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('deleteSuccess') }}
            </div>
        @endempty
        @empty(!session('addProductionStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('addProductionStatus') }}
            </div>
        @endempty
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{ route('admin.productions.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle mr-2"></i> Add
                                Production</a>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="productions-datatable">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Images</th>
                                        <th>Price</th>
                                        <th>Info</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $value)
                                        <tr class="text-center">
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                <a href="{{ route('productDetail', $value->slug) }}"
                                                    title="redirect to detail">
                                                    <span class="d-inline-block text-truncate"
                                                        style="max-width: 150px;">{{ $value->name }}</span>
                                                </a>
                                            </td>
                                            <td>
                                                @foreach (json_decode($value->product_images->image) as $images)
                                                    <img class="mt-1 mb-1 ml-1" src="{{ asset("storage/$images") }}"
                                                        alt="" title="" class="rounded mr-3" height="68" />
                                                @endforeach
                                                <input class="form-check-input" type="checkbox" id="invalidCheck"
                                                    @if ($value->product_images->status == 'active') checked @endif>
                                            </td>
                                            <td>
                                                {{ $value->price }}
                                            </td>
                                            <td>
                                                @foreach ($attrs as $infoAttr)
                                                    @if (!empty($value->infoAttr[$infoAttr->id]))
                                                        <span>
                                                            {{ $infoAttr->name }}:
                                                            @foreach ($value->infoAttr["$infoAttr->id"] as $info)
                                                                {{ $info->name }}
                                                            @endforeach
                                                        </span>
                                                        <br>
                                                    @endif
                                                @endforeach
                                                <span>
                                                    Quantity: {{ $value->quantity }}
                                                </span>
                                                <br>
                                                <span>
                                                    View Purchases: {{ $value->count_view }}
                                                </span>

                                            </td>
                                            <td class="text-center">
                                                <span
                                                    @if ($value->status == 'active') class="badge badge-success" @else class="badge badge-danger" @endif>
                                                    {{ $value->status }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('admin.productions.edit', $value) }}"
                                                    class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                <form class="d-inline-block ml-2 formd-submit"
                                                    action="{{ route('admin.productions.destroy', $value) }}"
                                                    method="post">
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
    <script src="{{ asset('backend/js/backend/demo.productions.js') }}"></script>
@endpush
