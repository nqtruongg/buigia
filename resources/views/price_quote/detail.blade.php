@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.price_quote.detail'),
        'middle_page' => trans('language.price_quote.title'),
        'current_page' => trans('language.price_quote.detail'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form id="form_submit" action="{{ route('priceQuote.update', ['id' => $data->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_send" value="{{ $data->id }}">
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="invoice p-3 mb-3">
                                            <div class="row invoice-info">

                                                {{-- <div class="col-sm-12 invoice-col">
                                                    <img src="/image-price-quote.jpg" alt="">
                                                </div> --}}
                                                <div class="col-sm-4 invoice-col">
                                                    <br>
                                                    <b>Khách hàng:</b> {{ $data->customer_name }}<br>
                                                    <b>Tên báo giá:</b> {{ $data->name }}<br>
                                                    <b>Nội dung:</b>
                                                    <br>
                                                    {!!$data->content!!}
                                                    <br>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
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
                                                            @foreach ($services as $key => $item)
                                                                @php
                                                                    $sum += $item->price;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>{{ $item->name }}</td>
                                                                    <td>{{ number_format($item->price) }}đ</td>
                                                                    <td>{{ $item->describe }}</td>
                                                                    <td>{{ $item->note }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex justify-content-center">
                                                        <h3>Tổng tiền:</h3>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <span style="font-size:24px">{{ number_format($sum) }}đ</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row no-print">
                                                <div class="col-12">

                                                    <button id="send" type="button" target="_blank"
                                                        class="btn btn-success float-right">
                                                        <i class="fas fa-paper-plane"></i> Gửi
                                                    </button>
                                                    <a type="button" class="btn btn-primary float-right"
                                                        style="margin-right: 5px;"
                                                        href="{{ route('priceQuote.exportPdf', ['id' => $data->id]) }}">
                                                        <i class="fas fa-download"></i> Tải về
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('js')
    <script>
        $(document).on('click', '#send', function() {
            var id = $('#id_send').val();
            $.ajax({
                url: '/price-quote/send',
                dataType: "JSON",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(data) {
                    if (data.code === 200) {
                        toastr.success('Gửi báo giá thành công');
                    }
                },
                error: function(err) {
                    toastr.error("Thất bại", {
                        timeOut: 5000
                    });
                },
            });
        })
    </script>
@endsection
