@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.householder.add'),
        'middle_page' => trans('language.householder.title'),
        'current_page' => trans('language.householder.add'),
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('householder.store') }}" method="post" enctype="multipart/form-data"
                          id="form-householder">
                        @csrf
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                           href="#custom-tabs-four-home" role="tab"
                                           aria-controls="custom-tabs-four-home"
                                           aria-selected="true">{{ trans('language.householder.info') }}
                                            @if ($infoTabHasErrors)
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
                                                        <label>{{ trans('language.householder.name') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name"
                                                               value="{{ old('name') ?? '' }}"
                                                               placeholder="{{ trans('language.householder.name') }}">
                                                        @if ($errors->first('name'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- image_path --}}

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.householder.description') }}</label>
                                                        <input type="text" class="form-control" name="description"
                                                               value="{{ old('description') ?? '' }}"
                                                               placeholder="{{ trans('language.householder.description') }}">
                                                        @if ($errors->first('description'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('description') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.householder.image_path') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" class="form-control" id="image_path"
                                                               name="image_path">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <img id="img" src="" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.householder.tax_code') }}</label>
                                                        <input type="text" class="form-control" name="tax_code"
                                                               value="{{ old('tax_code') ?? '' }}"
                                                               placeholder="{{ trans('language.householder.tax_code') }}">
                                                        @if ($errors->first('tax_code'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('tax_code') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.householder.address') }}</label>
                                                        <input type="text" class="form-control" name="address"
                                                               value="{{ old('address') ?? '' }}"
                                                               placeholder="{{ trans('language.householder.address') }}">
                                                        @if ($errors->first('address'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('address') }}
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.householder.invoice_address') }}</label>
                                                        <input type="text" class="form-control" name="invoice_address"
                                                               value="{{ old('invoice_address') ?? '' }}"
                                                               placeholder="{{ trans('language.householder.invoice_address') }}">
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
                                {{-- <td class="text-center align-middle">
                                    <select class="form-control service_change" name="services[]">
                                        <option selected="selected" value=" ">Dịch vụ</option>
                                        @foreach ($services as $item)
                                            <option @if ($choose_status == $item->id) selected @endif
                                                value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td> --}}
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
                                {{-- <td>
                                    <select class="form-control" name="supplier[]">
                                        <option selected="selected" value=" "></option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td> --}}
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
@endsection
