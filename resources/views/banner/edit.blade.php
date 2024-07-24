@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.banner.edit'),
        'middle_page' => trans('language.banner.title'),
        'current_page' => trans('language.banner.edit'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('banner.update', $banner->id) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.banner.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                   value="{{ old('name') ?? $banner->name }}"
                                                   placeholder="{{ trans('language.banner.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.banner.link') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="link"
                                                   value="{{ old('link') ?? $banner->link }}"
                                                   placeholder="{{ trans('language.banner.link') }}">
                                            @if ($errors->first('link'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('link') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.banner.image_path') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="image_path" name="image_path">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <img id="img" width="200px" height="200px" src="{{ asset($banner->image_path) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.banner.hot') }}<span class="text-danger">*</span></label><br>
                                            Có <input type="radio" name="hot" value="1" {{ $banner->hot === 1 ? 'checked' : '' }}>
                                            không <input type="radio" name="hot" value="0" {{ $banner->hot === 0 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.banner.active') }}<span class="text-danger">*</span></label>
                                            <br>
                                            Hiện <input type="radio" name="active" value="1" {{ $banner->active === 1 ? 'checked' : '' }}>
                                            ẩn <input type="radio" name="active" value="0" {{ $banner->active === 0 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.banner.description') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control"
                                                      placeholder="{{ trans('language.banner.description') }}"
                                                      cols="40" rows="10" name="description">{{ old('description') ?? $banner->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.banner.parent_id') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="parent_id">
                                                <option disabled selected>--chọn--</option>
                                                @foreach($parentBanner as $category)
                                                    <option {{ $category->id == $banner->parent_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @if(count($category->childrenRecursive) > 0)
                                                        @include('components.child-category', [
                                                            'children' => $category->childrenRecursive,
                                                            'depth' => 1,
                                                            'categoryCheck' => $banner->parent_id
                                                        ])
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.banner.order') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="order"
                                                   value="{{ old('order') ?? $banner->order }}"
                                                   placeholder="{{ trans('language.banner.order') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span></span>
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
    <script>
        $('#image_path').on('change', function () {
            let reader = new FileReader()
            reader.onload = (e) => {
                $('#img').attr('src', e.target.result);
                $('#img').css('width', '200px');
                $('#img').css('height', '200px');
            }
            reader.readAsDataURL(this.files[0]);
        })
    </script>
@endsection
