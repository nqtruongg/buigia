@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.user.add'),
        'middle_page' => trans('language.user.title'),
        'current_page' => trans('language.user.add'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('user.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.user.first_name') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="first_name"
                                                value="{{ old('first_name') ?? '' }}"
                                                placeholder="{{ trans('language.user.first_name') }}">
                                            @if ($errors->first('first_name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.user.last_name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ old('last_name') ?? '' }}"
                                                placeholder="{{ trans('language.user.last_name') }}">
                                            @if ($errors->first('last_name'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('last_name') }}
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
                                                value="{{ old('email') ?? '' }}"
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
                                                value="{{ old('phone') ?? '' }}"
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
                                            <label>{{ trans('language.department.title') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" name="department_id" id="department_id">
                                                <option selected="selected" value=" ">Phòng ban</option>
                                                @php
                                                    $choose_brand = old('department_id') ? old('department_id') : '';
                                                @endphp
                                                @foreach ($departments as $item)
                                                    <option @if ($choose_brand == $item->id) selected @endif
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->first('department_id'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('department_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.role.title') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" id="role_id" name="role_id">
                                                <option selected="selected" value=" ">Vai trò</option>
                                            </select>
                                            @if ($errors->first('role_id'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('role_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.address') }}</label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ old('address') ?? '' }}"
                                                placeholder="{{ trans('language.address') }}">
                                            @if ($errors->first('address'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('address') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.password') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="password"
                                                value="{{ old('password') ?? '' }}"
                                                placeholder="{{ trans('language.password') }}">
                                            @if ($errors->first('password'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.commission_id') }}</label>
                                            <select name="commission_id" class="form-control" id="commission_id">
                                                <option disabled selected>--chọn--</option>
                                                @if($commissions)
                                                    @foreach ($commissions as $item)
                                                        <option value="{{ $item->id }}">{{ $item->percent }}%</option>
                                                    @endforeach
                                                @endif
                                            </select>
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
    <script src="{{ asset('dist/js/pages/user.js') }}"></script>
@endsection
