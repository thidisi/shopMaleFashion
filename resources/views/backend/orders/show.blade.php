@extends('backend.layout_admin')
@php
    $title = 'Orders';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Orders view</h1>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive my-3">
                            <table class="table table-centered w-100 dt-responsive nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Price && Discount</th>
                                        <th>Quantity</th>
                                        <th>Attributes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->productions as $value)
                                        <tr>
                                            <td>
                                                <img class="ml-2 mr-2" src="{{ asset("storage/$value->image") }}"
                                                    alt="contact-img" title="contact-img" class="rounded mr-3"
                                                    height="100" />
                                                <span class="d-inline-block">{{ $value->name }}</span>
                                            </td>
                                            <td>
                                                Price: {{ $value->price }}
                                                <br>
                                                @if (!empty($value->discount))
                                                    Discount: {{ $value->discount->discount_price }} %
                                                @endif
                                            </td>

                                            <td>
                                                {{ $value->pivot->quantity }}
                                            </td>

                                            <td>
                                                {{ $value->pivot->attr }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                @if ($order->action == 'pending')
                                    <form action="{{ route('admin.orders.action', 'active') }}" method="post"
                                        class=" float-right">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->id }}" />
                                        <button type="submit" class="btn btn-info">Browser</button>
                                    </form>
                                    <form action="{{ route('admin.orders.action', 'inactive') }}" method="post"
                                        class="mr-2 float-right">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->id }}" />
                                        <button class="btn btn-danger">Cancel</button>
                                    </form>
                                @endif
                                <h4 class="float-right mr-4">Total: <span
                                        class="text-danger">${{ $order->total_money }}</span>
                                </h4>
                                @if (!empty($order->tickets))
                                    <h4 class="float-right mr-4">Sale: <span class="text-danger">-
                                            ${{ $order->tickets->price }}</span>
                                    </h4>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4 float-right">
                            <a href="{{ route('admin.orders') }}" class="btn btn-primary mb-2 float-right"><i
                                    class="mdi mdi-plus-circle mr-1"></i> Back Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#delete-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).data('route'),
                    data: {
                        '_method': 'delete'
                    },
                    success: function(response, textStatus, xhr) {
                        alert(response);
                        window.location = '/admin/categories'
                    }
                });
            })
        });
    </script> --}}
@endpush
