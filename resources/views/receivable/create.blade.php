@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.receivable.new'),
        'middle_page' => trans('language.receivable.title'),
        'current_page' => trans('language.receivable.new'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form id="form_submit" action="{{ route('receivable.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            @dd($customers)
                                            <label>{{ trans('language.customer.title') }}<span
                                                    class="text-danger">*</span></label>
                                            <select name="customer" id="customer_info" class="form-control select2">
                                                @php
                                                    $choose_customer = old('customer') ? old('customer') : '';
                                                @endphp
                                                <option value=""></option>
                                                @foreach ($customers as $customer)
                                                    <option @if ($choose_customer == $customer->id) selected @endif
                                                        data-name="{{ $customer->name }}" value="{{ $customer->id }}">
                                                        {{ $customer->code }} </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->first('customer'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('customer') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.title') }}<span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="list_service" class="form-control"
                                                multiple="multiple">

                                            </select>
                                            @if ($errors->first('signed_date'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('signed_date') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" id="add_form"
                                                class="btn btn-block btn-info">{{ trans('language.receivable.add_form') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (request()->old())
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <div class="row" id="form-receivable-add">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="nav_receivable" role="tablist">
                                                @for ($i = 0; $i < count(old('service_id', [])); $i++)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $i == 0 ? 'active' : '' }}"
                                                            id="nav_{{ old('service_id.' . $i) }}" data-toggle="pill"
                                                            href="#tab_{{ old('service_id.' . $i) }}" role="tab"
                                                            aria-controls="tab_{{ old('service_id.' . $i) }}"
                                                            aria-selected="true">{{ old('service_name.' . $i) }}
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="tab_receivable">
                                        @for ($i = 0; $i < count(old('service_id', [])); $i++)
                                            <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}"
                                                id="tab_{{ old('service_id.' . $i) }}" role="tabpanel"
                                                aria-labelledby="tab_{{ old('service_id.' . $i) }}-tab">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Dịch vụ</label>
                                                                <input type="text" class="form-control date-picker"
                                                                    name="service" disabled="" value="Lập trình web">
                                                                <input type="hidden" name="service_id[]"
                                                                    value="{{ old('service_id.' . $i) }}">
                                                                <input type="hidden" name="service_name[]"
                                                                    value="{{ old('service_name.' . $i) }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Ngày kết thúc
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" class="form-control date-picker"
                                                                    name="" disabled
                                                                    value="{{ old('ended_at.' . $i) }}"
                                                                    placeholder="Ngày kết thúc">
                                                                <input type="hidden" name="ended_at[]"
                                                                    value="{{ old('ended_at.' . $i) }}">
                                                                @if ($errors->first('ended_at.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('ended_at.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Tổng giá trị <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control input-price"
                                                                    name="" disabled
                                                                    value="{{ old('contract_value.' . $i) }}"
                                                                    placeholder="Tổng giá trị ">
                                                                <input type="hidden" name="contract_value[]"
                                                                    value="{{ old('contract_value.' . $i) }}">
                                                                @if ($errors->first('contract_value.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('contract_value.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Tạm ứng</label>
                                                        <div class="border">
                                                            <div class="row pt-10 pr-10 pl-10">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Số tiền tạm ứng lần 1</label>
                                                                        <input type="text"
                                                                            class="form-control input-price"
                                                                            name="advance_value_1[]"
                                                                            value="{{ old('advance_value_1.' . $i) }}"
                                                                            placeholder="Số tiền tạm ứng lần 1">
                                                                        @if ($errors->first('advance_value_1.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('advance_value_1.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Ngày tạm ứng lần 1</label>
                                                                        <input type="text"
                                                                            class="form-control date-picker"
                                                                            name="advance_date_1[]"
                                                                            value="{{ old('advance_date_1.' . $i) }}"
                                                                            placeholder="Ngày tạm ứng lần 1">
                                                                        @if ($errors->first('advance_date_1.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('advance_date_1.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Lý do</label>
                                                                        <input type="text"
                                                                            class="form-control"
                                                                            name="reason_1[]"
                                                                            value="{{ old('reason_1.' . $i) }}"
                                                                            placeholder="Lý do">
                                                                        @if ($errors->first('reason_1.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('reason_1.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-10 pl-10">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Số tiền tạm ứng lần 2</label>
                                                                        <input type="text"
                                                                            class="form-control input-price"
                                                                            name="advance_value_2[]"
                                                                            value="{{ old('advance_value_2.' . $i) }}"
                                                                            placeholder="Số tiền tạm ứng lần 2">
                                                                        @if ($errors->first('advance_value_2.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('advance_value_2.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Ngày tạm ứng lần 2</label>
                                                                        <input type="text"
                                                                            class="form-control date-picker"
                                                                            name="advance_date_2[]"
                                                                            value="{{ old('advance_date_2.' . $i) }}"
                                                                            placeholder="Ngày tạm ứng lần 2">
                                                                        @if ($errors->first('advance_date_2.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('advance_date_2.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Lý do</label>
                                                                        <input type="text"
                                                                            class="form-control"
                                                                            name="reason_2[]"
                                                                            value="{{ old('reason_2.' . $i) }}"
                                                                            placeholder="Lý do">
                                                                        @if ($errors->first('reason_2.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('reason_2.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-10 pl-10">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Số tiền tạm ứng lần 3</label>
                                                                        <input type="text"
                                                                            class="form-control input-price"
                                                                            name="advance_value_3[]"
                                                                            value="{{ old('advance_value_3.' . $i) }}"
                                                                            placeholder="Số tiền tạm ứng lần 3">
                                                                        @if ($errors->first('advance_value_3.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('advance_value_3.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Ngày tạm ứng lần 3</label>
                                                                        <input type="text"
                                                                            class="form-control date-picker"
                                                                            name="advance_date_3[]"
                                                                            value="{{ old('advance_date_3.' . $i) }}"
                                                                            placeholder="Ngày tạm ứng lần 3">
                                                                        @if ($errors->first('advance_date_3.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('advance_date_3.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Lý do</label>
                                                                        <input type="text"
                                                                            class="form-control"
                                                                            name="reason_3[]"
                                                                            value="{{ old('reason_3.' . $i) }}"
                                                                            placeholder="Lý do">
                                                                        @if ($errors->first('reason_3.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('reason_3.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-10 pl-10">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Tổng tiền tạm ứng</label>
                                                                        <input type="text" class="form-control"
                                                                            disabled="" name="total_advance"
                                                                            value=""
                                                                            placeholder="Tổng tiền tạm ứng">
                                                                        <input type="hidden" name="total_advance_hidden">
                                                                        @if ($errors->first('total_advance_hidden.' . $i))
                                                                            <div class="invalid-alert text-danger">
                                                                                {{ $errors->first('total_advance_hidden.' . $i) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Còn lại</label>
                                                                        <input type="text" class="form-control"
                                                                            disabled="" name="amount_owed"
                                                                            value="" placeholder="Còn lại">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{ trans('language.receivable.note') }}</label>
                                                                <textarea class="summernote" name="note[]">{{ old('note.' . $i) ?? '' }}</textarea>
                                                                @if ($errors->first('note'))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('note') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">{{ trans('language.save') }}</button>
                                </div>
                            </div>
                        @else
                            <div class="card card-primary card-outline card-outline-tabs form-add d-none">
                                <div class="card-header p-0 border-bottom-0">
                                    <div class="row" id="form-receivable-add">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="nav_receivable" role="tablist">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="tab_receivable">
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">{{ trans('language.save') }}</button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/create_receivable.js') }}"></script>
@endsection
