@extends('backend.layout_admin')
@php
    $title = 'Users';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <h1 class="h3 mb-2 text-gray-800">User edit</h1>
                <form action="{{ route('admin.users.update', $each) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        {{-- @if ($errors->has('name'))
                            <p class="text-capitalize p-2 text-danger">{{ $errors->first('name') }}</p>
                        @endif --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group ml-2">
                            {{-- <div class="mb-3">
                                <label class="form-label">Full name</label>
                                <input type="text" class="form-control" name="fullname" value="{{ $each->fullname }}">
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $each->address }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ $each->phone }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Birthday</label>
                                <input type="date" class="form-control" name="birthday" value="{{ $each->birthday }}">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">New Avatar</label>
                                <input class="form-control" type="file" name="photo_new">
                            </div>
                            <label for="" class="form-label">Or Avatar Old</label>
                            <div class="mb-3">
                                @if ($each->avatar != '')
                                    <img height="150" src="{{ asset('storage/avatars/' . $each->avatar) }}">
                                @else
                                    <img height="150" src="{{ asset('backend/images/users/avatar-0.jpg') }}">
                                @endif
                                <input type="hidden" name="photo_old" value="{{ $each->avatar }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="male" @if ($each->gender == 'male') selected @endif>
                                        Male
                                    </option>
                                    <option value="female" @if ($each->gender == 'female') selected @endif>
                                        Female
                                    </option>
                                </select>
                            </div>
                            @if (\Auth()->user()->level == \App\Models\User::USER_LEVEL['ADMIN'])
                                <div class="mb-3">
                                    <label class="form-label">Roles</label>
                                    <select class="form-control" name="level">
                                        @foreach ($roles as $key => $value)
                                            <option value="{{ $value }}"
                                                @if ($each->level == $value) selected @endif>
                                                {{ $key }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="level" value="{{ $each->level }}">
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="float-right">
                                    <input type="checkbox" id="switch3" @if ($each->status == \App\Models\User::USER_STATUS['ACTIVE']) checked @endif
                                        data-switch="success" name="status" />
                                    <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
