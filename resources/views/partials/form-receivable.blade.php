<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>{{ trans('language.service.title') }}</label>
                <input type="text" class="form-control date-picker" name="service" disabled value="{{ $service->name }}">
                <input type="hidden" name="service_id[]" value="{{ $service->id }}">
                <input type="hidden" name="service_name[]" value="{{ $service->name }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>{{ trans('language.receivable.ended_at') }}<span class="text-danger">*</span></label>
                <input type="text" class="form-control date-picker" name="ended_at[]" disabled
                    value="{{ date('d/m/Y', strtotime($service->ended_at)) }}"
                    placeholder="{{ trans('language.receivable.ended_at') }}">
                <input type="hidden" name="ended_at[]" value="{{ date('d/m/Y', strtotime($service->ended_at)) }}">
                @if ($errors->first('ended_at'))
                    <div class="invalid-alert text-danger">
                        {{ $errors->first('ended_at') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>{{ trans('language.receivable.contract_value') }}<span class="text-danger">*</span></label>
                <input type="text" class="form-control input-price" disabled
                    value="{{ old('contract_value') ?? number_format($service->subtotal) }}"
                    placeholder="{{ trans('language.receivable.contract_value') }}">
                <input type="hidden" name="contract_value[]" value="{{ number_format($service->subtotal) }}">
                @if ($errors->first('contract_value'))
                    <div class="invalid-alert text-danger">
                        {{ $errors->first('contract_value') }}
                    </div>
                @endif
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
                        <input type="text" class="form-control input-price" name="advance_value_1[]"
                            value="{{ old('advance_value_1') ?? '' }}"
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
                        <input type="text" class="form-control date-picker" name="advance_date_1[]"
                            value="{{ old('advance_date_1') ?? '' }}"
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
                        <input type="text" class="form-control" name="reason_1[]"
                            value="{{ old('reason_1') ?? '' }}"
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
                        <input type="text" class="form-control input-price" name="advance_value_2[]"
                            value="{{ old('advance_value_2') ?? '' }}"
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
                        <input type="text" class="form-control date-picker" name="advance_date_2[]"
                            value="{{ old('advance_date_2') ?? '' }}"
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
                        <input type="text" class="form-control" name="reason_2[]"
                            value="{{ old('reason_2') ?? '' }}"
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
                        <input type="text" class="form-control input-price" name="advance_value_3[]"
                            value="{{ old('advance_value_3') ?? '' }}"
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
                        <input type="text" class="form-control date-picker" name="advance_date_3[]"
                            value="{{ old('advance_date_3') ?? '' }}"
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
                        <input type="text" class="form-control" name="reason_3[]"
                            value="{{ old('reason_3') ?? '' }}"
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
                        <input type="text" class="form-control" disabled name="total_advance" value=""
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
                        <input type="text" class="form-control" disabled name="amount_owed" value=""
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
                <textarea class="summernote" name="note[]">{{ old('note') ?? '' }}</textarea>
                @if ($errors->first('note'))
                    <div class="invalid-alert text-danger">
                        {{ $errors->first('note') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
