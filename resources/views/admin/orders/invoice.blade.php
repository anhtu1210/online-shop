<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path('fonts/DejaVuSans.ttf') }}') format('truetype');
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #000;
        }

        .header h1 {
            margin: 0;
        }

        .info {
            margin: 10px 0;
        }

        .info .company-info,
        .info .order-info {
            margin-bottom: 20px;
        }

        .info h2 {
            margin: 0 0 10px;
        }

        .info p {
            margin: 0;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items th,
        .items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .items th {
            background-color: #f4f4f4;
        }

        .total {
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 2px solid #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Hóa Đơn</h1>
        </div>
        <div class="info">
            <div class="order-info">
                <h2>Thông Tin Đơn Hàng</h2>
                <p>Số Đơn Hàng: #{{ $order->id }}</p>
                <p>Ngày: {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y h:i A') }}</p>
                <p>Tên Khách Hàng: {{ $order->name }}</p>
                <p>Địa Chỉ Khách Hàng: {{ $order->address }}</p>
            </div>
        </div>
        <table class="items">
            <thead>
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá Đơn Vị</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                @php($subtotal = 0)
                @foreach ($order->details as $item)
                    @php($subtotal += $item->pivot->price * $item->pivot->quantity + $item->pivot->tax)
                    <tr>
                        <td>{{ $item->pivot->name }}</td>
                        <td>{{ $item->pivot->quantity }}</td>
                        <td>{{ number_format($item->pivot->price, 0, ',', '.') }} ₫</td>
                        <td>{{ number_format($item->pivot->price * $item->pivot->quantity + $item->pivot->tax, 0, ',', '.') }}
                            ₫</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="total">
            <p><strong>Tổng Phụ:</strong> {{ number_format($subtotal, 0, ',', '.') }} ₫</p>
            <p><strong>Mã giảm giá:</strong> {{ number_format($order->amount_coupon, 0, ',', '.') }} ₫</p>
            <p><strong>Phí vận chuyển:</strong> {{ number_format($order->amount_shipping, 0, ',', '.') }} ₫</p>
            <p><strong>Tổng Cộng:</strong> {{ number_format($order->total_price, 0, ',', '.') }} ₫</p>
        </div>
        <div class="footer">
            <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email support@congty.com.</p>
        </div>
    </div>
</body>

</html>
