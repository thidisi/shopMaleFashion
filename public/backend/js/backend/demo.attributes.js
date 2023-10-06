$(document).ready(function () {
    "use strict";
    var table = $("#attributes-datatable").DataTable({
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
            info: "Showing attributes _START_ to _END_ of _TOTAL_",
            lengthMenu:
                'Display <select class=\'custom-select custom-select-sm ml-1 mr-1\'><option value="3">3</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> attributes',
        },
        pageLength: 3,
        columns: [
            { orderable: !0 },
            { orderable: !0 },
            { orderable: !1 },
            { orderable: !0 },
            { orderable: !0 },
            { orderable: !1 },
        ],
        select: { style: "multi" },
        order: [[1, "desc"]],
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });
});
