@extends('backend.layout_admin')
@php
$title = 'Slide';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Slide list</h1>
        @empty(!session('EditSlideStatus'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('EditSlideStatus') }}
            </div>
        @endempty
        @empty(!session('SlideErrors'))
            <div class="alert alert-danger mt-2" role="alert">
                {{ session('SlideErrors') }}
            </div>
        @endempty
        @empty(!session('deleteSuccess'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('deleteSuccess') }}
            </div>
        @endempty
        @empty(!session('addSlideSuccess'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('addSlideSuccess') }}
            </div>
        @endempty
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{ route('admin.slides.create') }}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Add
                                Slide</a>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Title</th>
                                        <th style="width: 25%;">Image</th>
                                        <th>Slug</th>
                                        <th>Menu</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($slides as $value)
                                        <tr class="text-center">
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                {{ $value->title }}
                                            </td>
                                            <td>
                                                @foreach (json_decode($value->image) as $images)
                                                    <img class="mt-1 mb-1 ml-1" src="{{ asset("storage/$images") }}"
                                                        alt="contact-img" title="contact-img" class="rounded mr-3"
                                                        height="68" />
                                                @endforeach
                                            </td>
                                            <td>
                                                <span class="d-inline-block text-truncate"
                                                    style="max-width: 150px;">{{ $value->slug }}</span>
                                            </td>
                                            <td>
                                                <span class="d-inline-block text-truncate"
                                                    style="max-width: 150px;">{{ $value->major_categories->name }}</span>
                                            </td>
                                            <td>
                                                <span class="text-capitalize">{{ $value->sort_order }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    @if ($value->status == 'active') class="badge badge-success" @else class="badge badge-danger" @endif>
                                                    {{ $value->status }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('admin.slides.edit', $value->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                <form class="d-inline-block ml-2 formd-submit"
                                                    action="{{ route('admin.slides.destroy', $value) }}" method="post">
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
                                {{ $slides->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
