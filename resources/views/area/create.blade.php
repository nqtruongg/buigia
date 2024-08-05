@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.area.add'),
        'middle_page' => trans('language.area.title'),
        'current_page' => trans('language.area.add'),
    ])

    @php
        $infoTabHasErrors =
            $errors->has('name') ||
            $errors->has('type') ||
            $errors->has('active');
    @endphp

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('area.store') }}" method="post" enctype="multipart/form-data" id="form-area">
                        @csrf
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                           href="#custom-tabs-four-home" role="tab"
                                           aria-controls="custom-tabs-four-home"
                                           aria-selected="true">{{ trans('language.area.info') }}
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
                                                        <label>{{ trans('language.area.name') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                               value="{{ old('name') ?? '' }}"
                                                               placeholder="{{ trans('language.area.name') }}">
                                                        @if ($errors->first('name'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    @if(!empty($_GET['city_id']))
                                                        <input type="hidden" name="city_id" value="{{ request('city_id') }}">
                                                    @elseif(!empty($_GET['district_id']))
                                                        <input type="hidden" name="district_id" value="{{ request('district_id') }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.area.type') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select name="type" id="type" class="form-control select2">
                                                            <option value="">
                                                                --{{ __('language.area.type') }}--
                                                            </option>
                                                            @if(!empty($_GET['city_id']))
                                                                <option value="Quận">Quận</option>
                                                                <option value="Huyện">
                                                                    Huyện
                                                                </option>
                                                                <option value="Thành phố">
                                                                    Thành phố
                                                                </option>
                                                            @elseif(!empty($_GET['district_id']))
                                                                <option value="Phường">Phường</option>
                                                                <option value="Xã">
                                                                    Xã
                                                                </option>
                                                                <option value="Thị trấn">
                                                                    Thị trấn
                                                                </option>
                                                            @else
                                                                <option value="Tỉnh">Tỉnh</option>
                                                                <option value="Thành phố trung ương">
                                                                    Thành phố Trung ương
                                                                </option>
                                                            @endif
                                                        </select>
                                                        @if ($errors->first('type'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('type') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.area.active') }}</label>
                                                        <br>
                                                        Hiện <input type="radio" name="active" value="1" checked>
                                                        ẩn <input type="radio" name="active" value="0">
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
@endsection
