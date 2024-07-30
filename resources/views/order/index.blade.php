@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.order.title'),
        'current_page' => trans('language.order.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                                aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'email', 'phone', 'code', 'status', 'tax_code', 'career']) ? 'show' : '' }}"
                             id="collapseExample">
                            <form action="{{ route('order.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.order.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                       value="{{ request()->name ?? '' }}"
                                                       placeholder="{{ trans('language.order.name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.order.service_name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="service_name"
                                                       value="{{ request()->service_name ?? '' }}"
                                                       placeholder="{{ trans('language.order.service_name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.order.contract_date') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="contract_date"
                                                       value="{{ request()->contract_date ?? '' }}"
                                                       placeholder="{{ trans('language.order.contract_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.order.price') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="price"
                                                       value="{{ request()->price ?? '' }}"
                                                       placeholder="{{ trans('language.order.price') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.order.type') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="type"
                                                       value="{{ request()->type ?? '' }}"
                                                       placeholder="{{ trans('language.order.type') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.order.start_date') }}</label>
                                                <input type="date" class="form-control form-control-sm" name="start_date"
                                                       value="{{ request()->start_date ?? '' }}"
                                                       placeholder="{{ trans('language.order.start_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.order.end_date') }}</label>
                                                <input type="date" class="form-control form-control-sm" name="end_date"
                                                       value="{{ request()->end_date ?? '' }}"
                                                       placeholder="{{ trans('language.order.end_date') }}">
                                            </div>
                                        </div>
                                        <div class="mr-2">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-sm"><i
                                                        class="fas fa-search"></i>{{ trans('language.search') }}</button>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <a href="{{ route('order.index') }}" class="btn btn-success btn-sm"><i
                                                        class="fas fa-sync-alt"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ trans('language.order.profile') }}</th>
                                    <th class="text-center">{{ trans('language.order.service') }}</th>
                                    <th class="text-center">{{ trans('language.order.contract_date') }}</th>
                                    <th class="text-center">{{ trans('language.order.subtotal') }}</th>
                                    <th class="text-center">{{ trans('language.order.type') }}</th>
                                    <th class="text-center">{{ trans('language.order.start_date') }}</th>
                                    <th class="text-center">{{ trans('language.order.end_date') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if ($orders->count() > 0)
                                        @foreach ($orders as $key => $detail)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li class="mb-3">Tên khách hàng: {{ $detail->customer->name }}</li>
                                                        <li class="mb-3">Email: {{ $detail->customer->email }}</li>
                                                        <li>Số điện thoại: {{ $detail->customer->phone }}</li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li class="mb-3">Tên dịch vụ: {{ $detail->service->name }}</li>
                                                        <li class="mb-3">Giá dịch vụ: {{ number_format($detail->service->price, 0, ',', '.') }} đ</li>
                                                        <li>Diện tích: {{ number_format($detail->service->acreage, 0, ',', '.') }} m²</li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    {{ date('d-m-Y', strtotime($detail->contract_date)) }}
                                                </td>
                                                <td>
                                                    {{ number_format($detail->subtotal, 0, ',', '.') }} đ
                                                </td>
                                                <td class="text-center">
                                                    <select class="form-control select2"
                                                        name="typeOrder"
                                                        id="typeOrder"
                                                        data-id="{{ $detail->id }}"
                                                        data-url="{{ route('order.updateType', $detail->id) }}"
                                                        data-status="{{ $detail->type }}"
                                                        data-method="POST"
                                                        >
                                                        <option value="1" {{ $detail->type == 1 ? 'selected' : '' }}>Giữ chỗ</option>
                                                        <option value="2" {{ $detail->type == 2 ? 'selected' : '' }}>Đã cọc</option>
                                                        <option value="3" {{ $detail->type == 3 ? 'selected' : '' }}>Đã thuê</option>
                                                        <option value="4" {{ $detail->type == 4 ? 'selected' : '' }}>Đã hủy</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    {{ date('d-m-Y', strtotime($detail->started_at)) }}
                                                </td>
                                                <td>
                                                    {{ date('d-m-Y', strtotime($detail->ended_at)) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center"> {{ trans('language.no-data') }} </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    {{ $orders->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#typeOrder').on('change', function(e) {
                var type = $(this).val();
                var id = $(this).data('id');
                var url = $(this).data('url');
                var method = $(this).data('method');
                Swal.fire({
                    title: 'Bạn muốn thay đổi trạng thái đơn này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: method,
                            data: {
                                id: id,
                                type: type
                            },
                            success: function(data) {
                                Swal.fire(
                                    data.message
                                );
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    'Lỗi!',
                                    'Có lỗi xảy ra trong quá trình cập nhật.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
