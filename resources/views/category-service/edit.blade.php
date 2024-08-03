@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.categoryService.edit'),
        'middle_page' => trans('language.categoryService.title'),
        'current_page' => trans('language.categoryService.edit'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('categoryService.update', ['id' => $categoryService->id]) }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name') ?? $categoryService->name }}"
                                                   placeholder="{{ trans('language.categoryService.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.slug') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="{{ old('slug') ?? $categoryService->slug }}"
                                                placeholder="{{ trans('language.categoryService.slug') }}">
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
                                            <label>{{ trans('language.categoryService.image_path') }}</label>
                                            <input type="file" class="form-control" id="image_path" name="image_path">
                                        </div>
                                        <div class="form-group">
                                            <img id="img"
                                                style="{{ !empty($categoryService->image_path) ? 'with: 200px; height: 200px; object-fit: cover' : '' }}"
                                                src="{{ asset($categoryService->image_path) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.banner_path') }}</label>
                                            <input type="file" class="form-control" id="banner_path" name="banner_path">
                                        </div>
                                        <div class="form-group">
                                            <img id="img_banner_path"
                                                style="{{ !empty($categoryService->banner_path) ? 'with: 200px; height: 200px; object-fit: cover' : '' }}"
                                                src="{{ asset($categoryService->banner_path) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.description') }}</label>
                                            <textarea class="form-control" placeholder="{{ trans('language.categoryService.description') }}" cols="40"
                                                rows="10" name="description">{{ old('description') ?? $categoryService->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.content') }}</label>
                                            <textarea class="form-control" placeholder="{{ trans('language.categoryService.content') }}" cols="40" rows="10"
                                                name="content">{{ old('content') ?? $categoryService->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.parent_id') }}</label>
                                            <select class="form-control" name="parent_id">
                                                <option disabled selected>--chọn--</option>
                                                @foreach ($listCateCategoryService as $category)
                                                    <option
                                                        {{ $category->id == $categoryService->parent_id ? 'selected' : '' }}
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
                                            <label>{{ trans('language.categoryService.order') }}</label>
                                            <input type="number" class="form-control" min="0" name="order"
                                                value="{{ old('order') ?? $categoryService->order }}"
                                                placeholder="{{ trans('language.banner.order') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.title_seo') }}</label>
                                            <input type="text" class="form-control" name="title_seo"
                                                value="{{ old('title_seo') ?? $categoryService->title_seo }}"
                                                placeholder="{{ trans('language.categoryService.title_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.description_seo') }}</label>
                                            <input type="text" class="form-control" name="description_seo"
                                                value="{{ old('description_seo') ?? $categoryService->description_seo }}"
                                                placeholder="{{ trans('language.categoryService.description_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryService.keyword_seo') }}</label>
                                            <input type="text" class="form-control" name="keyword_seo"
                                                value="{{ old('keyword_seo') ?? $categoryService->keyword_seo }}"
                                                placeholder="{{ trans('language.categoryService.keyword_seo') }}">
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
