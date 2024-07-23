{{-- @extends('layout.master')
@section('content')
    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('partials.topbar', [
            'titleTab' => trans('language.role.title'),
        ])
        <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-4">
            <h2 class="text-lg font-medium mr-auto">
                {{ trans('language.role.add') }}
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button type="button" class="btn box mr-2 flex items-center ml-auto sm:ml-0" onclick="goBack()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="corner-up-left" data-lucide="corner-up-left"
                        class="lucide lucide-corner-up-left block mx-auto">
                        <polyline points="9 14 4 9 9 4"></polyline>
                        <path d="M20 20v-7a4 4 0 00-4-4H4"></path>
                    </svg>
                    {{ trans('language.back') }}
                </button>
                <div class="dropdown">
                    <button id="submitData" class="dropdown-toggle btn btn-primary shadow-md flex items-center"
                        aria-expanded="false" data-tw-toggle="dropdown"> {{ trans('language.save') }} </button>
                </div>
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="post intro-y overflow-hidden box mt-5">
                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                        <form id="form_submit" action="{{ route('role.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="regular-form-1"
                                    class="form-label font-medium">{{ trans('language.department.title') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select data-placeholder="{{ trans('language.department.title') }}"
                                    class="tom-select w-full" name="department_id">
                                    <option value=" " selected>{{ trans('language.department.title') }}</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->first('department_id'))
                                    <div class="invalid-alert text-danger">
                                        {{ $errors->first('department_id') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mt-5">
                                <label for="regular-form-1"
                                    class="form-label font-medium">{{ trans('language.role.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="{{ trans('language.role.name') }}" required
                                    value="{{ old('name') ? old('name') : '' }}">
                                @if ($errors->first('name'))
                                    <div class="invalid-alert text-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mt-5">
                                <label for="regular-form-1"
                                    class="form-label font-medium">{{ trans('language.permission.title') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="grid grid-cols-10 gap-5 mt-2">
                                    @foreach ($permissions as $permission)
                                        <div
                                            class="col-span-12 col-span-2 p-5 cursor-pointer rounded-md border border-slate-200/60 ">
                                            <div class="font-medium flex items-center">
                                                <input name="permission_id[]" type="checkbox"
                                                    class="form-check-input border mr-2 checkboxRole" value="{{$permission->id}}">
                                                {!! \App\Models\Permission::checkTypePermission($permission->type) !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script>
        jQuery(document).on('click', '#submitData', function() {
            jQuery('#form_submit').submit();
        })
    </script>
@endsection --}}



@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.role.add'),
        'middle_page' => trans('language.role.title'),
        'current_page' => trans('language.role.add'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="form_submit" action="{{ route('role.update', ['id' => $role->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('language.department.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <select data-placeholder="{{ trans('language.department.title') }}"
                                                class="form-control select2" name="department_id">
                                                <option value=" " selected>{{ trans('language.department.title') }}
                                                </option>
                                                @php
                                                    $choose = old('department_id') ? old('department_id') : $role->department_id;
                                                @endphp
                                                @foreach ($departments as $department)
                                                    <option @if($choose == $department->id ) selected @endif value="{{ $department->id }}">{{ $department->name }}</option>
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
                                            <label>{{ trans('language.role.name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') ?? $role->name }}"
                                                placeholder="{{ trans('language.role.name') }}">
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
                                            <label>{{ trans('language.service.description') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <ul
                                                class="mailbox-attachments d-flex align-items-stretch justify-content-between clearfix">
                                                @foreach ($permissions as $permission)
                                                    <li>
                                                        <div class="mailbox-attachment-info d-flex align-items-center justify-content-center"
                                                            style="background-color: #cccccc">
                                                            <input name="permission_id[]" type="checkbox"
                                                                class=" checkboxRole mr-2" @if(in_array($permission->id,$arr_permissions)) checked @endif value="{{ $permission->id }}">
                                                            {!! \App\Models\Permission::checkTypePermission($permission->type) !!}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
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
