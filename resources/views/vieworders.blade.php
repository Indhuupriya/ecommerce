@extends('layouts.admin.headeradmin')

@section('content')
<div class="card shadow mb-4">
    <div class="box-header">
        <h6 class="m-0 font-weight-bold">Orders</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Transaction ID</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->tnx_id }}</td>
                        <td>{{ $order->payment_status }}</td>
                        <td>
                            @if($order->order_status != 'completed')
                            <select class="form-control order-status" data-order-id="{{ $order->id }}">
                                <option value="pending" @if($order->order_status == 'pending') selected @endif>Pending</option>
                                <option value="completed" @if($order->order_status == 'completed') selected @endif>Completed</option>
                            </select>
                            @else
                           {{ $order->order_status }}
                            @endif
                        </td>
                        <td>
                            <ul>
                                @foreach ($order->orderItems as $item)
                                <li>{{ $item->product->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach ($order->orderItems as $item)
                                <li style="display:block;">{{ $item->quantity }}</li>
                                @endforeach
                             </ul>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.invoice', ['id' => $order->id]) }}" class="btn btn-primary btn-sm">View Invoice</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex mt-2 float-right">
    {{ $orders->links() }}
</div>
@endsection

