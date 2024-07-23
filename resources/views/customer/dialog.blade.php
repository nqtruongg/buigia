@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('/dist/css/pages/customer_dialog.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.customer.detail'),
        'middle_page' => trans('language.customer.title'),
        'current_page' => trans('language.customer.dialog'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    @php
                        if ($customer->status == 2) {
                            $class_stt = 'background-info';
                        } elseif ($customer->status == 3) {
                            $class_stt = 'background-success';
                        } else {
                            $class_stt = '';
                        }
                    @endphp
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title pt-1">{{ trans('language.customer.info') }}</h3>
                            <div class="card-tools">
                                <a class="btn btn-tool" href="{{ route('customer.edit', ['id' => $customer->id]) }}">
                                    <i class="fas fa-edit"></i>
                                    {{ trans('language.edit') }}
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-sm-12">
                                <b>{{ trans('language.customer.name') }}:</b> <span>{{ $customer->name }}</span><br>
                                <b>{{ trans('language.customer.code') }}:</b> <span>{{ $customer->code }}</span><br>
                                <b>{{ trans('language.customer.responsible_person') }}:</b>
                                <span>{{ $customer->responsible_person }}</span><br>
                                <b>{{ trans('language.customer.tax_code') }}:</b>
                                <span>{{ $customer->tax_code }}</span><br>
                                <b>{{ trans('language.phone') }}:</b> <span><a
                                        href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></span><br>
                                <b>{{ trans('language.email') }}:</b> <span><a
                                        href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></span><br>
                                <b>{{ trans('language.customer.status') }}:</b>
                                <span class="{{ $class_stt }}">{{ $customer->status_name }}</span><br>
                                <b>{{ trans('language.customer.address') }}:</b> <span>{{ $customer->address }}</span><br>
                                <b>{{ trans('language.customer.invoice_address') }}:</b>
                                <span>{{ $customer->invoice_address }}</span><br>
                                <b>{{ trans('language.customer.supplier') }}:</b>
                                <span>{{ $customer->supplier }}</span><br>
                                <b>{{ trans('language.customer.career') }}:</b> <span>{{ $customer->career }}</span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="col-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <div class="nav nav-tabs justify-content-between" id="custom-tabs-four-tab" role="tablist">
                                    <div class="d-flex">
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="{{ route('customer.detail', ['id' => $customer->id]) }}">{{ trans('language.customer.document') }}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active"
                                                href="javascript:void(0)">{{ trans('language.customer.dialog') }}
                                            </a>
                                        </li>
                                    </div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="collapse"
                                            data-target="#multiCollapseExample_search" aria-expanded="false"
                                            aria-controls="multiCollapseExample_search">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-toggle="collapse"
                                            data-target="#multiCollapseExample_add" aria-expanded="false"
                                            aria-controls="multiCollapseExample_add">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-home-tab">
                                        <div class="row">
                                            <div class="col">
                                                <div class="collapse multi-collapse {{ request()->has(['user_name', 'from', 'to']) ? 'show' : '' }}"
                                                    id="multiCollapseExample_search">
                                                    <form action="{{ route('customer.dialog', ['id' => $customer->id]) }}"
                                                        method="get">
                                                        <div class="border mb-2">
                                                            <div class="d-flex search-file pd-5">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('language.user.name') }}</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="user_name"
                                                                            value="{{ request()->user_name ?? '' }}"
                                                                            placeholder="{{ trans('language.user.name') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('language.started_at') }}</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm datepicker_start"
                                                                            name="from"
                                                                            value="{{ request()->from ?? '' }}"
                                                                            placeholder="{{ trans('language.started_at') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('language.ended_at') }}</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm datepicker_end"
                                                                            name="to"
                                                                            value="{{ request()->to ?? '' }}"
                                                                            placeholder="{{ trans('language.ended_at') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="mr-2">
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>&nbsp;</label>
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="">
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>&nbsp;</label>
                                                                        <a href="{{ route('customer.dialog', ['id' => $customer->id]) }}"
                                                                            class="btn btn-success btn-sm">
                                                                            <i class="fas fa-sync-alt"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="collapse multi-collapse {{ $errors->first('content') ? 'show' : '' }}"
                                                    id="multiCollapseExample_add">
                                                    <div class="border mb-3">
                                                        <form
                                                            action="{{ route('customer.createDialog', ['id' => $customer->id]) }}"
                                                            method="post" class="pd-10">
                                                            @csrf
                                                            <textarea id="summernote" name="content"></textarea>
                                                            @if ($errors->first('content'))
                                                                <div class="invalid-alert text-danger">
                                                                    {{ $errors->first('content') }}
                                                                </div>
                                                            @endif
                                                            <div class="d-flex justify-content-end">
                                                                <button class="btn btn-primary btn-sm"
                                                                    type="submit">{{ trans('language.save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if (count($dialogs) > 0)
                                            @foreach ($dialogs as $key => $item)
                                                <div class="card dialog">
                                                    <div class="card-header pd-10">
                                                        <div class="d-flex align-items-baseline card-title">
                                                            <div class="dialog-header">{{ $item->full_name }}</div>
                                                            <div class="time-dialog">
                                                                <i class="far fa-clock"></i>
                                                                @if ($item->created_at == $item->updated_at)
                                                                    <span>{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</span>
                                                                @else
                                                                    <span>{{ trans('language.edited') }}:
                                                                        {{ date('d/m/Y H:i:s', strtotime($item->updated_at)) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool btn-dialog-edit"
                                                                data-toggle="collapse"
                                                                data-target="#multiCollapseExample{{ $item->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="multiCollapseExample{{ $item->id }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </button>

                                                            <button type="button"
                                                                class="btn btn-tool btn-dialog-delete deleteDialog"
                                                                data-id="{{ $item->id }}"
                                                                data-title="{{ trans('message.confirm_delete_customer_dialog') }}"
                                                                data-url="{{ route('customer.deleteDialog', ['id' => $item->id]) }}"
                                                                data-method="DELETE" data-icon="question">
                                                                <i class="fas fa-trash"></i>
                                                                {{ trans('language.delete') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body dialog-content">
                                                        <div class="collapse multi-collapse pb-2 {{ $errors->first('content_' . $item->id) ? 'show' : '' }}"
                                                            id="multiCollapseExample{{ $item->id }}">
                                                            <form
                                                                action="{{ route('customer.updateDialog', ['id' => $item->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" value="{{ $item->id }}"
                                                                    name="id_dialog">
                                                                <textarea class="summernote_{{ $key }} edit-dialog" name="content_{{ $item->id }}">{{ $item->content }}</textarea>
                                                                @if ($errors->first('content_' . $item->id))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('content_' . $item->id) }}
                                                                    </div>
                                                                @endif
                                                                <div class="d-flex justify-content-end">
                                                                    <button class="btn btn-success btn-sm mr-1"
                                                                        type="button" data-toggle="collapse"
                                                                        data-target="#multiCollapseExample{{ $item->id }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="multiCollapseExample{{ $item->id }}">{{ trans('language.close') }}</button>
                                                                    <button class="btn btn-primary btn-sm"
                                                                        type="submit">{{ trans('language.save') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        {!! $item->content !!}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <span>{{ trans('language.no-data') }}</span>
                                        @endif

                                        <div>
                                            <div class="text-center">
                                                {{ $dialogs->links('pagination::bootstrap-4') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        {{-- service --}}
        @include('partials.form-edit-customer-service', [
            'customer' => $customer,
            'services' => $services,
            'list_services' => $list_services
        ])
    </section>
@endsection

@section('js')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/customer_dialog.js') }}"></script>
@endsection
