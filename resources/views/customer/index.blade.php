@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.customer.title'),
        'current_page' => trans('language.customer.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                        <a href="{{ route('customer.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.customer.add') }}</a>
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
                            <form action="{{ route('customer.index') }}" method="get">
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
                                                    placeholder="{{ trans('language.customer.code') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.phone') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="phone"
                                                    value="{{ request()->phone ?? '' }}"
                                                    placeholder="{{ trans('language.phone') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.email') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="email"
                                                    value="{{ request()->email ?? '' }}"
                                                    placeholder="{{ trans('language.email') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.status') }}</label>
                                                <select class="form-control form-control-sm select2" name="status"
                                                    id="status">
                                                    <option selected="selected" value="">Trạng thái</option>
                                                    @foreach ($status as $item)
                                                        <option @if (request()->status == $item->id) selected @endif
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.customer.tax_code') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="tax_code"
                                                    value="{{ request()->tax_code ?? '' }}"
                                                    placeholder="{{ trans('language.customer.tax_code') }}">
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
                                                <a href="{{ route('customer.index') }}" class="btn btn-success btn-sm"><i
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
                                        <th class="text-center">{{ trans('language.number_phone') }}</th>
                                        <th class="text-center">{{ trans('language.email') }}</th>
                                        <th class="text-center">{{ trans('language.status') }}</th>
                                        <th class="text-center">{{ trans('language.customer.active') }}</th>
                                        <th class="text-center">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($customers->count() > 0)
                                        @foreach ($customers as $key => $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($customers->currentPage() - 1) * $customers->perPage() }}
                                                </td>
                                                <td><a
                                                        href="{{ route('customer.detail', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                                </td>
                                                <td class="text-center">{{ $item->code }}</td>
                                                <td class="text-center"><a
                                                        href="tel:{{ $item->phone }}">{{ $item->phone }}</a></td>
                                                <td class="text-center"><a
                                                        href="mailto:{{ $item->email }}">{{ $item->email }}</a></td>
                                                <td class="text-center">{{ $item->status_name }}</td>
                                                <td class="text-center">
                                                    <button
                                                        class="toggle-active-btn @if ($item->active == 1) btn btn-success @else btn btn-danger @endif text-white"
                                                        data-id="{{ $item->id }}" data-status="{{ $item->active }}">
                                                        {{ $item->active == 1 ? 'Đã kích hoạt' : 'Chưa kích hoạt' }}
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a class="flex items-center mr-3"
                                                            href="{{ route('customer.edit', ['id' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ trans('language.edit') }}
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_customer') }}"
                                                            data-text="<span >{{ $item->name }}</span>"
                                                            data-url="{{ route('customer.delete', ['id' => $item->id]) }}"
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
                                            <td colspan="9" class="text-center"> {{ trans('language.no-data') }} </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    {{ $customers->links('pagination::bootstrap-4') }}
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
