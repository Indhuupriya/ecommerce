<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .invoice-header p {
            margin: 0;
            color: #666;
        }
        .invoice-details, .billing-address {
            margin-bottom: 20px;
        }
        .billing-address {
            margin-bottom: 40px;
        }
        .billing-address h3, .invoice-details h3 {
            margin-bottom: 10px;
        }
        .billing-address p, .invoice-details p {
            margin: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f4f4f4;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Invoice</h1>
            <p>Order ID: {{ $order->id }}</p>
        </div>
        <div class="invoice-details">
            <h3>Order Details</h3>
            <p>Order Status: {{ $order->order_status }}</p>
            <p>Payment Status: {{ $order->payment_status }}</p>
        </div>
        <div class="billing-address">
            <h3>Billing Address</h3>
            <p>{{ $billing_address->firstname }}</p>
            <p>{{ $billing_address->address }}</p>
            <p>{{ $billing_address->city }}, {{ $billing_address->state }} {{ $billing_address->zip }}</p>
            <p>{{ $billing_address->country }}</p>
            <p>Email: {{ $billing_address->email }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
              
            @foreach($items as $item)
                <tr>
                    <td>
                           @if($item->product->images)
                                <img src="{{ asset('storage/' . $item->product->images) }}" alt="{{ $item->product->name }}" class="product-image">
                            @else
                                <span>No image</span>
                            @endif
                    </td>
                    <td>
                        @if($item->product)
                            {{ $item->product->name }}
                        @else
                            Product Not Available
                        @endif
                    </td>
                    <td>
                        @if($item->product)
                            ${{ number_format($item->price, 2) }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <p class="total">Total: ${{ number_format($order->total, 2) }}</p>
    </div>
</body>
</html>
