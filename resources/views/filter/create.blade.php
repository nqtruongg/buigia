@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.filter.add'),
        'middle_page' => trans('language.filter.title'),
        'current_page' => trans('language.filter.add'),
    ])

    @php
        $infoTabHasErrors = $errors->has('name');
    @endphp

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('filter.store') }}" method="post" enctype="multipart/form-data" id="form-filter">
                        @csrf
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                            href="#custom-tabs-four-home" role="tab"
                                            aria-controls="custom-tabs-four-home"
                                            aria-selected="true">{{ trans('language.filter.info') }}
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
                                                        <label>{{ trans('language.filter.filter_type_id') }}<span
                                                                class="text-danger">*</span></label>
                                                                <select class="form-control" name="filter_type_id">
                                                                    <option disabled selected>--Chọn--</option>
                                                                    @foreach($filterTypes as $category)
                                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                        @if ($errors->first('filter_type_id'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('filter_type_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.filter.exact_value') }}</label>
                                                        <input type="text" class="form-control" name="exact_value"
                                                            value="{{ old('exact_value') ?? '' }}"
                                                            placeholder="{{ trans('language.filter.exact_value') }}">
                                                        @if ($errors->first('exact_value'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('exact_value') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.filter.min_value') }}</label>
                                                        <input type="text" class="form-control" name="min_value"
                                                            value="{{ old('min_value') ?? '' }}"
                                                            placeholder="{{ trans('language.filter.min_value') }}">
                                                        @if ($errors->first('min_value'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('min_value') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.filter.max_value') }}</label>
                                                        <input type="text" class="form-control" name="max_value"
                                                            value="{{ old('max_value') ?? '' }}"
                                                            placeholder="{{ trans('language.filter.max_value') }}">
                                                        @if ($errors->first('max_value'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('max_value') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.filter.direction') }}</label>
                                                        <input type="text" class="form-control" name="direction"
                                                            value="{{ old('direction') ?? '' }}"
                                                            placeholder="{{ trans('language.filter.direction') }}">
                                                        @if ($errors->first('direction'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('direction') }}
                                                            </div>
                                                        @endif
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
@endsection
