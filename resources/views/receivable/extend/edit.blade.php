@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.receivable.edit-extend'),
        'middle_page' => trans('language.receivable.title'),
        'current_page' => trans('language.receivable.edit-extend'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('receivable.updateExtend', ['id' => $receivable->id]) }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="receipt1" value="{{isset($receipt1) ? $receipt1->id : null}}">
                                <input type="hidden" name="receipt2" value="{{isset($receipt2) ? $receipt2->id : null}}">
                                <input type="hidden" name="receipt3" value="{{isset($receipt3) ? $receipt3->id : null}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('language.customer.title') }}<span
                                                    class="text-danger">*</span></label>
                                            <select name="customer" id="customer_info" class="form-control select2"
                                                disabled>
                                                @php
                                                    $choose_customer = old('customer') ? old('customer') : $receivable->customer_id;
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('language.receivable.ended_at') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control date-picker" name="ended_at"
                                                value="{{ old('ended_at') ?? date('d/m/Y', strtotime($receivable->ended_at)) }}"
                                                placeholder="{{ trans('language.receivable.ended_at') }}">
                                            @if ($errors->first('ended_at'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('ended_at') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('language.receivable.contract_value') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-price" name="contract_value"
                                                value="{{ old('contract_value') ?? $receivable->contract_value }}"
                                                placeholder="{{ trans('language.receivable.contract_value') }}">
                                            @if ($errors->first('contract_value'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('contract_value') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.title') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="" disabled
                                                value="{{ $receivable->service_name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('language.receivable.advance') }}</label>
                                    <div class="border">
                                        <div class="row pt-10 pr-10 pl-10">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.receivable.advance_value') . ' ' . trans('language.receivable.time_1') }}</label>
                                                    <input type="text" class="form-control input-price"
                                                        name="advance_value_1"
                                                        value="{{ old('advance_value_1') ?? $receivable->advance_value_1 }}"
                                                        placeholder="{{ trans('language.receivable.advance_value') . ' ' . trans('language.receivable.time_1') }}">
                                                    @if ($errors->first('advance_value_1'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('advance_value_1') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.receivable.advance_date') . ' ' . trans('language.receivable.time_1') }}</label>
                                                    <input type="text" class="form-control date-picker"
                                                        name="advance_date_1"
                                                        value="{{ old('advance_date_1') ? old('advance_date_1') : (isset($receivable->advance_date_1) ? date('d/m/Y', strtotime($receivable->advance_date_1)) : null) }}"
                                                        placeholder="{{ trans('language.receivable.advance_date') . ' ' . trans('language.receivable.time_1') }}">
                                                    @if ($errors->first('advance_date_1'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('advance_date_1') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.reason') }}</label>
                                                    <input type="text" class="form-control" name="reason_1"
                                                        value="{{ old('reason_1') ?? $receivable->reason_1 }}"
                                                        placeholder="{{ trans('language.reason') }}">
                                                    @if ($errors->first('reason_1'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('reason_1') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pr-10 pl-10">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.receivable.advance_value') . ' ' . trans('language.receivable.time_2') }}</label>
                                                    <input type="text" class="form-control input-price"
                                                        name="advance_value_2"
                                                        value="{{ old('advance_value_2') ?? $receivable->advance_value_2 }}"
                                                        placeholder="{{ trans('language.receivable.advance_value') . ' ' . trans('language.receivable.time_2') }}">
                                                    @if ($errors->first('advance_value_2'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('advance_value_2') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.receivable.advance_date') . ' ' . trans('language.receivable.time_2') }}</label>
                                                    <input type="text" class="form-control date-picker"
                                                        name="advance_date_2"
                                                        value="{{ old('advance_date_2') ? old('advance_date_2') : (isset($receivable->advance_date_2) ? date('d/m/Y', strtotime($receivable->advance_date_2)) : null) }}"
                                                        placeholder="{{ trans('language.receivable.advance_date') . ' ' . trans('language.receivable.time_2') }}">
                                                    @if ($errors->first('advance_date_2'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('advance_date_2') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.reason') }}</label>
                                                    <input type="text" class="form-control" name="reason_2"
                                                        value="{{ old('reason_2') ?? $receivable->reason_2 }}"
                                                        placeholder="{{ trans('language.reason') }}">
                                                    @if ($errors->first('reason_2'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('reason_2') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pr-10 pl-10">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.receivable.advance_value') . ' ' . trans('language.receivable.time_3') }}</label>
                                                    <input type="text" class="form-control input-price"
                                                        name="advance_value_3"
                                                        value="{{ old('advance_value_3') ?? $receivable->advance_value_3 }}"
                                                        placeholder="{{ trans('language.receivable.advance_value') . ' ' . trans('language.receivable.time_3') }}">
                                                    @if ($errors->first('advance_value_3'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('advance_value_3') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.receivable.advance_date') . ' ' . trans('language.receivable.time_3') }}</label>
                                                    <input type="text" class="form-control date-picker"
                                                        name="advance_date_3"
                                                        value="{{ old('advance_date_3') ? old('advance_date_3') : (isset($receivable->advance_date_3) ? date('d/m/Y', strtotime($receivable->advance_date_3)) : null) }}"
                                                        placeholder="{{ trans('language.receivable.advance_date') . ' ' . trans('language.receivable.time_3') }}">
                                                    @if ($errors->first('advance_date_3'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('advance_date_3') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.reason') }}</label>
                                                    <input type="text" class="form-control" name="reason_3"
                                                        value="{{ old('reason_3') ?? $receivable->reason_3 }}"
                                                        placeholder="{{ trans('language.reason') }}">
                                                    @if ($errors->first('reason_3'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('reason_3') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pr-10 pl-10">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ trans('language.receivable.total_advance') }}</label>
                                                    <input type="text" class="form-control input-price" disabled
                                                        name="total_advance" value="{{ $total_advance }}"
                                                        placeholder="{{ trans('language.receivable.total_advance') }}">
                                                    <input type="hidden" name="total_advance_hidden">
                                                    @if ($errors->first('total_advance_hidden'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('total_advance_hidden') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ trans('language.receivable.amount_owed') }}</label>
                                                    <input type="text" class="form-control input-price" disabled
                                                        name="amount_owed" value="{{ $receivable->amount_owed }}"
                                                        placeholder="{{ trans('language.receivable.amount_owed') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.receivable.note') }}</label>
                                            <textarea class="summernote" name="note">{{ old('note') ?? $receivable->note }}</textarea>
                                            @if ($errors->first('note'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('note') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ trans('language.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/edit_receivable.js') }}"></script>
@endsection
