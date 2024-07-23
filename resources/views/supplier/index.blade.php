@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.supplier.title'),
        'current_page' => trans('language.supplier.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                        <a href="{{ route('supplier.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.supplier.add') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'responsible_person', 'phone', 'email', 'tax_code']) ? 'show' : '' }}"
                            id="collapseExample">
                            <form action="{{ route('supplier.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.supplier.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    value="{{ request()->name ?? '' }}"
                                                    placeholder="{{ trans('language.supplier.name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.customer.responsible_person') }}</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="responsible_person"
                                                    value="{{ request()->responsible_person ?? '' }}"
                                                    placeholder="{{ trans('language.customer.responsible_person') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.phone') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="phone"
                                                    value="{{ request()->phone ?? '' }}"
                                                    placeholder="{{ trans('language.phone') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.email') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="email"
                                                    value="{{ request()->email ?? '' }}"
                                                    placeholder="{{ trans('language.email') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.customer.tax_code') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="tax_code"
                                                    value="{{ request()->tax_code ?? '' }}"
                                                    placeholder="{{ trans('language.customer.tax_code') }}">
                                            </div>
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-sm"><i
                                                        class="fas fa-search"></i>{{ trans('language.search') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <a href="{{ route('supplier.index') }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </a>
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
                                        <th class="text-center">{{ trans('language.supplier.name') }}</th>
                                        <th class="text-center">{{ trans('language.customer.responsible_person') }}</th>
                                        <th class="text-center">{{ trans('language.phone') }}</th>
                                        <th class="text-center">{{ trans('language.email') }}</th>
                                        <th class="text-center">{{ trans('language.customer.tax_code') }}</th>
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
                                                <td>{{ $item->name }}</td>
                                                <td class="text-center">{{ $item->responsible_person }}</td>
                                                <td class="text-center">
                                                    <a href="tel:{{ $item->phone }}">{{ $item->phone }}</a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                                                </td>
                                                <td class="text-center">{{ $item->tax_code }}</td>
                                                <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a class="flex items-center mr-3"
                                                            href="{{ route('service.edit', ['id' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ trans('language.edit') }}
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_service') }}"
                                                            data-text="<span >{{ $item->name }}</span>"
                                                            data-url="{{ route('service.delete', ['id' => $item->id]) }}"
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
