@extends('backend.layout_admin')
@php
    $title = 'Productions';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <h1 class="h3 mb-3 text-gray-800">Productions edit</h1>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.productions.update', $each) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        @if ($errors->has('name'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $each->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        @if ($errors->has('price'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('price') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="price"
                                            value="{{ $each->price }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Quantity</label>
                                        @if ($errors->has('quantity'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('quantity') }}</p>
                                        @endif
                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ $each->quantity }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description(* Can Be Empty)</label>
                                        @if ($errors->has('descriptions'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('descriptions') }}</p>
                                        @endif
                                        <textarea id="ckeditor-product" class="form-control" name="descriptions" rows="5"
                                            placeholder="Enter some brief about desciption..">{{ $each->descriptions }}</textarea>
                                    </div>

                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-control select2" data-toggle="select2" name="category_id"
                                            id="">
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}"
                                                    @if ($value->id == $each->category_id) selected @endif>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        @foreach ($each->image as $value)
                                            <label for="" class="form-label">Image New</label>
                                            <div class="float-right">
                                                <input type="checkbox" id="switch4"
                                                    @if ($value->status == 1) checked @endif data-switch="success"
                                                    name="status_image" />
                                                <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                            @if ($errors->has('fileData'))
                                                <p class="text-capitalize text-danger">{{ $errors->first('fileData') }}</p>
                                            @endif
                                            <input multiple class="form-control" type="file" name="fileDataNew[]" />
                                            <div class="mb-2 mt-3">
                                                <label for="" class="form-label">Or Image Old</label>
                                                @foreach (json_decode($value->image) as $images)
                                                    <img class="mt-1 mb-1 ml-1" src="{{ asset("storage/$images") }}"
                                                        alt="contact-img" title="contact-img" class="rounded mr-3"
                                                        height="68" />
                                                @endforeach
                                                <input multiple type="hidden" name="fileDataOld"
                                                    value="{{ $value->image }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Choose Size</label>
                                        <select class="form-control select2" id="selectSize" data-toggle="select2">
                                            @foreach ($attrSize as $value)
                                                <option value="{{ $value->replace_id }}"
                                                    @foreach ($each->attr as $keySize => $infoSize)
                                                        @if ($value->id == $keySize)
                                                        selected
                                                         @endif @endforeach>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="mt-1">
                                            <select class="form-control select2" id="selectSizeValue" data-toggle="select2"
                                                name="attrValue1[]" multiple>
                                                @foreach ($attrSize as $valueSize)
                                                    @foreach ($each->attr as $keySize => $infoSize)
                                                        @if ($valueSize->id == $keySize)
                                                            @foreach ($valueSize->replace_id as $eachSize)
                                                                <option value="{{ $eachSize->id }}"
                                                                    @foreach ($infoSize as $checkId) @if ($eachSize->id == $checkId->id) selected @endif @endforeach>
                                                                    {{ $eachSize->name }} </option>
                                                            @endforeach>
                                                        @endif
                                                    @endforeach>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Choose Color</label>
                                        <select class="form-control select2" data-toggle="select2" name="attrValue">
                                            @foreach ($attrColor as $valueColor)
                                                <option value="{{ $valueColor->id }}"
                                                    @foreach ($each->attr as $keyColor => $infoColor)
                                                        @if ($valueColor->attribute_id == $keyColor)
                                                        @foreach ($infoColor as $eachColor)
                                                            @if ($valueColor->id == $eachColor->id) selected @endif @endforeach
                                                    @endif
                                            @endforeach>
                                            {{ $valueColor->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="float-right">
                                            <input type="checkbox" id="switch3"
                                                @if ($each->status == 1) checked @endif data-switch="success"
                                                name="status" />
                                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="float-right btn btn-primary ml-2">Update</button>
                            <a href="{{ route('admin.productions') }}" class="float-right btn btn-info">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('ckeditor-product')
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var data = $('#selectSize option:selected').val();
            // // if($("#selectSizeValue").val())
            // console.log($("#selectSizeValue").val().length > 0);
            // data = JSON.parse(data);
            // // for (let each of data) {
            // //     $('#selectSizeValue').append(`<option value="${each.id}" selected>${each.name}</option>`);
            // // }
            $("#selectSize").change(function() {
                $('#selectSizeValue').html('');
                for (let each of JSON.parse($(this).val())) {
                    $('#selectSizeValue').append(`<option value="${each.id}">${each.name}</option>`);
                }
            });
        });
    </script>
@endpush
