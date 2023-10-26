$(document).ready(function () {
    "use strict";
    var table = $("#orders_latest-datatable").DataTable({
        "dom": "rt",
        pageLength: 3,
        columns: [
            { orderable: !1 },
            { orderable: !1 },
            { orderable: !1 },
            { orderable: !1 },
            { orderable: !1 },
            { orderable: !1 },
        ],
    });
});
