@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.receipt.title'),
        'current_page' => trans('language.receipt.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                        <a href="{{ route('receipt.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.receipt.add') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'customer_name', 'code']) ? 'show' : '' }}"
                            id="collapseExample">
                            <form action="{{ route('receipt.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.customer.name') }}</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="customer_name" value="{{ request()->customer_name ?? '' }}"
                                                    placeholder="{{ trans('language.customer.name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.customer.code') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    value="{{ request()->code ?? '' }}"
                                                    placeholder="{{ trans('language.customer.code') }}">
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
                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-10">

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
                                                <a href="{{ route('receipt.index') }}" class="btn btn-success btn-sm"><i
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
                                        <th class="text-center">{{ trans('language.subtotal') }}</th>
                                        <th class="text-center">{{ trans('language.created_date') }}</th>
                                        <th class="text-center">{{ trans('language.reason') }}</th>
                                        <th class="text-center">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($datas->count() > 0)
                                        @foreach ($datas as $key => $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($datas->currentPage() - 1) * $datas->perPage() }}
                                                </td>
                                                <td class="text-center"><a
                                                        href="{{ route('customer.detail', ['id' => $item->customer_id]) }}">{{ $item->customer_name }}</a>
                                                </td>
                                                <td class="text-center">{{ $item->customer_code }}</td>
                                                <td class="text-center">{{ $item->price }}đ</td>
                                                <td class="text-center">{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                                <td class="">{{ $item->reason }}</td>
                                                <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a class="flex items-center mr-3" style="color:#28a745" target="blank"
                                                            href="{{ route('receipt.printf', ['id' => $item->id]) }}">
                                                            <i class="fas fa-print"></i>
                                                            {{ trans('language.printf') }}
                                                        </a>

                                                        @if ($item->type == '4')
                                                            <a class="flex items-center mr-3"
                                                                href="{{ route('receipt.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                        @endif

                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_receipt') }}"
                                                            data-text=""
                                                            data-url="{{ route('receipt.delete', ['id' => $item->id]) }}"
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
                                            <td colspan="7" class="text-center"> {{ trans('language.no-data') }} </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    {{ $datas->links('pagination::bootstrap-4') }}
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
