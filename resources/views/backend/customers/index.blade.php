@extends('backend.layout_admin')
@php
$title = ucfirst($titles);
@endphp
@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sc-2.0.6/sb-1.3.3/sl-1.4.0/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800">{{ ucfirst($titles) }} list</h1>
        @empty(!session('statusEdit'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('statusEdit') }}
            </div>
        @endempty
        <div class="row">
            <div class="col-12 mt-2">
                <div class="table-responsive my-3">
                    <table class="table table-bordered" id="tables-data" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Info</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $(document).on('click', '.btn-edit', function() {
                let formEdit = $(this).parents('form');
                if (confirm('Are you sure you want to continue?')) {
                    $.ajax({
                        url: formEdit.attr('action'),
                        type: 'POST',
                        data: formEdit.serialize(),
                        success: function(response, textStatus, xhr) {
                            table.draw();
                            alert((response));
                        },
                        error: function(response, textStatus, xhr) {
                            alert('Repair failed');
                        },
                    });
                }
            });
            $(document).on('click', '.btn-delete', function() {
                let form = $(this).parents('form');
                if (confirm('Are you sure you want to continue?')) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        data: form.serialize(),
                        success: function() {
                            table.draw();
                            alert("Deletion successfully!!");
                        },
                        error: function() {
                            alert('Deletion failed');
                        },
                    });
                }
            });
            var buttonCommon = {
                exportOptions: {
                    columns: ':visible :not(.not-export)'
                }
            };
            let table = $('#tables-data').DataTable({
                dom: 'B<"float-right"l>frtip',
                select: true,
                buttons: [
                    $.extend(true, {}, buttonCommon, {
                        extend: 'copyHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'excelHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'csvHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'pdfHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'print'
                    }),
                    'colvis'
                ],
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.customers.api') !!}',
                lengthMenu: [5, 10, 20, 50],
                columnDefs: [{
                    className: "not-export",
                }],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'info',
                        target: 3,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return "Phone: " + (row.phone ? row.phone : '') + "<br>Address: " + (row
                                .address ? row.address : '');
                        }
                    },
                    {
                        data: 'status',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            if (row.checkLevel == 'true') {
                                if (row.status === 'Active') {
                                    return `<span class="text-success">${row.status}</span>` +
                                        `<form class="action-icon" action="${row.edit}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button style="background-color: initial;" type="button" class="btn-edit border-0 action-icon" ><i class="mdi mdi-square-edit-outline"></i></button>
                                        </form>`;
                                } else {
                                    return `<span class="text-danger">${row.status}</span>` +
                                        `<form class="action-icon" action="${row.edit}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button style="background-color: initial;" type="button" class="btn-edit border-0 action-icon" ><i class="mdi mdi-square-edit-outline"></i></button>
                                        </form>`;
                                }
                            } else {
                                if (row.status === 'Active') {
                                    return `<span class="text-success">${row.status}</span>`;
                                } else {
                                    return `<span class="text-danger">${row.status}</span>`;
                                }
                            }
                        }
                    },
                    {
                        data: 'destroy',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            if (row.checkLevel == 'true') {
                                return `
                                    <form class="action-icon" action="${data}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button style="background-color: initial;" type="button" class="btn-delete ml-1 border-0 action-icon" ><i class="mdi mdi-delete"></i></button>
                                    </form>
                                    `
                            } else {
                                return 'You don’t have License'
                            }
                        }
                    },
                ]
            });

        });
    </script>
@endpush
