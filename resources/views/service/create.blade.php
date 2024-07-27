@extends('layout.master')

@section('css')
    <style>
        #imagePreview {
            display: flex;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .display-4 {
            font-size: calc(1.475rem + 2.7vw);
            font-weight: 300;
            line-height: 1.2;
        }

        #imagePreview > img {
            width: 114.9px;
            height: 115px;
            object-fit: cover;
            border: 2px solid orange;
            margin: 13px 27px 13px 0;
        }


        .fa-upload {
            font-size: 55px;
            color: #606166;
        }

        .box_img {
            position: relative;
        }

        .box_img > img {
            width: 114.9px;
            height: 115px;
            object-fit: cover;
            border: 2px solid orange;
            margin: 13px 27px 13px 0;
        }

        .btnDelete_image {
            position: absolute;
            top: 2px;
            right: 15px;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            border: 1px solid #ccc;
        }

        .btnDelete_image:hover {
            background-color: #fff;
            color: #000;
            transition: all 0.2s;
            font-weight: 600;
        }

        .variantColor {
            position: relative;
        }

        .btnRemoveImage {
            position: absolute;
            right: 15px;
            top: -12px;
            border-radius: 50%;
            width: 30px;
            height: 30px !important;
        }

        .variant-box {
            border: 1px solid #494949;
            padding: 20px 0 0 18px;
            border-radius: 5px;
            background-color: #272727;
            margin-bottom: 10px;
        }

        .file-input-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .file-input-wrapper input[name="relatedPhotos[]"] {
            position: absolute;
            width: 87px;
            height: 88px;
            top: 6px;
            left: 6px;
            opacity: 0;
            cursor: pointer;
            z-index: 99;
        }

        .file-input-wrapper .custom-button {
            position: absolute;
            width: 100px;
            height: 100%;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            border: 2px solid #565656;
            cursor: pointer;
        }

        .file-input-wrapper img {
            border-radius: 5px;
            width: 100px;
            height: 100px;
            object-fit: cover;
            display: none;
        }

        .file-input-wrapper .remove-button {
            position: absolute;
            top: -7px;
            right: 3px;
            font-size: 17px;
            color: #565656;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.service.add'),
        'middle_page' => trans('language.service.title'),
        'current_page' => trans('language.service.add'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('service.store') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name') ?? '' }}"
                                                   placeholder="{{ trans('language.service.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.slug') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                   value="{{ old('slug') ?? '' }}"
                                                   placeholder="{{ trans('language.service.slug') }}">
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
                                            <label>{{ trans('language.service.price') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="price"
                                                   value="{{ old('price') ?? '' }}"
                                                   placeholder="{{ trans('language.service.price') }}">
                                            @if ($errors->first('price'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('price') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.type') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="type" id="">
                                                {{-- <option selected="selected" value=" ">Dạng dịch vụ</option> --}}
                                                <option selected="selected" value="0">Đang trống</option>
                                                <option value="1">Đã đặt cọc</option>
                                                <option value="2">Đã đươc thuê</option>
                                            </select>
                                            @if ($errors->first('type'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('type') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.image_path') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="image_path" name="image_path">
                                        </div>
                                        <div class="form-group">
                                            <img id="img" src="" style="object-fit: cover" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.banner_path') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="banner_path" name="banner_path">
                                        </div>
                                        <div class="form-group">
                                            <img id="img_banner_path" src="" style="object-fit: cover" alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3 mb-3">
                                    <label for="relatedPhotos"
                                           class="form-label">{{ trans('language.service.relatedPhotos') }}</label>
                                    <div style="border: 1px solid #272727; padding: 20px 0 0 18px; border-radius: 5px;">
                                        <div id="variantContainer" class="d-flex flex-wrap">
                                            <div class="variantColor d-flex align-items-center">
                                                <div class="mb-3 w-25 file-input-wrapper"
                                                     style="margin-right: 18px; width: 110px !important;">
                                                    <input type="file" multiple name="relatedPhotos[]"
                                                           id="relatedPhotos" class="form-control">
                                                    <div class="custom-button" style="border: 2px solid #565656;">
                                                        <i class="nav-icon fas fa-upload"></i>
                                                    </div>
                                                    <img src="#" alt="Preview Image">
                                                    <button class="remove-button" type="button">&times;</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success mt-3" type="button" id="addAnhLienQuan">Thêm ảnh liên
                                        quan
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.acreage') }}<span
                                                    class="text-danger">*</span></label><br>
                                            <input type="number" class="form-control" value="{{ old('acreage') ?? '' }}" name="acreage"
                                                   placeholder="{{ trans('language.service.acreage') }}">
                                            @if ($errors->first('acreage'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('acreage') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.numberBedroom') }}<span
                                                    class="text-danger">*</span></label><br>
                                            <input type="number" class="form-control" value="{{ old('numberBedroom') ?? '' }}" name="numberBedroom"
                                                   placeholder="{{ trans('language.service.numberBedroom') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.toilet') }}<span
                                                    class="text-danger">*</span></label><br>
                                            <input type="number" class="form-control" value="{{ old('toilet') ?? '' }}" name="toilet"
                                                   placeholder="{{ trans('language.service.toilet') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.direction') }}<span
                                                    class="text-danger">*</span></label><br>
                                            <input type="text" class="form-control" value="{{ old('direction') ?? '' }}" name="direction"
                                                   placeholder="{{ trans('language.service.direction') }}">
                                            @if ($errors->first('direction'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('direction') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.area') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <br>
                                            <select name="area" class="form-control" id="area">
                                                <option value="" selected disabled>--chọn--</option>
                                                @if(!empty($listArea))
                                                    @foreach($listArea as $area)
                                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->first('area_id'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('area_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.houseHolder') }}<span
                                                    class="text-danger">*</span></label><br>
                                            <select name="houseHolder" class="form-control" id="houseHolder">
                                                <option value="" selected disabled>--chọn--</option>
                                                @if(!empty($listHouseHoulder))
                                                    @foreach($listHouseHoulder as $houseHolder)
                                                        <option
                                                            value="{{ $houseHolder->id }}">{{ $houseHolder->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->first('householder_id'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('householder_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>{{ trans('language.service.category') }}<span
                                                class="text-danger">*</span></label><br>
                                        <select name="category_id[]" multiple class="form-control select2" id="categoryService">
                                            <option value="" disabled>--chọn--</option>
                                            @if(!empty($listCategoryService))
                                                @foreach ($listCategoryService as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @if (count($category->childrenRecursive) > 0)
                                                        @include('components.child-category', [
                                                            'children' => $category->childrenRecursive,
                                                            'depth' => 1,
                                                        ])
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->first('category_id'))
                                            <div class="invalid-alert text-danger">
                                                {{ $errors->first('category_id') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.order') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" min="0" name="order"
                                                   value="{{ old('order') ?? 0 }}"
                                                   placeholder="{{ trans('language.service.order') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.hot') }}<span
                                                    class="text-danger">*</span></label><br>
                                            Có <input type="radio" name="hot" value="1">
                                            không <input type="radio" name="hot" value="0" checked>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.active') }}<span
                                                    class="text-danger">*</span></label>
                                            <br>
                                            Hiện <input type="radio" name="active" value="1" checked>
                                            ẩn <input type="radio" name="active" value="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.description') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" name="description" id="" cols="30" rows="10"
                                                      placeholder="{{ trans('language.service.description') }}">{{ old('description') ?? '' }}</textarea>
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
                                            <label>{{ trans('language.post.content') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" placeholder="{{ trans('language.post.content') }}" cols="40" rows="10"
                                                      name="content">{{ old('content') ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.title_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title_seo"
                                                   value="{{ old('title_seo') ?? '' }}"
                                                   placeholder="{{ trans('language.post.title_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.description_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="description_seo"
                                                   value="{{ old('description_seo') ?? '' }}"
                                                   placeholder="{{ trans('language.post.description_seo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.post.keyword_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="keyword_seo"
                                                   value="{{ old('keyword_seo') ?? '' }}"
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
    <script src="{{ asset('dist/js/pages/service.js') }}"></script>
@endsection
