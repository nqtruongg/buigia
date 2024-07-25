@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.categoryPost.add'),
        'middle_page' => trans('language.categoryPost.title'),
        'current_page' => trans('language.categoryPost.add'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('categoryPost.store') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name') ?? '' }}"
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
                                                   value="{{ old('slug') ?? '' }}"
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.image_path') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="image_path" name="image_path">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <img id="img" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                {{-- banner_path --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.banner_path') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="banner_path" name="banner_path">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <img id="img_banner_path" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.hot') }}<span class="text-danger">*</span></label><br>
                                            Có <input type="radio" name="hot" value="1">
                                            không <input type="radio" name="hot" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.active') }}<span class="text-danger">*</span></label>
                                            <br>
                                            Hiện <input type="radio" name="active" value="1" checked>
                                            ẩn <input type="radio" name="active" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.description') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control"
                                                      placeholder="{{ trans('language.categoryPost.description') }}"
                                                      cols="40" rows="10" name="description">{{ old('description') ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.content') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control"
                                                      placeholder="{{ trans('language.categoryPost.content') }}"
                                                      cols="40" rows="10" name="content">{{ old('content') ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.parent_id') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="parent_id">
                                                <option disabled selected>--chọn--</option>
                                                @foreach($listCategoryPost as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @if(count($category->childrenRecursive) > 0)
                                                        @include('components.child-category', [
                                                            'children' => $category->childrenRecursive,
                                                            'depth' => 1
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
                                            <label>{{ trans('language.categoryPost.order') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" min="0" name="order"
                                                   value="{{ old('order') ?? 0 }}"
                                                   placeholder="{{ trans('language.banner.order') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.title_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title_seo"
                                                   value="{{ old('title_seo') ?? '' }}"
                                                   placeholder="{{ trans('language.categoryPost.title_seo') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.description_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="description_seo"
                                                   value="{{ old('description_seo') ?? '' }}"
                                                   placeholder="{{ trans('language.categoryPost.description_seo') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.categoryPost.keyword_seo') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="keyword_seo"
                                                   value="{{ old('keyword_seo') ?? '' }}"
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

        $('#banner_path').on('change', function () {
            let reader = new FileReader()
            reader.onload = (e) => {
                $('#img_banner_path').attr('src', e.target.result);
                $('#img_banner_path').css('width', '200px');
                $('#img_banner_path').css('height', '200px');
            }
            reader.readAsDataURL(this.files[0]);
        })
    </script>

    <script>
        $('#name').on('input', function () {
            let name = $('#name').val().trim().toLowerCase();

            const vnAccents = [
                'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
                'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
                'ì', 'í', 'ị', 'ỉ', 'ĩ',
                'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
                'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
                'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
                'đ',
                'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ',
                'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
                'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ',
                'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
                'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
                'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ',
                'Đ'
            ];

            const vnAccentsOut = [
                'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
                'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                'i', 'i', 'i', 'i', 'i',
                'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
                'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
                'y', 'y', 'y', 'y', 'y',
                'd',
                'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
                'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
                'I', 'I', 'I', 'I', 'I',
                'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
                'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
                'Y', 'Y', 'Y', 'Y', 'Y',
                'D'
            ];

            for (let i = 0; i < vnAccents.length; i++) {
                name = name.replace(new RegExp(vnAccents[i], 'g'), vnAccentsOut[i]);
            }

            name = name.replace(/[^\w\s-]/g, '');
            name = name.replace(/\s+/g, '-');

            $('#slug').val(name);
        });
    </script>
@endsection
