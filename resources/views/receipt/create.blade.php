@extends('layout.master')

@section('css')
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
            /* padding-top: 11px; */
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
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.receipt.add'),
        'middle_page' => trans('language.receipt.title'),
        'current_page' => trans('language.receipt.add'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('receipt.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.option') }}</label>
                                            <select class="form-control" name="" id="">
                                                <option value="">Chọn thông tin nhập</option>
                                                <option value="0">{{ trans('language.customer.title') }}</option>
                                                <option value="0">Nhập thông tin</option>
                                            </select>
                                        </div>
                                        @if ($errors->first('name'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.customer.title') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2" name="customer" id="">
                                                <option value="">{{ trans('language.customer.title') }}</option>
                                                @foreach ($customers as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }} {{ $item->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->first('name'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                        <input type="hidden" name="customer_name" value="">
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Người nộp tiền</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Người nộp tiền">
                                        </div>
                                        @if ($errors->first('name'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Số tiền<span
                                                class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="price" placeholder="Số tiền"
                                                value="{{ old('price') ?? '' }}">
                                        </div>
                                        @if ($errors->first('price'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('price') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.reason') }}<span
                                                class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="reason"
                                                placeholder="{{ trans('language.reason') }}">
                                        </div>
                                        @if ($errors->first('reason'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('reason') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Địa chỉ<span
                                                class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="address" placeholder="Địa chỉ">
                                        </div>
                                        @if ($errors->first('name'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" id="view" class="btn btn-block btn-info">Xem
                                                trước</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="preview">

                                    <body class="A5 landscape">
                                        <section class="sheet receipt" id="receiptToPrint">
                                            <div class="header">
                                                <div class="logo">
                                                    <img src="/logo-pt.png" alt="">
                                                </div>
                                                <div class="info">
                                                    <h3>CÔNG TY TNHH ĐẦU TƯ QUỐC TẾ BIỂN VÀNG</h3>
                                                    <p class="text">Số nhà 7, Ngách 124/1, Đường Nguyễn Xiển, </p>
                                                    <p class="text" style="margin-bottom: 5px">Phường Hạ Đình, Quận Thanh
                                                        Xuân, TP Hà Nội</p>
                                                    <p class="tax-code">MST: 0107391892</p>
                                                    <h1>PHIẾU THU</h1>
                                                    <p class="date"></p>
                                                </div>
                                                <div class="more-info">
                                                    <p class="" style="margin-top: 0px;margin-bottom: 5px;">Mẫu số:
                                                        01 - TT</p>
                                                    <p class="" style="margin-bottom: 10px;">(Ban hành theo QĐ số:
                                                        48/2006/QĐ-BTC</p>
                                                    <p class="" style="margin-bottom: 5px;">ngày 14 tháng 09 năm 2006
                                                    </p>
                                                    <p class="">của Bộ Trưởng BTC)</p>
                                                    <p class="fz-11" style="margin-top: 18px;">Quyển số: .................
                                                    </p>
                                                    <p class="fz-11" style="margin-top: 5px;">Số:
                                                        ...........................</p>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <div class="form">
                                                    <div class="lable">Họ tên người nộp tiền</div>
                                                    <div class="input">: <span id="payer"></span></div>
                                                </div>
                                                <div class="form">
                                                    <div class="lable">Địa chỉ</div>
                                                    <div class="input">: <span class="" id="address_pay"></span></div>
                                                </div>
                                                <div class="form">
                                                    <div class="lable">Lý do thu</div>
                                                    <div class="input">: <span class="" id="reason_pay"></span></div>
                                                </div>
                                                <div class="form">
                                                    <div class="lable">Số tiền</div>
                                                    <div class="input">: <span class="" id="price_pay"></span>VNĐ</div>
                                                    <input id="price" type="hidden" value="">
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
                                                    <div class="lable">Người nộp tiền</div>
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

                                    </body>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-primary d-none">{{ trans('language.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('dist/js/pages/create_receipt.js') }}"></script>
@endsection
