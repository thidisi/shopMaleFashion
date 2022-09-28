@extends('backend.layout_admin')
@php
$title = 'Attributes';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Attributes list</h1>
        @empty(!session('EditAttrStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('EditAttrStatus') }}
            </div>
        @endempty
        @empty(!session('addAttrStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('addAttrStatus') }}
            </div>
        @endempty
        @empty(!session('deleteSuccess'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('deleteSuccess') }}
            </div>
        @endempty
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('admin.attributeValues.create') }}" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle mr-2"></i> Add AttributeValues</a>
                            </div>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="attributeValues-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="all" style="width: 20px;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Attribute</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attrValue as $each)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                    <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $each->id }}
                                            </td>
                                            <td>
                                                {{ $each->name }}
                                            </td>
                                            <td>{{ $each->slug }}</td>
                                            <td>
                                                <span class="d-inline-block text-truncate"
                                                    style="max-width: 150px;">{{ $each->descriptions }}</span>
                                            </td>

                                            <td>{{ $each->attr_name }}</td>

                                            <td>
                                                <span
                                                    @if ($each->status == 'Active') class="badge badge-success" @else class="badge badge-danger" @endif>
                                                    {{ $each->status }}
                                                </span>
                                            </td>

                                            <td class="table-action">
                                                <a href="{{ route('admin.attributeValues.edit', $each) }}"
                                                    class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                <form class="d-inline-block ml-2"
                                                    action="{{ route('admin.attributeValues.destroy', $each) }}"
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
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('admin.attributes.create') }}" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle mr-2"></i> Add Attributes</a>
                            </div>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="attributes-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="all" style="width: 20px;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th class="all">Name</th>
                                        <th>Description</th>
                                        <th>Replace</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attr as $value)
                                        <tr>
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
                                                {{ $value->name }}
                                            </td>
                                            <td>
                                                <span class="d-inline-block text-truncate"
                                                    style="max-width: 150px;">{{ $value->descriptions }}</span>
                                            </td>
                                            <td>
                                                @foreach ($attr as $each)
                                                    @if ($each->id == $value->replace_id)
                                                        {{ $each->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <span
                                                    @if ($value->status == 'Active') class="badge badge-success" @else class="badge badge-danger" @endif>
                                                    {{ $value->status }}
                                                </span>
                                            </td>

                                            <td class="table-action">
                                                <a href="{{ route('admin.attributes.edit', $value) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                {{-- <form class="d-inline-block ml-2"
                                                    action="{{ route('admin.attributes.destroy', $value) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-icon"
                                                        style="border: none;background: none;"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </form> --}}
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
    <script src="{{ asset('backend/js/backend/demo.attributes.js') }}"></script>
    <script src="{{ asset('backend/js/backend/demo.attribute-values.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#delete-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).data('route'),
                    data: {
                        '_method': 'delete'
                    },
                    success: function(response, textStatus, xhr) {
                        alert(response);
                        window.location = '/admin/categories'
                    }
                });
            })
        });
    </script>
@endpush
