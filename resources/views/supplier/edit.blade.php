@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.supplier.edit'),
        'middle_page' => trans('language.supplier.title'),
        'current_page' => trans('language.supplier.edit'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form action="{{ route('supplier.update', ['id' => $data->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.supplier.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') ?? $data->name }}"
                                                placeholder="{{ trans('language.supplier.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.customer.responsible_person') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="responsible_person"
                                                value="{{ old('responsible_person') ?? $data->responsible_person }}"
                                                placeholder="{{ trans('language.customer.responsible_person') }}">
                                            @if ($errors->first('responsible_person'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('responsible_person') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.email') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ old('email') ?? $data->email }}"
                                                placeholder="{{ trans('language.email') }}">
                                            @if ($errors->first('email'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.phone') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ old('phone') ?? $data->phone }}"
                                                placeholder="{{ trans('language.phone') }}">
                                            @if ($errors->first('phone'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.customer.tax_code') }}</label>
                                            <input type="text" class="form-control" name="tax_code"
                                                value="{{ old('tax_code') ?? $data->tax_code }}"
                                                placeholder="{{ trans('language.customer.tax_code') }}">
                                            @if ($errors->first('tax_code'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('tax_code') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.customer.address') }}</label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ old('address') ?? $data->address }}"
                                                placeholder="{{ trans('language.customer.address') }}">
                                            @if ($errors->first('address'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('address') }}
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
@endsection
