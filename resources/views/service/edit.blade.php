@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.service.edit'),
        'middle_page' => trans('language.service.title'),
        'current_page' => trans('language.service.edit'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('service.update', ['id' => $service->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') ?? $service->name }}"
                                                placeholder="{{ trans('language.service.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.price') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="price"
                                                value="{{ old('price') ?? $service->price  }}"
                                                placeholder="{{ trans('language.service.price') }}">
                                            @if ($errors->first('price'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('price') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.percent') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="percent"
                                                value="{{ old('percent') ?? $service->percent  }}"
                                                placeholder="{{ trans('language.service.percent') }}">
                                            @if ($errors->first('percent'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('percent') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.type') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="type" id="">
                                                {{-- <option selected="selected" value=" ">Dạng dịch vụ</option> --}}
                                                <option @if($service->type == 0) selected @endif value="0">Đang bán</option>
                                                <option @if($service->type == 1) selected @endif value="1">Đã đặt cọc</option>
                                                <option @if($service->type == 2) selected @endif value="1">Đã bán</option>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.service.description') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" name="description" id="" cols="30" rows="10"
                                                placeholder="{{ trans('language.service.description') }}">{{ old('price') ?? $service->description }}</textarea>
                                            @if ($errors->first('description'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('description') }}
                                                </div>
                                            @endif
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
