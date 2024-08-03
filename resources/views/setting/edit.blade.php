@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.setting.edit'),
        'middle_page' => trans('language.setting.title'),
        'current_page' => trans('language.setting.edit'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('setting.update', $setting->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name') ?? $setting->name }}"
                                                   placeholder="{{ trans('language.setting.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.slug') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                   value="{{ old('slug') ?? $setting->slug }}"
                                                   placeholder="{{ trans('language.setting.slug') }}">
                                            @if ($errors->first('slug'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('slug') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.image_path') }}</label>
                                            <input type="file" class="form-control" id="image_path" name="image_path">
                                        </div>
                                        <div class="form-group">
                                            <img id="img" style="{{ !empty($setting->image_path) ? 'with: 200px; height: 200px; object-fit: cover' : '' }}" src="{{ asset($setting->image_path) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.banner_path') }}</label>
                                            <input type="file" class="form-control" id="banner_path" name="banner_path">
                                        </div>
                                        <div class="form-group">
                                            <img id="img_banner_path" style="{{ !empty($setting->banner_path) ? 'with: 200px; height: 200px; object-fit: cover' : '' }}" src="{{ asset($setting->banner_path) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.hot') }}</label><br>
                                            Có <input type="radio" name="hot" value="1" {{ $setting->hot === 1 ? 'checked' : '' }}>
                                            không <input type="radio" name="hot" value="0" {{ $setting->hot === 0 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.active') }}</label>
                                            <br>
                                            Hiện <input type="radio" name="active" value="1" {{ $setting->active === 1 ? 'checked' : '' }}>
                                            ẩn <input type="radio" name="active" value="0" {{ $setting->active === 0 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.description') }}</label>
                                            <textarea class="form-control" placeholder="{{ trans('language.setting.description') }}" cols="40"
                                                      rows="10" name="description">{{ old('description') ?? $setting->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.content') }}</label>
                                            <textarea class="form-control" placeholder="{{ trans('language.setting.content') }}" cols="40" rows="10"
                                                      name="content">{{ old('content') ?? $setting->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.parent_id') }}</label>
                                            <select class="form-control" name="parent_id">
                                                <option value="" disabled selected>--chọn--</option>
                                                @foreach ($listSetting as $category)
                                                    <option {{ $category->id == $setting->parent_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @if (count($category->childrenRecursive) > 0)
                                                        @include('components.child-category', [
                                                            'children' => $category->childrenRecursive,
                                                            'depth' => 1,
                                                        ])
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.order') }}</label>
                                            <input type="number" class="form-control" min="0" name="order"
                                                   value="{{ old('order') ?? $setting->order }}"
                                                   placeholder="{{ trans('language.setting.order') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.title_seo') }}</label>
                                            <input type="text" class="form-control" name="title_seo"
                                                   value="{{ old('title_seo') ?? $setting->title_seo }}"
                                                   placeholder="{{ trans('language.setting.title_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.description_seo') }}</label>
                                            <input type="text" class="form-control" name="description_seo"
                                                   value="{{ old('description_seo') ?? $setting->description_seo }}"
                                                   placeholder="{{ trans('language.setting.description_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.setting.keyword_seo') }}</label>
                                            <input type="text" class="form-control" name="keyword_seo"
                                                   value="{{ old('keyword_seo') ?? $setting->keyword_seo }}"
                                                   placeholder="{{ trans('language.setting.keyword_seo') }}">
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
    <script src="{{ asset('dist/js/pages/categorysetting.js') }}"></script>
@endsection
