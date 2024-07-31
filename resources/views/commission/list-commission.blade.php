@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.commission.list_commission'),
        'current_page' => trans('language.commission.list_commission'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                        {{-- <a href="{{ route('commission.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.commission.add') }}</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'email', 'phone', 'code', 'tax_code', 'career']) ? 'show' : '' }}"
                            id="collapseExample">
                            <form action="{{ route('commission.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.commission.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    value="{{ request()->name ?? '' }}"
                                                    placeholder="{{ trans('language.commission.name') }}">
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
                                                <a href="{{ route('commission.index') }}" class="btn btn-success btn-sm"><i
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
                                        <th class="text-center">{{ trans('language.commission.user_id') }}</th>
                                        <th class="text-center">{{ trans('language.commission.phone') }}</th>
                                        <th class="text-center">{{ trans('language.commission.customer_service') }}</th>
                                        <th class="text-center">{{ trans('language.commission.price') }}</th>
                                        <th class="text-center">{{ trans('language.commission.reason') }}</th>
                                        <th class="text-center">{{ trans('language.commission.date') }}</th>
                                        {{-- <th class="text-center">{{ trans('language.action') }}</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        use Carbon\Carbon;
                                    @endphp
                                    @if ($commissionBonus->count() > 0)
                                        @foreach ($commissionBonus as $key => $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($commissionBonus->currentPage() - 1) * $commissionBonus->perPage() }}
                                                </td>
                                                <td class="text-center">{{ $item->user->first_name ?? '' }}
                                                    {{ $item->user->last_name ?? '' }}</td>
                                                <td class="text-center">{{ $item->user->phone ?? '' }}</td>
                                                <td class="text-center">{{ $item->customerService->service->name ?? '' }}
                                                </td>
                                                <td class="text-center">{{ number_format($item->price) ?? '' }}đ</td>
                                                <td class="text-center">Khách {{ $item->reason ?? '' }}</td>
                                                <td class="text-center">
                                                    {{ Carbon::parse($item->date)->format('d/m/Y') ?? '' }}</td>
                                                {{-- <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a class="flex items-center mr-3"
                                                            href="{{ route('commission.edit', ['id' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ trans('language.edit') }}
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_commission') }}"
                                                            data-text="<span >{{ $item->name }}</span>"
                                                            data-url="{{ route('commission.delete', ['id' => $item->id]) }}"
                                                            data-method="DELETE" data-icon="question">
                                                            <i class="fas fa-trash-alt"></i>
                                                            {{ trans('language.delete') }}
                                                        </a>
                                                    </div>
                                                </td> --}}
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
                                    {{ $commissionBonus->links('pagination::bootstrap-4') }}
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
