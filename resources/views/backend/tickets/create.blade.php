@extends('backend.layout_admin')
@php
$title = 'Tickets';
@endphp
@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-2 text-gray-800">Tickets create</h1>
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="d-M-yyyy" data-date-autoclose="true" name="date_start">
                                </div>
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label class="form-label">Code</label>
                                        <input type="text" class="form-control" name="code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price">
                                </div>
                                <div class="form-group">
                                    <div class="" id="flex-input">
                                    </div>
                                </div>
                                <div class="mt-2 form-group">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio1">Toggle this custom random</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadio2" name="customRadio" checked class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio2">Toggle this custom select</label>
                                    </div>
                                </div>
                                <button type="submit" class="float-right mt-2 ml-1 btn btn-primary">Create</button>
                                <a href="{{ route('admin.discounts') }}" class="float-right mt-2 btn btn-info">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        var total_customer = 50;
        var customRadio1 = $('#customRadio1').val();
        var customRadio2 = $('#customRadio2').val();
        $('#customRadio1').on('change', function() {
            var select = '<select class="form-control select2" data-toggle="select2" name="customer_id[]">';
            for (var k = 0; k <= total_customer; k=k+5) {
                select += `<option value="${k ? k : 1}">${k ? k : 1}</option>`
            };
            select += '</select>';
            if($(this).val() === 'on'){
                $('#flex-input').html('');
                $('#flex-input').append('<label class="form-label">Total Random</label>' + select);
            }
        })
        $('#customRadio2').on('change', function() {
            var select = '<select class="form-control select2" data-toggle="select2" name="customer_id[]">';
            for (var k = 0; k <= total_customer; k=k+5) {
                select += `<option value="${k ? k : 1}">${k ? k : 1}</option>`
            };
            select += '</select>';
            if($(this).val() === 'on'){
                $('#flex-input').html('');
                $('#flex-input').append('<label class="form-label">Customers</label>' + select);
            }
        })
    });

</script>
@endpush
