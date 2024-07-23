@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.customer.edit'),
        'middle_page' => trans('language.customer.title'),
        'current_page' => trans('language.customer.edit'),
    ])

    @php
        $serviceTabHasErrors = $errors->has('services.*') || $errors->has('time.*') || $errors->has('start.*') || $errors->has('end.*') || $errors->has('view_total.*') || $errors->has('note.*') || $errors->has('supplier.*');
        $infoTabHasErrors = $errors->has('name') || $errors->has('responsible_person') || $errors->has('tax_code') || $errors->has('status') || $errors->has('email') || $errors->has('phone') || $errors->has('address') || $errors->has('invoice_address') || $errors->has('career');

    @endphp

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('customer.update', ['id' => $customer->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="url_previous" value="{{ url()->previous() }}">
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
                                        <a class="nav-link {{ $serviceTabHasErrors || $service_saves->count() > 0 ? '' : 'd-none' }}"
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.name') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ old('name') ?? $customer->name }}"
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
                                                        <label>{{ trans('language.customer.responsible_person') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="responsible_person"
                                                            value="{{ old('responsible_person') ?? $customer->responsible_person }}"
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
                                                            value="{{ old('tax_code') ?? $customer->tax_code }}"
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
                                                        <select class="form-control select2" name="status" id="status">
                                                            <option selected="selected" value=" ">Tình trạng
                                                            </option>
                                                            @php
                                                                $choose_status = old('status') ? old('status') : $customer->status;
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
                                                            value="{{ old('email') ?? $customer->email }}"
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
                                                            value="{{ old('phone') ?? $customer->phone }}"
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.address') }}</label>
                                                        <input type="text" class="form-control" name="address"
                                                            value="{{ old('address') ?? $customer->address }}"
                                                            placeholder="{{ trans('language.customer.address') }}">
                                                        @if ($errors->first('address'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('address') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.invoice_address') }}</label>
                                                        <input type="text" class="form-control" name="invoice_address"
                                                            value="{{ old('invoice_address') ?? $customer->invoice_address }}"
                                                            placeholder="{{ trans('language.customer.invoice_address') }}">
                                                        @if ($errors->first('invoice_address'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('invoice_address') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.career') }}</label>
                                                        <input type="text" class="form-control" name="career"
                                                            value="{{ old('career') ?? $customer->career }}"
                                                            placeholder="{{ trans('language.customer.career') }}">
                                                        @if ($errors->first('career'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('career') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.customer.staff') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control select2" name="user_id" id="user_id">
                                                            <option selected="selected" value=" ">Nhân viên chăm sóc
                                                            </option>
                                                            @php
                                                                $choose_staff = old('user_id') ? old('user_id') : $customer->user_id;
                                                            @endphp
                                                            @foreach ($staff as $item)
                                                                <option @if ($choose_status == $item->id) selected @endif
                                                                    value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }}
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
                                                    <th class="text-center align-middle w-20">
                                                        {{ trans('language.service.title') }}
                                                    </th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.time') }}
                                                    </th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.started_at') }}
                                                    </th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.ended_at') }}</th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.subtotal') }}
                                                    </th>
                                                    <th class="text-center align-middle">
                                                        {{ trans('language.customer.supplier') }}
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
                                                            <td class="d-flex justify-content-center align-items-center">
                                                                <input name="time_view[]"
                                                                    class="form-control form-control-border number-hidden-input text-center input-time"
                                                                    type="number" min="1" max="10000"
                                                                    value="{{ old('time.' . $i) }}"
                                                                    @if (old('time.' . $i) == null) disabled @endif>
                                                                <input type="hidden" name="time[]"
                                                                    value="{{ old('time.' . $i) }}">
                                                                @if ($errors->first('time.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('time.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <input name="start[]" type="text"
                                                                    class="datepicker_start form-control text-center"
                                                                    value="{{ old('start.' . $i) }}">
                                                                @if ($errors->first('start.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('start.' . $i) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <input name="end[]" type="text"
                                                                    class="datepicker_end form-control text-center"
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
                                                            <td>
                                                                <select class="form-control select2" name="supplier[]">
                                                                    <option value=" "></option>
                                                                    @foreach ($suppliers as $item)
                                                                        <option
                                                                            @if (old('supplier.' . $i) == $item->id) selected @endif
                                                                            value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->first('supplier.' . $i))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('supplier.' . $i) }}
                                                                    </div>
                                                                @endif
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
                                                                        id="plus_record" class="btn btn-success btn-sm"><i
                                                                            class="fas fa-plus"></i>
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
                                                    @foreach ($service_saves as $key => $value)
                                                        <tr>
                                                            <td class="text-center align-middle">1</td>
                                                            <td class="text-center align-middle">
                                                                <select class="form-control select2 service_change"
                                                                    name="services[]">
                                                                    <option selected="selected" value=" ">Dịch vụ
                                                                    </option>
                                                                    @foreach ($services as $item)
                                                                        <option
                                                                            @if ($value->service_id == $item->id) selected @endif
                                                                            value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->first('services[]'))
                                                                    <div class="invalid-alert text-danger">
                                                                        {{ $errors->first('services[]') }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="d-flex justify-content-center align-items-center">
                                                                <input name="time_view[]"
                                                                    class="form-control form-control-border number-hidden-input text-center input-time"
                                                                    type="number" min="1" max="10000"
                                                                    value="{{ $value->time }}"
                                                                    {{ $value->time == null ? 'disabled' : '' }}>
                                                                <input type="hidden" name="time[]"
                                                                    value="{{ $value->time }}">
                                                            </td>
                                                            <td class="text-center">
                                                                <input name="start[]" type="text"
                                                                    class="datepicker_start form-control text-center"
                                                                    value="{{ date('d/m/Y', strtotime($value->started_at)) }}">
                                                            </td>
                                                            <td class="text-center">
                                                                <input name="end[]" type="text"
                                                                    class="datepicker_end form-control text-center"
                                                                    value="{{ date('d/m/Y', strtotime($value->ended_at)) }}">
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <input type="text" name="view_total[]"
                                                                    class="form-control view-total"
                                                                    value="{{ number_format($value->subtotal) }}">
                                                                <input type="hidden" name="subtotal[]" value="">
                                                                <input type="hidden" class="price_ser"
                                                                    name="price_ser[]" value="{{ $value->price }}">
                                                            </td>
                                                            <td>
                                                                <select class="form-control select2" name="supplier[]">
                                                                    <option selected="selected" value=" "></option>
                                                                    @foreach ($suppliers as $item)
                                                                        <option @if($item->id == $value->supplier) selected @endif value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="note[]" class="form-control"
                                                                    value="{{ $value->note }}">
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                {{-- <button style="border-radius:50%" type="button"
                                                                    id="plus_record" class="btn btn-success btn-sm">
                                                                    <i class="fas fa-plus"></i>
                                                                </button> --}}
                                                                @if ($key == 0)
                                                                    <button style="border-radius:50%" type="button"
                                                                        id="plus_record" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                @else
                                                                    <button style="border-radius:50%" type="button"
                                                                        class="btn btn-danger btn-sm minus_record">
                                                                        <i class="fas fa-minus"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ trans('language.save') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="d-none" id="clone_tr">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="text-center align-middle">1</td>
                                    <td class="text-center align-middle">
                                        <select class="form-control service_change" name="services[]">
                                            <option selected="selected" value=" ">Dịch vụ</option>
                                            @foreach ($services as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <input name="time_view[]"
                                            class="form-control form-control-border number-hidden-input text-center input-time"
                                            type="number" min="1" max="10000" value="" disabled>
                                        <input type="hidden" name="time[]">
                                    </td>
                                    <td class="text-center">
                                        <input name="start[]" type="text"
                                            class="datepicker_start form-control text-center">
                                    </td>
                                    <td class="text-center">
                                        <input name="end[]" type="text"
                                            class="datepicker_end form-control text-center">
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="text" name="view_total[]" class="form-control view-total"
                                            value="">
                                        <input type="hidden" name="subtotal[]" value="">
                                        <input type="hidden" class="price_ser" name="price_ser[]" value="">
                                    </td>
                                    <td>
                                        <select class="form-control select2 service_change" name="supplier[]">
                                            <option selected="selected" value=" "></option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                </option>
                                            @endforeach
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
                    <input type="hidden" name="files_hidden" value="{{ $files }}">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/customer.js') }}"></script>
@endsection
