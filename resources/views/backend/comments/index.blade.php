@extends('backend.layout_admin')
@php
$title = 'Contacts';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Contacts list</h1>
        @empty(!session('EditBlogStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('EditBlogStatus') }}
            </div>
        @endempty
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="comments-datatable">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th class="all" style="width: 20px;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Content</th>
                                        <th>Comment In Production</th>
                                        <th>Comment In Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $value)
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
                                                {{ $value->name }}
                                            </td>
                                            <td>
                                                {{ $value->content }}
                                            </td>

                                            <td>
                                                @foreach ($value->productions as $each)
                                                    {{ $each->name }}
                                                @endforeach
                                            </td>

                                            <td>{{ $value->parent_id }}</td>

                                            <td class="table-action">
                                                {{-- @if ($value->status == ACTIVE) --}}
                                                    <form action="{{ route('admin.comments', $value->id) }}"
                                                        class="action-form" method="post">
                                                        @csrf
                                                        <input type="hidden" value="3" name="action">
                                                        <button type="submit" class="action-icon"><i
                                                                class="mdi mdi-square-edit-outline">2</i></button>
                                                    </form>
                                                {{-- @endif --}}
                                                {{-- @if ($value->status == NOT_ACTIVE ) --}}
                                                    <form action="{{ route('admin.comments', $value->id) }}"
                                                        class="action2-form" method="post">
                                                        @csrf
                                                        <input type="hidden" value="1" name="action">
                                                        <button type="submit" class="action-icon"><i
                                                                class="mdi mdi-square-edit-outline">1</i></button>
                                                    </form>
                                                {{-- @endif --}}
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
    <script src="{{ asset('backend/js/backend/demo.comment.js') }}"></script>
@endpush
