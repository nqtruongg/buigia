@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.department.add'),
        'middle_page' => trans('language.department.title'),
        'current_page' => trans('language.department.add'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('department.update', ['id' => $data->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ trans('language.department.name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $data->name }}"
                                        placeholder="{{ trans('language.department.name') }}">
                                </div>
                                @if ($errors->first('name'))
                                    <div class="invalid-alert text-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
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
