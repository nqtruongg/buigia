<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Dịch vụ</title>
    <style>
        body {
            font-family: 'time-new-roman';
            font-size: 12px
        }

        .container {
            width: 95%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border-top: 1px solid #ddd;
            border-bottom: none;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .total-row td {
            border: none;
            text-align: right;
            padding-right: 20px;
            font-weight: bold;
            /* background-color: #f5f5f5; */
        }

        .total-row td:last-child {
            padding-right: 35px;
        }

        .header {
            padding: 40px;
        }

        img {
            width: 100%;
            height: auto;

        }
    </style>
</head>

<body>
    <div class="header" style="padding-bottom: 20px">
        <img src="{{ public_path('image-price-quote.jpg') }}" alt="">
    </div>
    <div class="title" style="padding-bottom:20px">
        <h3 style="text-align:center; padding-bottom:0; margin-bottom:0; font-size:16px">BẢNG BÁO GIÁ</h3>
        <span style="text-align:center; display:block">(Dịch vụ thiết kế web site)</span>
    </div>

    

    <div class="container" style="text-align:center">
        <div style="width:100%">

            <p style="margin-bottom:5px; text-align:left">Kính gửi: <span style="font-weight:bold">{{$name}}</span></p>
            <p style="padding-bottom:5px; text-align:left">Sau khi tiếp nhận và khảo sát yêu cầu của quý khách Công ty TNHH Đầu tư Quốc tế Biển Vàng xin gửi tới quý khách Bảng
            báo giá chi tiết dịch vụ với nội dung sau:</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="font-weight:bold">STT</th>
                    <th>Dịch vụ</th>
                    <th>Thành tiền</th>
                    <th>Mô tả</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sum = 0;
                @endphp
                @foreach ($datas as $key => $item)
                    @php
                        $sum += $item['price'];
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price']) }}đ</td>
                        <td>{{ $item['describe'] }}</td>
                        <td>{{ $item['note'] }}</td>
                    </tr>
                @endforeach

                <tr class="total-row" style="background-color: #1e98ccc7">
                    <td colspan="5" style="color:#ffffff">Tổng tiền: {{ number_format($sum) }}đ</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer" style="padding: 0 20px ; width: 100%">
        <div class="text" style="text-align:left">
            <p style="margin-bottom:5px">Cảm ơn quý khách đã quan tâm tới dịch vụ của chúng tôi.</p>
            <p style="margin-bottom:10px">Rất hi vọng được hợp tác cùng quý khách.</p>
        </div>
        <div class="signature" style="width: 100%">
            <div style="width:50%; min-width: 50%;"></div>
            <div style=" width:50%;  min-width: 50%; float: right">
                <div style="text-align:center">
                    <p style="margin-bottom:5px">Đại diện công ty</p>
                </div>
                <div style="text-align:center">
                    <p style="margin-bottom:5px">Giám đốc</span>
                </div>
                <div style="text-align:center">
                    <p style=" font-weight:bold">Nguyễn Thị Ngọc Trang</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
