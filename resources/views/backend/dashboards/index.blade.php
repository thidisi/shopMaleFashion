@extends('backend.layout_admin')
@php
    $title = 'Dashboards';
@endphp
@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title" style="line-height: 46px;">Dashboad</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-xl-4">
                                <div class="card shadow-none m-0 border-left">
                                    <div class="card-body text-center">
                                        <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i>
                                        <h3><span id="total_sales">93%</span> <i class="mdi mdi-arrow-up text-success"></i>
                                        </h3>
                                        <p class="text-muted font-15 mb-0">Total sales</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="card shadow-none m-0">
                                    <div class="card-body text-center">
                                        <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                        <h3><span id="total_orders">29</span></h3>
                                        <p class="text-muted font-15 mb-0">Total Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="card shadow-none m-0 border-left">
                                    <div class="card-body text-center">
                                        <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                        <h3><span id="total_members">31</span></h3>
                                        <p class="text-muted font-15 mb-0">Total Members</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Sales statistics</h4>
                        <div id="datalabels-column" class="apex-charts" data-colors="#3688fc"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Latest orders</h4>
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="orders_latest-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th class="all">Info Receiver</th>
                                        <th>Total Money</th>
                                        <th>Action</th>
                                        <th>Created_at</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($orders as $value)
                                        <tr>
                                            <td>
                                                {{ $value->id }}
                                            </td>
                                            <td>
                                                Name: {{ $value->name_receiver }}
                                                <br>
                                                Phone: {{ $value->phone_receiver }}
                                                <br>
                                                Address: {{ $value->address_receiver }}
                                                <br>
                                                Note: {{ $value->note }}
                                            </td>
                                            <td>
                                                {{ $value->total_money }}
                                            </td>
                                            <td>
                                                @switch($value->action)
                                                    @case('active')
                                                        <div>
                                                            <span class="text-success font-weight-bold text-center"
                                                                style="max-width: 100px;">Order approved</span>
                                                        </div>
                                                    @break

                                                    @case('inactive')
                                                        <div>
                                                            <span class="text-danger font-weight-bold text-center"
                                                                style="max-width: 100px;">Order has been cancelled</span>
                                                        </div>
                                                    @break

                                                    @default
                                                        <div>
                                                            <span class="text-warning font-weight-bold text-center"
                                                                style="max-width: 100px;">Waiting for approval</span>
                                                        </div>
                                                @endswitch
                                            </td>
                                            <td>
                                                {{ $value->created_at }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $value->id) }}" class="action-icon">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach --}}
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
    <script src="{{ asset('backend/js/backend/demo.orders_latest.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.api.dashboard') }}",
                success: function(response) {
                    if(response.orders_latest.length > 0) {
                        $("#orders_latest-datatable").find("tbody").html("");
                    }
                    console.log(response.orders_latest.length);
                    $("#total_sales").text(response.sales_total);
                    $("#total_orders").text(response.orders_total);
                    $("#total_members").text(response.customers_total);
                    colors = ["#727cf5"];
                    (dataColors = $("#datalabels-column").data("colors")) &&
                    (colors = dataColors.split(","));
                    options = {
                        chart: {
                            height: 380,
                            type: "bar",
                            toolbar: {
                                show: !1
                            }
                        },
                        plotOptions: {
                            bar: {
                                dataLabels: {
                                    position: "top"
                                }
                            }
                        },
                        dataLabels: {
                            enabled: !0,
                            formatter: function(o) {
                                sum = o.toLocaleString('vi', {
                                    style: 'currency',
                                    currency: 'VND'
                                });
                                return sum;
                            },
                            offsetY: 10,
                            style: {
                                fontSize: "12px",
                                colors: ["#304758"]
                            },
                        },
                        colors: colors,
                        series: [{
                            name: "Inflation",
                            data: response.data_sale_months,
                        }, ],
                        xaxis: {
                            categories: [
                                "Jan",
                                "Feb",
                                "Mar",
                                "Apr",
                                "May",
                                "Jun",
                                "Jul",
                                "Aug",
                                "Sep",
                                "Oct",
                                "Nov",
                                "Dec",
                            ],
                            position: "top",
                            labels: {
                                offsetY: 7
                            },
                            axisBorder: {
                                show: !1
                            },
                            axisTicks: {
                                show: !1
                            },
                            crosshairs: {
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        colorFrom: "#D8E3F0",
                                        colorTo: "#BED1E6",
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 0.5,
                                    },
                                },
                            },
                            tooltip: {
                                enabled: !0,
                                offsetY: -35
                            },
                        },
                        fill: {
                            gradient: {
                                enabled: !1,
                                shade: "light",
                                type: "horizontal",
                                shadeIntensity: 0.25,
                                gradientToColors: void 0,
                                inverseColors: !0,
                                opacityFrom: 1,
                                opacityTo: 1,
                                stops: [50, 0, 100, 100],
                            },
                        },
                        yaxis: {
                            axisBorder: {
                                show: !1
                            },
                            axisTicks: {
                                show: !1
                            },
                            labels: {
                                show: !1,
                                formatter: function(o) {
                                    sum = o.toLocaleString('vi', {
                                        style: 'currency',
                                        currency: 'VND'
                                    });
                                    return sum;
                                },
                            },
                        },
                        title: {
                            // text: "Monthly",
                            floating: !0,
                            offsetY: 350,
                            align: "center",
                            style: {
                                color: "#444"
                            },
                        },
                        grid: {
                            row: {
                                colors: ["transparent", "transparent"],
                                opacity: 0.2
                            },
                            borderColor: "#f1f3fa",
                        },
                    };
                    (chart = new ApexCharts(
                        document.querySelector("#datalabels-column"),
                        options
                    )).render();
                    response.orders_latest.forEach((element, index) => {
                        switch (element.action) {
                            case 'active':
                                action =
                                    `<div>
                                <span class="text-success font-weight-bold text-center" style="max-width: 100px;">Order approved</span></div>`;
                                break;
                            case 'inactive':
                                action =
                                    `<div>
                                <span class="text-danger font-weight-bold text-center" style="max-width: 100px;">Order has been cancelled</span></div>`;
                                break;
                            default:
                                action =
                                    `<div><span class="text-warning font-weight-bold text-center" style="max-width: 100px;">Waiting for approval</span></div>`;
                        }
                        $("#orders_latest-datatable").find("tbody").append(`
                        <tr><td>${element.id}</td>
                                            <td>
                                                Name: ${element.name_receiver}
                                                <br>
                                                Phone: ${element.phone_receiver}
                                                <br>
                                                Address: ${element.address_receiver}
                                                <br>
                                                Note: ${element.note}
                                            </td>
                                            <td>${element.total_money}</td>
                                            <td>${action}</td>
                                            <td>${element.date_format}</td>
                                            <td>
                                                <a href="${element.url}" class="action-icon">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                            </td></tr>
                        `)
                    });
                }
            });
        })
    </script>
@endpush
