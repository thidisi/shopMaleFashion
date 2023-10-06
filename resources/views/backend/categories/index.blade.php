@extends('backend.layout_admin')
@php
    $title = 'Categories';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Categories list</h1>
        @empty(!session('EditCategoryStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('EditCategoryStatus') }}
            </div>
        @endempty
        @empty(!session('CategoryErrors'))
            <div class="alert alert-danger mt-2" role="alert">
                {{ session('CategoryErrors') }}
            </div>
        @endempty
        @empty(!session('addCategoryStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('addCategoryStatus') }}
            </div>
        @endempty
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle mr-2"></i> Add Categories</a>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-right mr-3">
                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                </div>
                            </div><!-- end col-->
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="categories-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th class="all">Name</th>
                                        <th>Slug</th>
                                        <th>Major Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $value)
                                        <tr>
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                @if ($value->avatar != null)
                                                    <img src="{{ asset("storage/$value->avatar") }}" alt="contact-img"
                                                        title="contact-img" class="rounded mr-3" height="48" />
                                                @else
                                                    <img src="{{ asset('backend/images/products/product-1.jpg') }}"
                                                        alt="contact-img" title="contact-img" class="rounded mr-3"
                                                        height="48" />
                                                @endif
                                                <p class="mt-2 mr-2 d-inline-block align-middle font-16">
                                                    <span class="text-body">{{ $value->name }}</span>
                                                </p>
                                            </td>
                                            <td>
                                                <span class="d-inline-block text-truncate"
                                                    style="max-width: 150px;">{{ $value->slug }}</span>
                                            </td>
                                            <td>
                                                {{ $value->name_majorCate }}
                                            </td>

                                            <td class="text-center">
                                                <span
                                                    @if ($value->status == 'Active') class="badge badge-success" @else class="badge badge-danger" @endif>
                                                    {{ $value->status }}
                                                </span>
                                            </td>

                                            <td class="table-action">
                                                <a href="{{ route('admin.categories.edit', $value->id) }}"
                                                    class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                {{-- <form id="delete-forms" class="d-inline-block"
                                                    data-route="{{ route('admin.categories.destroy', $value->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="action-icon"
                                                        style="border: none;background: none;"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </form> --}}
                                                <form class="d-inline-block delete-forms"
                                                    data-route="{{ route('admin.categories.destroy', $value->id) }}">
                                                    <button class="action-icon" style="border: none;background: none;"><i
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
    <script src="{{ asset('backend/js/backend/demo.categories.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete-forms').on('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete?')) {
                    $.ajax({
                        type: 'post',
                        url: $(this).data('route'),
                        data: {
                            '_method': 'delete'
                        },
                        success: function(response, textStatus, xhr) {
                            alert(response);
                            window.location = '/admin/categories'
                        }
                    });
                }
            })
        });
    </script>
@endpush
