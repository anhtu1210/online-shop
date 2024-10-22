<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .email-body {
            padding: 20px;
        }

        .email-footer {
            background-color: #f1f1f1;
            color: #777;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }

        .order-details {
            margin: 20px 0;
        }

        .order-details h2 {
            margin: 0 0 10px;
        }

        .order-summary {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .order-summary th,
        .order-summary td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .order-summary th {
            background-color: #f7f7f7;
        }

        .order-summary td {
            background-color: #ffffff;
        }

        .order-summary .total {
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Order Confirmation</h1>
        </div>
        <div class="email-body">
            <p>Dear [{{ $order->name }}],</p>
            <p>Thank you for your order! Your order has been successfully placed. Below are the details:</p>

            <div class="order-details">
                <h2>Order Details</h2>
                <p><strong>Order Number:</strong> [{{ $order->id }}]</p>
                <p><strong>Order Date:</strong> [{{ date_format(date_create($order->created_at), 'd/m/Y H:i:s') }}]</p>
                <p><strong>Status:</strong> [{{ $order->status }}]</p>
                <p><strong>Payment Method:</strong> [Payment Method]</p>
            </div>

            <table class="order-summary">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                        <tr>
                            <td>{{ $cart->name }}</td>
                            <td>{{ $cart->qty }}</td>
                            <td>{{ number_format($cart->price, 0, ',', '.') }} ₫</td>
                            <td>{{ number_format($cart->subtotal + $cart->tax, 0, ',', '.') }} ₫</td>
                        </tr>
                    @endforeach


                    <tr>
                        <td class="total" colspan="3">Subtotal</td>
                        <td class="total">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                    </tr>
                        <tr>
                            <td class="total" colspan="3">Discount</td>
                            <td class="total">{{ number_format($order->amount_coupon, 0, ',', '.') }} ₫</td>
                        </tr>
                    <tr>
                        <td class="total" colspan="3">Shipping</td>
                        <td class="total">{{ number_format($order->amount_shipping, 0, ',', '.') }} ₫</td>
                    </tr>
                    <tr>
                        <td class="total" colspan="3">Total</td>
                        <td class="total">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                    </tr>
                </tbody>
            </table>

            <p>If you have any questions, feel free to <a href="mailto:support@example.com">contact us</a>.</p>
            <a href="#" class="btn" style="color: #ffffff">View Your Order</a>
        </div>
        <div class="email-footer">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
            <p>123 Your Street, Your City, Your Country</p>
        </div>
    </div>
</body>

</html>
