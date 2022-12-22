@extends('backend.layout_admin')
@php
    $title = 'Tickets';
@endphp
@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sc-2.0.6/sb-1.3.3/sl-1.4.0/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        td {
            text-align: center;
        }
    </style>
@endpush
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-2 text-gray-800">Tickets
                            <button id="btn-formCreate" class="float-right btn btn-primary d-none">Create</button>
                        </h1>
                        <form action="{{ route('admin.tickets.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        @if ($errors->has('date_end'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('date_end') }}</p>
                                        @endif
                                        <input type="text" class="form-control" data-provide="datepicker"
                                            data-date-format="d-M-yyyy" data-date-autoclose="true" name="date_end">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Price</label>
                                        @if ($errors->has('price'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('price') }}</p>
                                        @endif
                                        <input type="number" class="form-control" name="price">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label">Code</label>
                                        @if ($errors->has('code'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('code') }}</p>
                                        @endif
                                        <input type="text" class="form-control" name="code">
                                    </div>
                                    <div class="form-group">
                                        <label id="flex-label" class="form-label d-none"></label>
                                        @if ($errors->has('data'))
                                            <p class="text-capitalize text-danger">{{ $errors->first('data') }}</p>
                                        @endif
                                        <select id="select2Data" class="form-control select2" data-toggle="select2"
                                            data-placeholder="Choose ..." name="data[]" multiple>
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
                        <div class="table-responsive my-3">
                            <table class="table table-bordered" id="table-data" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Discount code</th>
                                        {{-- <th>Quantity</th>
                                        <th>End date</th>
                                        <th>Discount price</th> --}}
                                        <th class="text-center">Discount price</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sc-2.0.6/sb-1.3.3/sl-1.4.0/datatables.min.js">
    </script>
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
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '.btn-delete', function() {
                let form = $(this).parents('form');
                $.ajax({
                    url: form.data('route'),
                    type: 'POST',
                    dataType: 'json',
                    data: form.serialize(),
                    success: function() {
                        table.draw();
                        alert("Xóa thành công");
                    },
                    error: function() {
                        alert('Xóa thất bại');
                    },
                });
            });
            let table = $('#table-data').DataTable({
                dom: 'B<"float-right"l>frtip',
                lengthChange: false,
                buttons: [
                    $.extend(true, {}, {
                        extend: 'excelHtml5'
                    }),
                ],
                processing: true,
                serverSide: true,
                lengthMenu: [5, 10, 20, 50],
                ajax: '{!! route('api.tickets.dataApi') !!}',
                columnDefs: [{
                    "className": "not-export",
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'discount_price',
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return "Discount price: " + row.price + "<br>Quantity: " + row
                                .quantity + "<br>End date: " + (row.date_end ? row.date_end : '-');
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<button style="background-color: initial;" data-id="${row.id}" class="action-icon border-0">
                                <i class="mdi mdi-square-edit-outline"></i>
                                </button>
                                <form class="action-icon" data-route="${data}" method="post">
                                @method('DELETE')
                                <button style="background-color: initial;" type="button" class="btn-delete ml-1 border-0 action-icon" ><i class="mdi mdi-delete"></i></button>
                            </form>`
                        }
                    },
                ],
                language: {
                    "sProcessing": "loading....",
                    "oPaginate": {
                        "sFirst": "<?php echo __('Đầu trang'); ?>",
                        "sLast": "<?php echo __('Cuối trang'); ?>",
                        "sNext": "<?php echo __('»'); ?>",
                        "sPrevious": "<?php echo __('«'); ?>"
                    },
                    searchPlaceholder: "Search.."
                }
            });
        });
    </script>
@endpush
