@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.price_quote.title'),
        'current_page' => trans('language.price_quote.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i> Tìm kiếm nâng cao</button>
                        <a href="{{ route('priceQuote.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.price_quote.add') }}</a>
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
                            <form action="{{ route('priceQuote.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.service.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    value="{{ request()->name ?? '' }}"
                                                    placeholder="{{ trans('language.service.name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.customer.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="customer_name"
                                                    value="{{ request()->customer_name ?? '' }}"
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
                                                <a href="{{ route('priceQuote.index') }}" class="btn btn-success btn-sm"><i
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
                                        <th class="text-center">{{ trans('language.price_quote.name') }}</th>
                                        <th class="text-center">{{ trans('language.customer.name') }}</th>
                                        <th class="text-center">{{ trans('language.customer.code') }}</th>
                                        <th class="text-center">{{ trans('language.subtotal') }}</th>
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
                                                <td><a href="{{route('priceQuote.detail', ['id' => $item->id])}}">{{ $item->name }}</a> @if($item->status == '1')<i class="far fa-envelope-open"></i> @endif</td>
                                                <td class="text-center"><a href="{{route('customer.detail', ['id' => $item->customer_id])}}">{{ $item->customer_name }}</a></td>
                                                <td class="text-center">{{ $item->customer_code }}</td>
                                                <td class="text-center">{{number_format($item->total_price)}}đ</td>
                                                <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a class="flex items-center mr-3"
                                                            href="{{ route('priceQuote.edit', ['id' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ trans('language.edit') }}
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_price_quote') }}"
                                                            data-text="<span >{{ $item->name }}</span>"
                                                            data-url="{{ route('priceQuote.delete', ['id' => $item->id]) }}"
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
@endsection
