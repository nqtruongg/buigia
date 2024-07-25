@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.commission.edit'),
        'middle_page' => trans('language.commission.title'),
        'current_page' => trans('language.commission.edit'),
    ])

    @php
        $serviceTabHasErrors = $errors->has('services.*') || $errors->has('time.*') || $errors->has('start.*') || $errors->has('end.*') || $errors->has('view_total.*') || $errors->has('note.*') || $errors->has('supplier.*');
        $infoTabHasErrors = $errors->has('name') || $errors->has('responsible_person') || $errors->has('tax_code') || $errors->has('status') || $errors->has('email') || $errors->has('phone') || $errors->has('address') || $errors->has('invoice_address') || $errors->has('career');

    @endphp

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('commission.update', ['id' => $commission->id]) }}" method="post"
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
                                            aria-selected="true">{{ trans('language.commission.info') }}
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
                                                        <label>{{ trans('language.commission.name') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ old('name') ?? $commission->name }}"
                                                            placeholder="{{ trans('language.commission.name') }}">
                                                        @if ($errors->first('name'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.commission.percent') }}<span
                                                            class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="percent"
                                                            value="{{ old('percent') ?? $commission->percent }}"
                                                            placeholder="{{ trans('language.commission.percent') }}">
                                                        @if ($errors->first('percent'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('percent') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.commission.min_price') }}<span
                                                            class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="min_price"
                                                            value="{{ old('min_price') ?? $commission->min_price }}"
                                                            placeholder="{{ trans('language.commission.min_price') }}">
                                                        @if ($errors->first('min_price'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('min_price') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.commission.max_price') }}<span
                                                            class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="max_price"
                                                            value="{{ old('max_price') ?? $commission->max_price }}"
                                                            placeholder="{{ trans('language.commission.max_price') }}">
                                                        @if ($errors->first('max_price'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('max_price') }}
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
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    {{-- <script src="{{ asset('dist/js/pages/commission.js') }}"></script> --}}
@endsection
