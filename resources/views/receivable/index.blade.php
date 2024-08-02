@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.receivable.title'),
        'current_page' => trans('language.receivable.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i> Tìm kiếm nâng cao</button>
                        <a href="{{ route('receivable.create') }}" type="button" class="btn btn-info mr-2">
                            <i class="fas fa-plus"></i>{{ trans('language.receivable.new') }}</a>
                        <a href="{{ route('receivable.createExtend') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.receivable.add_cngh') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'code', 'status', 'services', 'from', 'to', 'type']) ? 'show' : '' }}"
                            id="collapseExample">
                            <form action="{{ route('receivable.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.customer.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    value="{{ request()->name ?? '' }}"
                                                    placeholder="{{ trans('language.customer.name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.customer.code') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    value="{{ request()->code ?? '' }}"
                                                    placeholder="{{ trans('language.customer.name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.service.title') }}</label>
                                                <select name="services" id=""
                                                    class="form-control form-control-sm select2">

                                                    <option value="">{{ trans('language.service.title') }}</option>
                                                    @foreach ($services as $item)
                                                        <option @if (request()->services == $item->id) selected @endif
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.receivable.classify') }}</label>
                                                <select name="type" id="" class="form-control form-control-sm">
                                                    <option value="">{{ trans('language.receivable.classify') }}
                                                    </option>
                                                    <option @if (request()->type == '0') selected @endif
                                                        value="0">Công nợ mới</option>
                                                    <option @if (request()->type == '1') selected @endif
                                                        value="1">Công nợ gia hạn</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.status') }}</label>
                                                <select name="status" id="" class="form-control form-control-sm">
                                                    <option value="">{{ trans('language.status') }}</option>
                                                    <option @if (request()->status == '0') selected @endif
                                                        value="0">Còn nợ</option>
                                                    <option @if (request()->status == '1') selected @endif
                                                        value="1">Thanh toán xong</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.started_at') }}</label>
                                                <input name="from" type="text"
                                                    placeholder="{{ trans('language.started_at') }}"
                                                    value="{{ request()->from ?? '' }}"
                                                    class="datepicker_start form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.ended_at') }}</label>
                                                <input name="to" type="text"
                                                    placeholder="{{ trans('language.ended_at') }}"
                                                    value="{{ request()->to ?? '' }}"
                                                    class="datepicker_end form-control form-control-sm">
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
                                                <a href="{{ route('receivable.index') }}" class="btn btn-success btn-sm"><i
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
                                        <th class="text-center">{{ trans('language.customer.name') }}</th>
                                        <th class="text-center">{{ trans('language.customer.code') }}</th>
                                        <th class="text-center">{{ trans('language.service.title') }}</th>
                                        <th class="text-center">{{ trans('language.receivable.classify') }}</th>
                                        <th class="text-center">{{ trans('language.receivable.ended_at') }}</th>
                                        <th class="text-center">{{ trans('language.receivable.contract_value') }}</th>
                                        <th class="text-center">{{ trans('language.receivable.total_advance') }}</th>
                                        <th class="text-center">{{ trans('language.receivable.amount_owed') }}</th>
                                        <th class="text-center">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($receivables->count() > 0)
                                        @foreach ($receivables as $key => $item)
                                            @php
                                                $total_advance = $item->contract_value - $item->amount_owed;
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($receivables->currentPage() - 1) * $receivables->perPage() }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('customer.detail', ['id' => $item->customer_id ?? 0]) }}">{{ $item->customer_name }}</a>
                                                </td>
                                                <td class="text-center">{{ $item->customer_code }}</td>
                                                <td class="text-center">{{ $item->service_name }}</td>
                                                <td class="text-center">{!! \App\Models\Receivable::checkType($item->type) !!}</td>
                                                <td class="text-center">{{ date('d/m/Y', strtotime($item->ended_at)) }}
                                                </td>
                                                <td class="text-center">{{ number_format($item->contract_value) }}đ</td>
                                                <td class="text-center">{{ number_format($total_advance) }}đ</td>
                                                <td class="text-center">{{ number_format($item->amount_owed) }}đ</td>
                                                <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        @if ($item->type == '0')
                                                            <a class="flex items-center mr-3"
                                                                href="{{ route('receivable.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                        @else
                                                            <a class="flex items-center mr-3"
                                                                href="{{ route('receivable.editExtend', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                        @endif
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_receivable') }}"
                                                            data-text="<span >{{ $item->name }}</span>"
                                                            data-url="{{ route('receivable.delete', ['id' => $item->id]) }}"
                                                            data-method="DELETE" data-icon="question">
                                                            <i class="fas fa-trash-alt"></i>
                                                            {{ trans('language.delete') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center"> {{ trans('language.no-data') }} </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    {{ $receivables->links('pagination::bootstrap-4') }}
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
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $(document).on('focus', '.datepicker_start', function() {
            $(this).datepicker({
                dateFormat: 'dd/mm/yy',
                onSelect: function(selectedDate) {
                    $(this).closest('.col-md-12').find(".datepicker_end").datepicker("option",
                        "minDate", selectedDate);
                }
            });

            $(this).closest('.col-md-12').find('.datepicker_end').datepicker({
                dateFormat: 'dd/mm/yy',
                onSelect: function(selectedDate) {
                    // Cập nhật ngày tối thiểu cho ngày kết thúc
                    $(this).closest('.col-md-12').find(".datepicker_start").datepicker("option",
                        "maxDate", selectedDate);
                }
            });
        })
    </script>
@endsection
