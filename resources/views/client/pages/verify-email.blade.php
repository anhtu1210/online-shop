<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kích hoạt tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #ffffff;
        }

        h3 {
            color: #333;
        }

        h4 {
            color: #555;
        }

        p {
            color: #666;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Xin chào: {{ $details->name }}</h3>
        <h4>Chào mừng bạn đã đến với công ty cổ phần EKKA!</h4>

        <p>Chúng tôi rất vui mừng chào đón bạn gia nhập cộng đồng của chúng tôi. Để hoàn tất quá trình đăng ký và bắt
            đầu sử dụng tài khoản của bạn, vui lòng bấm vào liên kết dưới đây để kích hoạt tài khoản:</p>

        <p><a href="{{ route('verification-email', $details->email) }}">Kích hoạt tài khoản</a></p>

        <p>Sau khi kích hoạt tài khoản, bạn sẽ có thể truy cập vào tất cả các tính năng và dịch vụ mà chúng tôi cung
            cấp, bao gồm:</p>
        <ul>
            <li>Truy cập vào các sản phẩm độc quyền và chương trình khuyến mãi đặc biệt.</li>
            <li>Nhận thông báo về các sự kiện giảm giá và ưu đãi hàng tuần.</li>
            <li>Được hỗ trợ tận tình và nhanh chóng từ đội ngũ chăm sóc khách hàng của chúng tôi.</li>
            <li>Tham gia đánh giá và nhận xét sản phẩm để nhận điểm thưởng.</li>
        </ul>


        <p>Nếu bạn không yêu cầu tạo tài khoản này, vui lòng bỏ qua email này. Tài khoản của bạn sẽ không được kích hoạt
            và sẽ bị xóa sau một khoảng thời gian nhất định để đảm bảo an toàn và bảo mật.</p>

        <p>Nếu bạn có bất kỳ câu hỏi nào hoặc cần hỗ trợ, xin đừng ngần ngại liên hệ với chúng tôi qua email [email hỗ
            trợ khách hàng] hoặc gọi đến số [số điện thoại hỗ trợ khách hàng]. Chúng tôi luôn sẵn sàng hỗ trợ bạn.</p>

        <p>Trân trọng,<br>
            Đội ngũ công ty cổ phần EKKA</p>
    </div>
</body>

</html>
