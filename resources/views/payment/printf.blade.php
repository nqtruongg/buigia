<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>In phiếu chi</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <style>
        @page {
            size: A5 landscape
        }

        .receipt {
            width: 210mm;
            height: 148mm;
            max-width: 210mm;
            max-height: 148mm;
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            border: 1px solid black;
        }

        p {
            margin: 0;
        }

        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-around;
            padding-top: 40px;
            padding-left: 30px;
            padding-right: 30px;
        }

        img {
            width: 100%;
            height: 100%;
        }

        .logo {
            height: 26.33mm;
            width: 21.95mm;
            padding-top: 11px;
        }

        .info {
            text-align: center;
        }

        .info h3 {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .info h1 {
            font-size: 20px;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .info .text {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .info .tax-code {
            font-size: 14px;
            font-weight: bold;
            margin-top: 4px;
        }

        .info .date {
            font-size: 14px;
            font-style: italic;
        }

        .more-info {
            font-size: 12px;
            text-align: center;
        }

        .more-info .fz-11 {
            font-size: 14px;
            text-align: left;
        }

        .content {
            margin-top: 20px;
            padding-left: 20px;
            margin-top: 30px;
        }

        .content .form {
            display: flex;
            align-items: center;
            font-size: 14px;
            margin-bottom: 7px;
        }

        .content .form .lable {
            min-width: 17%;
            font-size: 13px;
        }

        .sign {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            padding-right: 100px;
            padding-left: 40px;
            margin-top: 50px;
        }

        .sign .lable {
            font-weight: bold;
        }

        .in-sign {
            text-align: center;
        }
    </style>

</head>

<body class="A5 landscape">
    <section class="sheet receipt" id="receiptToPrint">
        <div class="header">
            <div class="logo">
                <img src="/logo-pt.png" alt="">
            </div>
            <div class="info">
                <h3>CÔNG TY TNHH ĐẦU TƯ QUỐC TẾ BIỂN VÀNG</h3>
                <p class="text">Số nhà 7, Ngách 124/1, Đường Nguyễn Xiển, </p>
                <p class="text" style="margin-bottom: 5px">Phường Hạ Đình, Quận Thanh Xuân, TP Hà Nội</p>
                <p class="tax-code">MST: 0107391892</p>
                <h1>PHIẾU CHI</h1>
                <p class="date">{{ $formattedDate }}</p>
            </div>
            <div class="more-info">
                <p class="" style="margin-top: 21px;margin-bottom: 5px;">Mẫu số: 01 - TT</p>
                <p class="" style="margin-bottom: 10px;">(Ban hành theo QĐ số: 48/2006/QĐ-BTC</p>
                <p class="" style="margin-bottom: 5px;">ngày 14 tháng 09 năm 2006 </p>
                <p class="">của Bộ Trưởng BTC)</p>
                <p class="fz-11" style="margin-top: 18px;">Quyển số: .................</p>
                <p class="fz-11" style="margin-top: 5px;">Số: ...........................</p>
            </div>
        </div>
        <div class="content">
            <div class="form">
                <div class="lable">Họ tên người nhận tiền</div>
                <div class="input">: {{ $data->name }}</div>
            </div>
            <div class="form">
                <div class="lable">Địa chỉ</div>
                <div class="input">: {{ $data->address }}</div>
            </div>
            <div class="form">
                <div class="lable">Lý do chi</div>
                <div class="input">: {{ $data->reason }}</div>
            </div>
            <div class="form">
                <div class="lable">Số tiền</div>
                <div class="input">: {{ $data->price }} VNĐ</div>
                <input id="price" type="hidden" value="{{ $data->price }}">
            </div>
            <div class="form">
                <div class="lable">Viết bằng chữ</div>
                <div class="input">: <span class="text-price"></span>VNĐ</div>
            </div>
            <div class="form">
                <div class="lable">Kèm theo</div>
                <div class="input">: ………… chứng từ gốc.</div>
            </div>
        </div>
        <div class="sign">
            <div class="in-sign">
                <div class="lable">Giám đốc</div>
                <div class="input">(Ký, đóng dấu)</div>
            </div>
            <div class="in-sign">
                <div class="lable">Người nhận tiền</div>
                <div class="input">(Ký, đóng dấu)</div>
            </div>
            <div class="in-sign">
                <div class="lable">Người lập phiếu</div>
                <div class="input">(Ký, đóng dấu)</div>
            </div>
            <div class="in-sign">
                <div class="lable">Thủ quỹ</div>
                <div class="input">(Ký, đóng dấu)</div>
            </div>
        </div>
    </section>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
