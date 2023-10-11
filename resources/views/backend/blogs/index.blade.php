@extends('backend.layout_admin')
@php
$title = 'Blogs';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Blogs list</h1>
        @empty(!session('EditBlogStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('EditBlogStatus') }}
            </div>
        @endempty
        @empty(!session('BlogErrors'))
            <div class="alert alert-danger mt-2" role="alert">
                {{ session('BlogErrors') }}
            </div>
        @endempty
        @empty(!session('deleteSuccess'))
            <div class="alert alert-danger mt-2" role="alert">
                {{ session('deleteSuccess') }}
            </div>
        @endempty
        @empty(!session('addBlogsSuccess'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('addBlogsSuccess') }}
            </div>
        @endempty
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle mr-2"></i> Add Blogs</a>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right mr-3">
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Count View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $value)
                                        <tr class="text-center">
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                <span class="d-inline-block text-truncate"
                                                    style="max-width: 150px;">{{ $value->title }}</span>
                                            </td>

                                            <td class="text-center">
                                                <img src="{{ asset("storage/$value->image") }}" alt="contact-img"
                                                    title="contact-img" class="rounded mr-3" height="68" />
                                            </td>

                                            <td class="text-center">
                                                @if ($value->status == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Not active</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $value->count_view }}
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('admin.blogs.edit', $value->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                <form class="d-inline-block ml-2 formd-submit"
                                                    action="{{ route('admin.blogs.destroy', $value) }}" method="post">
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
                            <ul class="pagination pagination-rounded mb-0 justify-content-end mr-5">
                                {{ $blogs->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
