@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.customer.add'),
        'middle_page' => trans('language.customer.title'),
        'current_page' => trans('language.customer.add'),
    ])

    @php
        $serviceTabHasErrors =
            $errors->has('services.*') ||
            $errors->has('time.*') ||
            $errors->has('start.*') ||
            $errors->has('end.*') ||
            $errors->has('view_total.*') ||
            $errors->has('note.*') ||
            $errors->has('supplier.*');
        $infoTabHasErrors =
            $errors->has('name') ||
            $errors->has('responsible_person') ||
            $errors->has('tax_code') ||
            $errors->has('status') ||
            $errors->has('email') ||
            $errors->has('phone') ||
            $errors->has('address') ||
            $errors->has('invoice_address') ||
            $errors->has('career');
    @endphp

    <style>
        @supports (-webkit-appearance: none) or (-moz-appearance: none) {
            .checkbox-wrapper-14 input[type=checkbox] {
                --active: #275EFE;
                --active-inner: #fff;
                --focus: 2px rgba(39, 94, 254, .3);
                --border: #BBC1E1;
                --border-hover: #275EFE;
                --background: #fff;
                --disabled: #F6F8FF;
                --disabled-inner: #E1E6F9;
                -webkit-appearance: none;
                -moz-appearance: none;
                height: 21px;
                outline: none;
                display: inline-block;
                vertical-align: top;
                position: relative;
                margin: 0;
                cursor: pointer;
                border: 1px solid var(--bc, var(--border));
                background: var(--b, var(--background));
                transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
            }

            .checkbox-wrapper-14 input[type=checkbox]:after {
                content: "";
                display: block;
                left: 0;
                top: 0;
                position: absolute;
                transition: transform var(--d-t, 0.3s) var(--d-t-e, ease), opacity var(--d-o, 0.2s);
            }

            .checkbox-wrapper-14 input[type=checkbox]:checked {
                --b: var(--active);
                --bc: var(--active);
                --d-o: .3s;
                --d-t: .6s;
                --d-t-e: cubic-bezier(.2, .85, .32, 1.2);
            }

            .checkbox-wrapper-14 input[type=checkbox]:disabled {
                --b: var(--disabled);
                cursor: not-allowed;
                opacity: 0.9;
            }

            .checkbox-wrapper-14 input[type=checkbox]:disabled:checked {
                --b: var(--disabled-inner);
                --bc: var(--border);
            }

            .checkbox-wrapper-14 input[type=checkbox]:disabled+label {
                cursor: not-allowed;
            }

            .checkbox-wrapper-14 input[type=checkbox]:hover:not(:checked):not(:disabled) {
                --bc: var(--border-hover);
            }

            .checkbox-wrapper-14 input[type=checkbox]:focus {
                box-shadow: 0 0 0 var(--focus);
            }

            .checkbox-wrapper-14 input[type=checkbox]:not(.switch) {
                width: 21px;
            }

            .checkbox-wrapper-14 input[type=checkbox]:not(.switch):after {
                opacity: var(--o, 0);
            }

            .checkbox-wrapper-14 input[type=checkbox]:not(.switch):checked {
                --o: 1;
            }

            .checkbox-wrapper-14 input[type=checkbox]+label {
                display: inline-block;
                vertical-align: middle;
                cursor: pointer;
                margin-left: 4px;
            }

            .checkbox-wrapper-14 input[type=checkbox]:not(.switch) {
                border-radius: 7px;
            }

            .checkbox-wrapper-14 input[type=checkbox]:not(.switch):after {
                width: 5px;
                height: 9px;
                border: 2px solid var(--active-inner);
                border-top: 0;
                border-left: 0;
                left: 7px;
                top: 4px;
                transform: rotate(var(--r, 20deg));
            }

            .checkbox-wrapper-14 input[type=checkbox]:not(.switch):checked {
                --r: 43deg;
            }

            .checkbox-wrapper-14 input[type=checkbox].switch {
                width: 38px;
                border-radius: 11px;
            }

            .checkbox-wrapper-14 input[type=checkbox].switch:after {
                left: 2px;
                top: 2px;
                border-radius: 50%;
                width: 17px;
                height: 17px;
                background: var(--ab, var(--border));
                transform: translateX(var(--x, 0));
            }

            .checkbox-wrapper-14 input[type=checkbox].switch:checked {
                --ab: var(--active-inner);
                --x: 17px;
            }

            .checkbox-wrapper-14 input[type=checkbox].switch:disabled:not(:checked):after {
                opacity: 0.6;
            }
        }

        .checkbox-wrapper-14 * {
            box-sizing: inherit;
        }

        .checkbox-wrapper-14 *:before,
        .checkbox-wrapper-14 *:after {
            box-sizing: inherit;
        }

        /*.contractDateContent,*/
        /*.contractDateInput {*/
        /*    display: none;*/
        /*}*/
    </style>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('customer.store') }}" method="post" enctype="multipart/form-data"
                        id="form-customer">
                        @csrf
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                            href="#custom-tabs-four-home" role="tab"
                                            aria-controls="custom-tabs-four-home"
                                            aria-selected="true">{{ trans('language.customer.info') }}
                                            @if ($infoTabHasErrors)
                                                <i class="fas fa-circle text-red"></i>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                            href="#custom-tabs-four-profile" role="tab"
                                            aria-controls="custom-tabs-four-profile"
                                            aria-selected="false">{{ trans('language.customer.document') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $serviceTabHasErrors ? '' : 'd-none' }}"
                                            id="custom-tabs-four-messages-tab" data-toggle="pill"
                                            href="#custom-tabs-four-messages" role="tab"
                                            aria-controls="custom-tabs-four-messages"
                                            aria-selected="false">{{ trans('language.service.title') }}
                                            @if ($serviceTabHasErrors)
                                                <i class="fas fa-circle text-red"></i>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-home-tab">
                                        <div class="card-body">
                                            <div class="checkbox-wrapper-14">
                                                <input id="s1-14" type="checkbox" class="switch" name="type"
                                                    value="{{ old('type') ?? 1 }}" {{ old('type') == 1 ? 'checked' : '' }}>
                                                <label for="s1-14">Công ty/Tổ chức</label>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.name') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ old('name') ?? '' }}"
                                                            placeholder="{{ trans('language.customer.name') }}">
                                                        @if ($errors->first('name'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.staff') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control select2" name="user_id" id="user_id">
                                                            <option selected="selected" value=" ">
                                                                Nhân viên
                                                            </option>
                                                            @php
                                                                $choose_staff = old('user_id') ? old('user_id') : '';
                                                            @endphp
                                                            @foreach ($staff as $item)
                                                                <option @if ($choose_staff == $item->id) selected @endif
                                                                    value="{{ $item->id }}">{{ $item->first_name }}
                                                                    {{ $item->last_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->first('user_id'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('user_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.banner.image_path') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" class="form-control" id="image_path"
                                                            name="image_path">
                                                    </div>
                                                    <div class="form-group">
                                                        <img id="img" src="" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 checkTypeCustomer">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.responsible_person') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="responsible_person"
                                                            value="{{ old('responsible_person') ?? '' }}"
                                                            placeholder="{{ trans('language.customer.responsible_person') }}">
                                                        @if ($errors->first('responsible_person'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('responsible_person') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.tax_code') }}</label>
                                                        <input type="text" class="form-control" name="tax_code"
                                                            value="{{ old('tax_code') ?? '' }}"
                                                            placeholder="{{ trans('language.customer.tax_code') }}">
                                                        @if ($errors->first('tax_code'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('tax_code') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.status') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control select2" name="status"
                                                            id="status">
                                                            <option selected="selected" value=" ">Tình trạng
                                                            </option>
                                                            @php
                                                                $choose_status = old('status') ? old('status') : '';
                                                            @endphp
                                                            @foreach ($status as $item)
                                                                <option @if ($choose_status == $item->id) selected @endif
                                                                    value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->first('status'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('status') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.email') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="email"
                                                            value="{{ old('email') ?? '' }}"
                                                            placeholder="{{ trans('language.email') }}">
                                                        @if ($errors->first('email'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('email') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.phone') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="phone"
                                                            value="{{ old('phone') ?? '' }}"
                                                            placeholder="{{ trans('language.phone') }}">
                                                        @if ($errors->first('phone'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('phone') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">{{ __('language.area.city_id') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select name="city_id" id="city_register"
                                                            data-url="{{ route('ajax.address.districts') }}"
                                                            class="form-control">
                                                            <option value="">--{{ __('language.area.city_id') }}--
                                                            </option>
                                                            @foreach (App\Models\City::all() as $i)
                                                                <option value="{{ $i->id }}">{{ $i->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->first('city_id'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('city_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">{{ __('language.area.district_id') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select name="district_id" id="district_register"
                                                            class="form-control"
                                                            data-url="{{ route('ajax.address.communes') }}">
                                                            <option value="">
                                                                --{{ __('language.area.district_id') }}--</option>
                                                        </select>
                                                        @if ($errors->first('district_id'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('district_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">{{ __('language.area.commune_id') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select name="commune_id" id="commune_register"
                                                            class="w-100 form-control">
                                                            <option value="">
                                                                --{{ __('language.area.commune_id') }}--</option>
                                                        </select>
                                                        @if ($errors->first('commune_id'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('commune_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.address') }}</label>
                                                        <input type="text" class="form-control" name="address"
                                                            id="address" value="{{ old('address') ?? '' }}"
                                                            placeholder="{{ trans('language.customer.address') }}">
                                                        @if ($errors->first('address'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('address') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>





                                                <style>
                                                    .checkbox-wrapper-59 input[type="checkbox"] {
                                                        visibility: hidden;
                                                        display: none;
                                                    }

                                                    .checkbox-wrapper-59 *,
                                                    .checkbox-wrapper-59 ::after,
                                                    .checkbox-wrapper-59 ::before {
                                                        box-sizing: border-box;
                                                    }

                                                    .checkbox-wrapper-59 .switch {
                                                        width: 60px;
                                                        height: 30px;
                                                        position: relative;
                                                        display: inline-block;
                                                    }

                                                    .checkbox-wrapper-59 .slider {
                                                        position: absolute;
                                                        top: 0;
                                                        bottom: 0;
                                                        left: 0;
                                                        right: 0;
                                                        border-radius: 30px;
                                                        box-shadow: 0 0 0 2px #777, 0 0 4px #777;
                                                        cursor: pointer;
                                                        border: 4px solid transparent;
                                                        overflow: hidden;
                                                        transition: 0.2s;
                                                    }

                                                    .checkbox-wrapper-59 .slider:before {
                                                        position: absolute;
                                                        content: "";
                                                        width: 100%;
                                                        height: 100%;
                                                        background-color: #777;
                                                        border-radius: 30px;
                                                        transform: translateX(-56px);
                                                        transition: 0.2s;
                                                    }

                                                    .checkbox-wrapper-59 input:checked+.slider:before {
                                                        transform: translateX(4px);
                                                        background-color: limeGreen;
                                                    }

                                                    .checkbox-wrapper-59 input:checked+.slider {
                                                        box-shadow: 0 0 0 2px limeGreen, 0 0 8px limeGreen;
                                                    }
                                                </style>



                                                <div class="col-md-2">
                                                    <label for="">Sử dụng địa chỉ đã chọn</label>
                                                    <div
                                                        class="checkbox-wrapper-59 d-flex justify-content-center align-items-center">
                                                        <label class="switch">
                                                            <input type="checkbox" id="copy_address_checkbox">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                </div>



                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.invoice_address') }}</label>
                                                        <input type="text" class="form-control" name="invoice_address"
                                                            id="invoice_address"
                                                            value="{{ old('invoice_address') ?? '' }}"
                                                            placeholder="{{ trans('language.customer.invoice_address') }}">
                                                        @if ($errors->first('invoice_address'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('invoice_address') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-profile-tab">

                                        <div class="dropzone" id="customerDropzone">
                                            <div class="fallback">
                                                <input type="file" name="file" multiple />
                                            </div>
                                            <div class="dz-message">
                                                <span>Tải lên file khách hàng</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-messages-tab">

                                        <table class="table table-bordered" id="table_service">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">#</th>
                                                    <th class="text-center align-middle w-15">
                                                        {{ trans('language.service.title') }}
                                                    </th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.contract_date') }}
                                                    </th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.started_at') }}
                                                    </th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.ended_at') }}</th>
                                                    <th class="text-center align-middle th-time-dell">
                                                        {{ trans('language.subtotal') }}
                                                    </th>
                                                    <th class="text-center align-middle w-15">
                                                        {{ trans('language.customer.staff') }}
                                                    </th>
                                                    <th class="text-center align-middle w-10">
                                                        {{ trans('language.type') }}
                                                    </th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.note') }}
                                                    </th>
                                                    <th class="text-center align-middle"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if (request()->old())
                                                    @for ($i = 0; $i < count(old('services', [])); $i++)
                                                        <tr>
                                                            <td class="text-center align-middle">1</td>
                                                            <td class="text-center align-middle">
                                                                <select class="form-control select2 service_change"
                                                                    name="services[]">
                                                                    <option value=" ">Dịch vụ</option>
                                                                    @foreach ($services as $item)
                                                                        <option
                                                                            @if (old('services.' . $i) == $item->id) selected @endif
                                                                            value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->first('services.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('services.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <input name="contract_date[]" type="text"
                                                                    value="{{ old('contract_date.' . $i) }}"
                                                                    class="datepicker_start form-control text-center contractDateInput">
                                                            </td>
                                                            <td class="text-center">
                                                                <input name="start[]" type="text"
                                                                    class="datepicker_start started_date form-control text-center"
                                                                    value="{{ old('start.' . $i) }}">
                                                                @if ($errors->first('start.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('start.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <input name="end[]" type="text"
                                                                    class="datepicker_end ended_date form-control text-center"
                                                                    value="{{ old('end.' . $i) }}">
                                                                @if ($errors->first('end.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('end.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <input type="text" name="view_total[]"
                                                                    class="form-control view-total"
                                                                    value="{{ old('view_total.' . $i) }}">
                                                                <input type="hidden" name="subtotal[]"
                                                                    value="{{ old('subtotal.' . $i) }}">
                                                                <input type="hidden" class="price_ser"
                                                                    name="price_ser[]"
                                                                    value="{{ old('price_ser.' . $i) }}">
                                                                @if ($errors->first('view_total.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('view_total.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            @if ($errors->first('user_id'))
                                                                <div class="invalid-alert text-danger">
                                                                    {{ $errors->first('user_id') }}
                                                                </div>
                                                            @endif
                                                            <td>
                                                                <select class="form-control select2" name="user_id">
                                                                    <option selected="selected" value=" ">
                                                                        Nhân viên
                                                                    </option>
                                                                    @php
                                                                        $choose_staff = old('user_id')
                                                                            ? old('user_id')
                                                                            : '';
                                                                    @endphp
                                                                    @foreach ($staff as $item)
                                                                        <option
                                                                            @if (old('user_id.' . $i) == $item->id) selected @endif
                                                                            value="{{ $item->id }}">
                                                                            {{ $item->first_name }}
                                                                            {{ $item->last_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->first('user_id.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('user_id.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <select class="form-control select2 status-dell typeOrder"
                                                                    name="typeCustomerService[]">
                                                                    <option selected disabled>--Chọn--</option>
                                                                    <option value="1"
                                                                        {{ collect(old('typeCustomerService.' . $i))->contains(1) ? 'selected' : '' }}>
                                                                        Giữ chỗ
                                                                    </option>
                                                                    <option value="2"
                                                                        {{ collect(old('typeCustomerService.' . $i))->contains(2) ? 'selected' : '' }}>
                                                                        Đã cọc
                                                                    </option>
                                                                    <option value="3"
                                                                        {{ collect(old('typeCustomerService.' . $i))->contains(3) ? 'selected' : '' }}>
                                                                        Đã thuê
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="note[]" class="form-control"
                                                                    value="{{ old('note.' . $i) }}">
                                                                @if ($errors->first('note.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('note.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($i == 0)
                                                                    <button style="border-radius:50%" type="button"
                                                                        id="plus_record" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                @else
                                                                    <button style="border-radius:50%" type="button"
                                                                        class="btn btn-danger btn-sm minus_record"><i
                                                                            class="fas fa-minus"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                @else
                                                    <tr class="booking-box">
                                                        <td class="text-center align-middle">1</td>
                                                        <td class="text-center align-middle">
                                                            <select class="form-control select2 service_change services_id"
                                                                name="services[]">
                                                                <option selected="selected" value=" ">Dịch vụ
                                                                </option>
                                                                @foreach ($services as $item)
                                                                    <option
                                                                        @if ($choose_status == $item->id) selected @endif
                                                                        value="{{ $item->id }}">{{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->first('services[]'))
                                                                <div class="invalid-alert text-danger">
                                                                    {{ $errors->first('services[]') }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <input name="contract_date[]" type="text"
                                                                class="datepicker_start form-control text-center contractDateInput">
                                                        </td>
                                                        <td class="text-center">
                                                            <input name="start[]" type="text"
                                                                class="datepicker_start started_date form-control text-center">
                                                        </td>
                                                        <td class="text-center">
                                                            <input name="end[]" type="text"
                                                                class="datepicker_end ended_date form-control text-center">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" name="view_total[]"
                                                                class="form-control view-total" value="">
                                                            <input type="hidden" name="subtotal[]" value="">
                                                            <input type="hidden" class="price_ser" name="price_ser[]"
                                                                value="">
                                                        </td>
                                                        <td>
                                                            <select class="form-control select2" name="user_id[]">
                                                                <option selected disabled>--Chọn--</option>
                                                                @foreach ($staff as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->first_name }}
                                                                        {{ $item->last_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control select2 status-dell typeOrder"
                                                                name="typeCustomerService[]">
                                                                <option selected disabled>--Chọn--</option>
                                                                <option value="1">Giữ chỗ</option>
                                                                <option value="2">Đã cọc</option>
                                                                <option value="3">Đã thuê</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="note[]" class="form-control">
                                                        </td>
                                                        <td>
                                                            <button style="border-radius:50%" type="button"
                                                                id="plus_record" class="btn btn-success btn-sm">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" data-url="{{ route('customer.checkDateAndTypeByService') }}"
                                    data-method="POST" class="btn btn-primary btnSave"
                                    id="btnSave">{{ trans('language.save') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="d-none" id="clone_tr">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="text-center align-middle">1</td>
                                    <td class="text-center align-middle">
                                        <select class="form-control service_change services_id" name="services[]">
                                            <option selected="selected" value=" ">Dịch vụ</option>
                                            @foreach ($services as $item)
                                                <option @if ($choose_status == $item->id) selected @endif
                                                    value="{{ $item->id }}">{{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="">
                                        <input name="contract_date[]" type="text"
                                            class="datepicker_start form-control text-center contractDateInput">
                                    </td>
                                    <td class="text-center">
                                        <input name="start[]" type="text"
                                            class="datepicker_start started_date form-control text-center">
                                    </td>
                                    <td class="text-center">
                                        <input name="end[]" type="text"
                                            class="datepicker_end ended_date form-control text-center">
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="text" name="view_total[]" class="form-control view-total"
                                            value="">
                                        <input type="hidden" name="subtotal[]" value="">
                                        <input type="hidden" class="price_ser" name="price_ser[]" value="">
                                    </td>
                                    <td>
                                        <select class="form-control" name="user_id[]">
                                            <option selected disabled>--Chọn--</option>
                                            @foreach ($staff as $item)
                                                <option value="{{ $item->id }}">{{ $item->first_name }}
                                                    {{ $item->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control status-dell typeOrder" name="typeCustomerService[]">
                                            <option selected disabled>--Chọn--</option>
                                            <option value="1">Đã giữ chỗ</option>
                                            <option value="2">Đã cọc</option>
                                            <option value="3">Đã thuê</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="note[]" class="form-control">
                                    </td>
                                    <td class="text-center align-middle">
                                        <button style="border-radius:50%" type="button"
                                            class="btn btn-danger btn-sm minus_record"><i class="fas fa-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/customer.js') }}"></script>

    <script>
        function formatDate(dateStr) {
            var parts = dateStr.split('/');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }

        $('#btnSave').on('click', function(e) {
            e.preventDefault();

            let url = $(this).data('url');
            let method = $(this).data('method');
            let form = $(this).closest('form');

            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');

            let bookings = [];
            $('.booking-box').each(function(index) {
                let serviceId = $(this).find('.service_change').val();
                let startDate = formatDate($(this).find('.started_date').val());
                let endDate = formatDate($(this).find('.ended_date').val());
                let type = $(this).find('.typeOrder').val();

                console.log('Service ID:', serviceId);
                console.log('Start Date:', startDate);
                console.log('End Date:', endDate);
                console.log('Type:', type);

                if (serviceId && startDate && endDate && type) {
                    bookings.push({
                        service_id: serviceId,
                        started_at: startDate,
                        ended_at: endDate,
                        type: type
                    });
                } else {
                    console.error('Một hoặc nhiều giá trị thiếu hoặc không hợp lệ.');
                }
            });

            formData.append('bookings', JSON.stringify(bookings));

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.bookingError == false) {
                        Swal.fire(
                            response.message
                        );
                    } else {
                        form.submit();
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        xhr.message
                    );
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
<script>
    $('#copy_address_checkbox').on('change', function() {
        if ($(this).is(':checked')) {
            var city = $('#city_register option:selected').text();
            var district = $('#district_register option:selected').text();
            var commune = $('#commune_register option:selected').text();
            var address = $('#address').val();

            var combinedAddress = address + ', ' + commune + ', ' + district + ', ' + city;

            $('#invoice_address').val(combinedAddress);
        } else {
            $('#invoice_address').val('');
        }
    });
</script>
@endsection
