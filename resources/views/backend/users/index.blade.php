@extends('backend.layout_admin')
@php
$title = 'Users';
@endphp
@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sc-2.0.6/sb-1.3.3/sl-1.4.0/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800">Users list</h1>
        @empty(!session('statusEdit'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('statusEdit') }}
            </div>
        @endempty
        <div class="row">
            <div class="col-12 mt-2">
                <div class="table-responsive my-3">
                    <table class="table table-bordered" id="table-data" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User name</th>
                                <th>Email</th>
                                <th>Info</th>
                                <th>Avatar</th>
                                <th>Address</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Edit</th>
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
            $(document).on('click', '.btn-delete', function() {
                let form = $(this).parents('form');
                $.ajax({
                    url: form.attr('action'),
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
            var buttonCommon = {
                exportOptions: {
                    columns: ':visible :not(.not-export)'
                }
            };
            let table = $('#table-data').DataTable({
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
                ajax: '{!! route('admin.users.api') !!}',
                lengthMenu: [5, 10, 20, 50],
                columnDefs: [{
                    className: "not-export",
                }],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'info',
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return "Name: " + row.fullname + " - " + row.gender + "<br>Phone: " + (
                                row.phone ? row
                                .phone : '') + "<br>Age: " + (row.birthday ? row.birthday : '');
                        }
                    },
                    {
                        data: 'avatar',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            if (!data) {
                                return `<img src="{{ asset('backend/images/users/avatar-0.jpg') }}" alt="" width="60">`;
                            };
                            return `<img src="{{ asset('storage/avatars') }}/${data} " alt="" width="70">`;
                        }
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'status',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            return row.status + "<br>Last_login: " + (row.last_login ? row
                                .last_login : '');
                        }
                    },
                    {
                        data: 'edit',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<a href="${data}" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>`
                        }
                    },
                    {
                        data: 'destroy',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `
                                <form class="action-icon" action="${data}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button style="background-color: initial;" type="button" class="btn-delete ml-1 border-0 action-icon" ><i class="mdi mdi-delete"></i></button>
                                </form>
                        `
                        }
                    },
                ]
            });

        });
    </script>
@endpush
