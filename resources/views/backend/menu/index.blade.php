@extends('backend.layout_admin')
@php
$title = 'Menu';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Menu list</h1>
        @empty(!session('EditMajorCategoryStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('EditMajorCategoryStatus') }}
            </div>
        @endempty
        @empty(!session('addMajorCategoryStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('addMajorCategoryStatus') }}
            </div>
        @endempty
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('admin.major-categories.create') }}" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle mr-2"></i> Add Categories</a>
                            </div>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th style="width: 36%;">Name</th>
                                        <th>Status</th>
                                        <th>Created_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($majorCategories as $value)
                                        <tr class="text-center">
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                {{ $value->name }}
                                            </td>

                                            
                                            <td>
                                                <span class="text-capitalize">{{ $value->status }}</span>
                                            </td>

                                            <td>
                                                {{ $value->created_at }}
                                            </td>

                                            <td class="table-action">
                                                <a href="{{ route('admin.major-categories.edit', $value->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                {{-- <form id="delete-form" class="d-inline-block"
                                                    data-route="{{ route('admin.categories.destroy', $value) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="action-icon"
                                                        style="border: none;background: none;"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <ul class="pagination pagination-rounded mb-0 justify-content-end mr-5">{{ $majorCategories->links() }}</ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
