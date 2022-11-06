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
                        <form action="{{ route('admin.tickets.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" class="form-control" data-provide="datepicker"
                                            data-date-format="d-M-yyyy" data-date-autoclose="true" name="date_start">
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
                                        <label id="flex-label" class="form-label d-none"></label>
                                        <select id="select2Data" class="form-control select2" data-toggle="select2"
                                            name="data[]" multiple>
                                        </select>
                                        <select id="selectData" class="form-control" name="data">
                                        </select>
                                    </div>
                                    <div class="mt-2 form-group">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadio1" name="customRadio"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio1">Toggle this customer
                                                random</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadio2" name="customRadio" checked
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio2">Toggle this customer
                                                select</label>
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
            $('.select2-container').addClass('d-none');
            getDataCustomRadio('customRadio2');
            $('#selectData').addClass('d-none');
            $('#customRadio1').on('change', function() {
                getDataCustomRadio('customRadio1');
            })
            $('#customRadio2').on('change', function() {
                getDataCustomRadio('customRadio2');
            })
        });
        function getDataCustomRadio(param) {
            $('.select2-container').addClass('d-none');
            $('#selectData').addClass('d-none');
            $('#flex-label').addClass('d-none');
            $('#flex-label').text('');
            $('#selectData').find('option').remove();
            $('#select2Data').find('option').remove();
            let options = '';
            $.ajax({
                url: '{{ route('api.tickets.get_data') }}',
                dataType: 'json',
                success: function(response) {
                    if (param == 'customRadio1') {
                        for (var k = 0; k <= response.data.total_customer; k = k + 5) {
                            options += `<option value="${k ? k : 1}">${k ? k : 1}</option>`
                        };
                        if ($('#customRadio1').val() === 'on') {
                            $('.select2-container').addClass('d-none');
                            $('#selectData').removeClass('d-none');
                            $('#flex-label').removeClass('d-none');
                            $('#flex-label').text('Total Random');
                            $('#selectData').append(options);
                        }
                    } else {
                        if ($('#customRadio2').val() === 'on') {
                            for (let each of response.data.customers) {
                                options += `<option value="${each.id}">${each.name}</option>`
                            }
                            $('.select2-container').removeClass('d-none');
                            $('#flex-label').removeClass('d-none');
                            $('#flex-label').text('Customers');
                            $('#select2Data').append(options);
                        }
                    }
                },
                error: function(response) {
                    console.log(response);
                },
            })
        }
    </script>
@endpush
