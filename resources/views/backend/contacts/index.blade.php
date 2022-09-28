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
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Action</th>
                                        <th>Seen Mail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $value)
                                        <tr class="text-center">
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                <span class="d-inline-block text-truncate"
                                                    style="max-width: 150px;">{{ $value->name }}</span>
                                            </td>
                                            <td>
                                                <span class="d-inline-block text-truncate"
                                                    style="max-width: 150px;">{{ $value->email }}</span>
                                            </td>

                                            <td class="text-center">
                                                {{ $value->message }}
                                            </td>

                                            <td>
                                                @switch($value->status)
                                                    @case(ACTIVE)
                                                        <div>
                                                            <span class="text-success font-weight-bold text-center"
                                                                style="max-width: 100px;"> approved</span>
                                                        </div>
                                                    @break

                                                    @case(CANCEL)
                                                        <div>
                                                            <span class="text-danger font-weight-bold text-center"
                                                                style="max-width: 100px;"> has been cancelled</span>
                                                        </div>
                                                    @break

                                                    @default
                                                        <div>
                                                            <span class="text-warning font-weight-bold text-center"
                                                                style="max-width: 100px;">Waiting for approval</span>
                                                        </div>
                                                @endswitch
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.contacts.seenMail', $value->id) }}"
                                                    class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <ul class="pagination pagination-rounded mb-0 justify-content-end mr-5">
                                {{ $contacts->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
