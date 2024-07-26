@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.categoryPost.edit'),
        'middle_page' => trans('language.categoryPost.title'),
        'current_page' => trans('language.categoryPost.edit'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('categoryPost.update', ['id' => $categoryPostById->id]) }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name') ?? $categoryPostById->name }}"
                                                   placeholder="{{ trans('language.categoryPost.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.slug') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="{{ old('slug') ?? $categoryPostById->slug }}"
                                                placeholder="{{ trans('language.categoryPost.slug') }}">
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
                                            <label>{{ trans('language.categoryPost.image_path') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="image_path" name="image_path">
                                        </div>
                                        <div class="form-group">
                                            <img id="img"
                                                style="{{ !empty($categoryPostById->image_path) ? 'with: 200px; height: 200px; object-fit: cover' : '' }}"
                                                src="{{ asset($categoryPostById->image_path) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.banner_path') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="banner_path" name="banner_path">
                                        </div>
                                        <div class="form-group">
                                            <img id="img_banner_path"
                                                style="{{ !empty($categoryPostById->banner_path) ? 'with: 200px; height: 200px; object-fit: cover' : '' }}"
                                                src="{{ asset($categoryPostById->banner_path) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.hot') }}<span
                                                    class="text-danger">*</span></label><br>
                                            Có <input type="radio" name="hot" value="1"
                                                {{ $categoryPostById->hot === 1 ? 'checked' : '' }}>
                                            không <input type="radio" name="hot" value="0"
                                                {{ $categoryPostById->hot === 0 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.active') }}<span
                                                    class="text-danger">*</span></label>
                                            <br>
                                            Hiện <input type="radio" name="active" value="1"
                                                {{ $categoryPostById->active === 1 ? 'checked' : '' }}>
                                            ẩn <input type="radio" name="active" value="0"
                                                {{ $categoryPostById->active === 0 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.description') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" placeholder="{{ trans('language.categoryPost.description') }}" cols="40"
                                                rows="10" name="description">{{ old('description') ?? $categoryPostById->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.content') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" placeholder="{{ trans('language.categoryPost.content') }}" cols="40" rows="10"
                                                name="content">{{ old('content') ?? $categoryPostById->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.parent_id') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" name="parent_id" multiple>
                                                <option disabled>--chọn--</option>
                                                @foreach ($listCategoryPost as $category)
                                                    <option
                                                        {{ $category->id === $categoryPostById->parent_id ? 'selected' : '' }}
                                                        value="{{ $category->id }}">{{ $category->name }}</option>

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
                                            <label>{{ trans('language.categoryPost.order') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" min="0" name="order"
                                                value="{{ old('order') ?? $categoryPostById->order }}"
                                                placeholder="{{ trans('language.banner.order') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.title_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title_seo"
                                                value="{{ old('title_seo') ?? $categoryPostById->title_seo }}"
                                                placeholder="{{ trans('language.categoryPost.title_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.description_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="description_seo"
                                                value="{{ old('description_seo') ?? $categoryPostById->description_seo }}"
                                                placeholder="{{ trans('language.categoryPost.description_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.keyword_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="keyword_seo"
                                                value="{{ old('keyword_seo') ?? $categoryPostById->keyword_seo }}"
                                                placeholder="{{ trans('language.categoryPost.keyword_seo') }}">
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

@endsection
