@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.post.add'),
        'middle_page' => trans('language.post.title'),
        'current_page' => trans('language.post.add'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('post.update', $post->id) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name') ?? $post->name }}"
                                                   placeholder="{{ trans('language.post.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.slug') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                   value="{{ old('slug') ?? $post->slug }}"
                                                   placeholder="{{ trans('language.post.slug') }}">
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
                                            <label>{{ trans('language.post.image_path') }}</label>
                                            <input type="file" class="form-control" id="image_path" name="image_path">
                                        </div>
                                        @if ($errors->first('image_path'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('image_path') }}
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <img id="img" style="{{ !empty($post->image_path) ? 'with: 200px; height: 200px; object-fit: cover' : '' }}" src="{{ asset($post->image_path) }}" alt="{{ $post->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.banner_path') }}</label>
                                            <input type="file" class="form-control" id="banner_path" name="banner_path">
                                        </div>
                                        @if ($errors->first('banner_path'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('banner_path') }}
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <img id="img_banner_path" style="{{ !empty($post->banner_path) ? 'with: 200px; height: 200px; object-fit: cover' : '' }}" src="{{ asset($post->banner_path) }}" alt="{{ $post->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.hot') }}</label><br>
                                            Có <input type="radio" name="hot" value="1" {{ $post->hot === 1 ? 'checked' : '' }}>
                                            không <input type="radio" name="hot" value="0" {{ $post->hot === 0 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.active') }}</label>
                                            <br>
                                            Hiện <input type="radio" name="active" value="1" {{ $post->active === 1 ? 'checked' : '' }}>
                                            ẩn <input type="radio" name="active" value="0" {{ $post->active === 0 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.description') }}</label>
                                            <textarea class="form-control tinymce_editor_init" id="ckeditor1" placeholder="{{ trans('language.post.description') }}" cols="40"
                                                      rows="10" name="description">{{ old('description') ?? $post->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.content') }}</label>
                                            <textarea class="form-control tinymce_editor_init" id="ckeditor2" placeholder="{{ trans('language.post.content') }}" cols="40" rows="10"
                                                      name="content">{{ old('content') ?? $post->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.parent_id') }}</label>
                                            <select class="form-control select2" name="category_id[]" multiple>
                                                <option value="" disabled>--chọn--</option>
                                                @foreach ($listCategoryPost as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if (in_array($category->id, $selectedCategoryIds)) selected @endif>
                                                        {{ $category->name }}
                                                    </option>

                                                    @if (count($category->childrenRecursive) > 0)
                                                        @include('components.child-category', [
                                                            'children' => $category->childrenRecursive,
                                                            'depth' => 1,
                                                            'selectedCategoryIds' => $selectedCategoryIds
                                                        ])
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.order') }}</label>
                                            <input type="number" class="form-control" min="0" name="order"
                                                   value="{{ old('order') ?? $post->order }}"
                                                   placeholder="{{ trans('language.post.order') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.title_seo') }}</label>
                                            <input type="text" class="form-control" name="title_seo"
                                                   value="{{ old('title_seo') ?? $post->title_seo }}"
                                                   placeholder="{{ trans('language.post.title_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.description_seo') }}</label>
                                            <input type="text" class="form-control" name="description_seo"
                                                   value="{{ old('description_seo') ?? $post->description_seo }}"
                                                   placeholder="{{ trans('language.post.description_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.keyword_seo') }}</label>
                                            <input type="text" class="form-control" name="keyword_seo"
                                                   value="{{ old('keyword_seo') ?? $post->keyword_seo }}"
                                                   placeholder="{{ trans('language.post.keyword_seo') }}">
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
    <script src="{{ asset('dist/js/pages/categorypost.js') }}"></script>
@endsection
