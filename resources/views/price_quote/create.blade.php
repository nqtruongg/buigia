@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.price_quote.add'),
        'middle_page' => trans('language.price_quote.title'),
        'current_page' => trans('language.price_quote.add'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('priceQuote.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.customer.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <select name="customer" id="customer_info" class="form-control select2">
                                                @php
                                                    $choose_customer = old('customer') ? old('customer') : '';
                                                @endphp
                                                <option value=""></option>
                                                @foreach ($customers as $customer)
                                                    <option @if ($choose_customer == $customer->id) selected @endif
                                                        data-name="{{ $customer->name }}" value="{{ $customer->id }}">
                                                        {{ $customer->code }} </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->first('customer'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('customer') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.price_quote.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') ?? '' }}"
                                                placeholder="{{ trans('language.price_quote.name') }}">
                                            @if ($errors->first('name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('language.content') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea id="ckeditor1" class="tinymce_editor_init" name="content" cols="30" rows="10"></textarea>
                                            @if ($errors->first('content'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('content') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered" id="table_service">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">#</th>
                                            <th class="text-center align-middle w-20">
                                                {{ trans('language.service.title') }}
                                            </th>
                                            <th class="text-center align-middle">
                                                {{ trans('language.subtotal') }}
                                            </th>
                                            <th class="text-center align-middle">
                                                {{ trans('language.describe') }}
                                            </th>
                                            <th class="text-center align-middle">
                                                {{ trans('language.note') }}
                                            </th>
                                            <th class="text-center align-middle"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (request()->old())
                                            @for ($i = 0; $i < count(old('services', [])); $i++)
                                                <tr>
                                                    <td class="text-center align-middle">1</td>
                                                    <td class="text-center align-middle">
                                                        <select class="form-control select2 service_change"
                                                            name="services[]">
                                                            <option value=" ">Dịch vụ</option>
                                                            @foreach ($services as $item)
                                                                <option @if (old('services.' . $i) == $item->id) selected @endif
                                                                    value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->first('services.' . $i))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('services.' . $i) }}
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td class="text-center align-middle">
                                                        <input type="text" name="view_total[]"
                                                            class="form-control view-total"
                                                            value="{{ old('view_total.' . $i) }}">
                                                        <input type="hidden" name="subtotal[]"
                                                            value="{{ old('subtotal.' . $i) }}">
                                                        <input type="hidden" class="price_ser" name="price_ser[]"
                                                            value="{{ old('price_ser.' . $i) }}">
                                                        @if ($errors->first('view_total.' . $i))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('view_total.' . $i) }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="text" name="describe[]" class="form-control"
                                                            value="{{ old('describe.' . $i) }}">
                                                        @if ($errors->first('describe.' . $i))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('describe.' . $i) }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="text" name="note[]" class="form-control"
                                                            value="{{ old('note.' . $i) }}">
                                                        @if ($errors->first('note.' . $i))
                                                            <div class="invalid-alert text-danger">
                                                                {{ $errors->first('note.' . $i) }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($i == 0)
                                                            <button style="border-radius:50%" type="button"
                                                                id="plus_record" class="btn btn-success btn-sm"><i
                                                                    class="fas fa-plus"></i>
                                                            </button>
                                                        @else
                                                            <button style="border-radius:50%" type="button"
                                                                class="btn btn-danger btn-sm minus_record"><i
                                                                    class="fas fa-minus"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endfor
                                        @else
                                            <tr>
                                                <td class="text-center align-middle">1</td>
                                                <td class="text-center align-middle">
                                                    <select class="form-control select2 service_change" name="services[]">
                                                        <option selected="selected" value=" ">Dịch vụ
                                                        </option>
                                                        @foreach ($services as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->first('services[]'))
                                                        <div class="invalid-alert text-danger">
                                                            {{ $errors->first('services[]') }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <td class="text-center align-middle">
                                                    <input type="text" name="view_total[]"
                                                        class="form-control view-total" value="">
                                                    <input type="hidden" name="subtotal[]" value="">
                                                    <input type="hidden" class="price_ser" name="price_ser[]"
                                                        value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="describe[]" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="note[]" class="form-control">
                                                </td>
                                                <td class="text-center align-middle">
                                                    <button style="border-radius:50%" type="button" id="plus_record"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row pt-4">
                                    <div class="col-12 d-flex  justify-content-end" style="font-size: 20px">
                                        <label for=""
                                            class="font-weight-bold">{{ trans('language.sum') }}:&nbsp;</label>
                                        <span
                                            class="sum-price">{{ old('total_hidden') ? number_format(old('total_hidden')) : '0' }}<span>đ</span></span>
                                        <input type="hidden" name="total_hidden">
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
        <div class="d-none" id="clone_tr">
            <table>
                <tbody>
                    <tr>
                        <td class="text-center align-middle">1</td>
                        <td class="text-center align-middle">
                            <select class="form-control service_change" name="services[]">
                                <option selected="selected" value=" ">Dịch vụ</option>
                                @foreach ($services as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-center align-middle">
                            <input type="text" name="view_total[]" class="form-control view-total" value="">
                            <input type="hidden" name="subtotal[]" value="">
                            <input type="hidden" class="price_ser" name="price_ser[]" value="">
                        </td>
                        <td>
                            <input type="text" name="describe[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="note[]" class="form-control">
                        </td>
                        <td class="text-center align-middle">
                            <button style="border-radius:50%" type="button"
                                class="btn btn-danger btn-sm minus_record"><i class="fas fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/price-quote.js') }}"></script>
@endsection
