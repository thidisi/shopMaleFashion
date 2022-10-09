@extends('backend.layout_admin')
@php
$title = 'Comments';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Comments list</h1>
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
                                        <th>Review</th>
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
                                                @if (count($value->productions) > 0)
                                                    {{ $value->productions['0']->name }}
                                                @else
                                                    {{ $value->name_comment }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (count($value->productions) > 0)
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        @for ($i = 0; $i < $value->productions['0']->pivot->review; $i++)
                                                            <span class=" text-warning mdi mdi-star"></span>
                                                        @endfor
                                                    </div>
                                                @else
                                                    {{ $value->parent_id }}
                                                @endif
                                            </td>

                                            <td class="table-action">
                                                @if (count($value->productions) > 0)
                                                    @if ($value->productions['0']->pivot->review == null)
                                                        @switch($value->status)
                                                            @case(ACTIVE)
                                                                <form action="{{ route('admin.comments.action', $value->id) }}"
                                                                    class="action-form d-flex align-items-center justify-content-center formd-submit"
                                                                    method="post">
                                                                    @csrf
                                                                    <a href="{{ route('productDetail', $value->productions['0']->slug) }}"
                                                                        class="action-icon mr-1">
                                                                        <i class="mdi mdi-eye"></i>
                                                                    </a>
                                                                    <small
                                                                        class="mdi mdi-checkbox-blank-circle text-success align-middle mr-1"></small>
                                                                    <input type="hidden" value="3" name="action">
                                                                    <button type="submit" class="action-icon"
                                                                        style="border: none;background: none;"><i
                                                                            class="mdi mdi mdi-delete"></i></button>
                                                                </form>
                                                            @break

                                                            @case(CANCEL)
                                                                <form action="{{ route('admin.comments.action', $value->id) }}"
                                                                    class="action-form d-flex align-items-center justify-content-center"
                                                                    method="post">
                                                                    @csrf
                                                                    <a href="{{ route('productDetail', $value->productions['0']->slug) }}"
                                                                        class="action-icon mr-1">
                                                                        <i class="mdi mdi-eye"></i>
                                                                    </a>
                                                                    <small
                                                                        class="mdi mdi-checkbox-blank-circle text-danger align-middle mr-1"></small>
                                                                    <input type="hidden" value="1" name="action">
                                                                    <button type="submit" class="action-icon"
                                                                        style="border: none;background: none;"><i
                                                                            class="mdi mdi-square-edit-outline"></i></button>
                                                                </form>
                                                            @break

                                                            @default
                                                                <form action="{{ route('admin.comments.action', $value->id) }}"
                                                                    class="action-form d-flex align-items-center justify-content-center"
                                                                    method="post">
                                                                    @csrf
                                                                    <a href="{{ route('productDetail', $value->productions['0']->slug) }}"
                                                                        class="action-icon mr-1">
                                                                        <i class="mdi mdi-eye"></i>
                                                                    </a>
                                                                    <small
                                                                        class="mdi mdi-checkbox-blank-circle text-info align-middle mr-1"></small>
                                                                    <input type="hidden" value="1" name="action">
                                                                    <button type="submit" class="action-icon"
                                                                        style="border: none;background: none;"><i
                                                                            class="mdi mdi-square-edit-outline"></i></button>
                                                                </form>
                                                        @endswitch
                                                    @else
                                                        <a href="{{ route('productDetail', $value->productions['0']->slug) }}"
                                                            class="action-icon mr-1">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                    @endif
                                                @else
                                                    @switch($value->status)
                                                        @case(ACTIVE)
                                                            <form action="{{ route('admin.comments.action', $value->id) }}"
                                                                class="action-form d-flex align-items-center justify-content-center formd-submit"
                                                                method="post">
                                                                @csrf
                                                                <a href="{{ route('productDetail', $value->parent_slug) }}"
                                                                    class="action-icon mr-1">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </a>
                                                                <small
                                                                    class="mdi mdi-checkbox-blank-circle text-success align-middle mr-1"></small>
                                                                <input type="hidden" value="3" name="action">
                                                                <button type="submit" class="action-icon"
                                                                    style="border: none;background: none;"><i
                                                                        class="mdi mdi mdi-delete"></i></button>
                                                            </form>
                                                        @break

                                                        @case(CANCEL)
                                                            <form action="{{ route('admin.comments.action', $value->id) }}"
                                                                class="action-form d-flex align-items-center justify-content-center"
                                                                method="post">
                                                                @csrf
                                                                <a href="{{ route('productDetail', $value->parent_slug) }}"
                                                                    class="action-icon mr-1">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </a>
                                                                <small
                                                                    class="mdi mdi-checkbox-blank-circle text-danger align-middle mr-1"></small>
                                                                <input type="hidden" value="1" name="action">
                                                                <button type="submit" class="action-icon"
                                                                    style="border: none;background: none;"><i
                                                                        class="mdi mdi-square-edit-outline"></i></button>
                                                            </form>
                                                        @break

                                                        @default
                                                            <form action="{{ route('admin.comments.action', $value->id) }}"
                                                                class="action-form d-flex align-items-center justify-content-center"
                                                                method="post">
                                                                @csrf
                                                                <a href="{{ route('productDetail', $value->parent_slug) }}"
                                                                    class="action-icon mr-1">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </a>
                                                                <small
                                                                    class="mdi mdi-checkbox-blank-circle text-info align-middle mr-1"></small>
                                                                <input type="hidden" value="1" name="action">
                                                                <button type="submit" class="action-icon"
                                                                    style="border: none;background: none;"><i
                                                                        class="mdi mdi-square-edit-outline"></i></button>
                                                            </form>
                                                    @endswitch
                                                @endif
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
