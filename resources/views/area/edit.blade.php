@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.area.edit'),
        'middle_page' => trans('language.area.title'),
        'current_page' => trans('language.area.edit'),
    ])

    @php
        $infoTabHasErrors =
            $errors->has('name') ||
            $errors->has('city_id') ||
            $errors->has('district_id') ||
            $errors->has('commune_id') ||
            $errors->has('active') ||
            $errors->has('hot') ||
            $errors->has('order') ||
            $errors->has('slug') ||
            $errors->has('career');
    @endphp

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('area.update', $area->id) }}" method="post" enctype="multipart/form-data" id="form-area">
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
                                                            value="{{ old('name') ?? $area->name }}"
                                                            placeholder="{{ trans('language.area.name') }}">
                                                        @if ($errors->first('name'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.area.slug') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="slug" name="slug"
                                                            value="{{ old('slug') ?? $area->slug }}"
                                                            placeholder="{{ trans('language.area.slug') }}">
                                                        @if ($errors->first('slug'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('slug') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">{{ __('language.area.city_id') }}<span class="text-danger">*</span></label>
                                                        <select name="city_id" id="city_register" data-url="{{ route('ajax.address.districts') }}" class="form-control">
                                                            <!-- Removed the initial option with $area->city_id value -->
                                                            <option value="">--{{ __('language.area.city_id') }}--</option>
                                                            @foreach (App\Models\City::all() as $i)
                                                                <option value="{{ $i->id }}" {{ $i->id == $area->city_id ? 'selected' : '' }}>
                                                                    {{ $i->name }}
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
                                                            <option value="{{ $area->district_id }}">{{ $area->district->name ?? null }}</option>
                                                            <option value="">
                                                                --{{ __('language.area.district_id') }}--
                                                            </option>
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
                                                        <select name="commune_id" id="commune_register" class="w-100 form-control">
                                                            <option value="{{ $area->commune_id }}">{{ $area->commune->name ?? ''}}</option>
                                                            <option value="">
                                                                --{{ __('language.area.commune_id') }}--
                                                            </option>
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.area.address') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="address"
                                                            value="{{ old('address') ?? $area->address }}"
                                                            placeholder="{{ trans('language.area.address') }}">
                                                        @if ($errors->first('address'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('address') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">{{ __('language.area.parent_id') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select name="parent_id" id=""
                                                            class="form-control">
                                                            <option value="">
                                                                --{{ __('language.area.parent_id') }}--
                                                            </option>
                                                            @foreach($listCateArea as $category)
                                                                <option {{ $category->id == $area->parent_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>

                                                                @if(count($category->childrenRecursive) > 0)
                                                                    @include('components.child-category', [
                                                                        'children' => $category->childrenRecursive,
                                                                        'depth' => 1
                                                                    ])
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->first('parent_id'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('parent_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.area.order') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="order"
                                                            value="{{ old('order') ?? $area->order }}"
                                                            placeholder="{{ trans('language.area.order') }}">
                                                        @if ($errors->first('order'))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('order') }}
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
@endsection
