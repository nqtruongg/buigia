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
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i>Tìm kiếm nâng cao</button>
                        <a href="{{ route('post.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.post.add') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'email', 'phone', 'role_id', 'department_id']) ? 'show' : '' }}"
                            id="collapseExample">
                            <form action="{{ route('post.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.post.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                       value="{{ request()->name ?? '' }}"
                                                       placeholder="{{ trans('language.post.name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.post.active') }}</label>
                                                <select class="form-control form-control-sm select2" name="active">
                                                    <option value="" {{ request()->active === null ? 'selected' : '' }}>--Chọn--</option>
                                                    <option value="1" {{ request()->active == 1 ? 'selected' : '' }}>Hiển thị</option>
                                                    <option value="0" {{ request()->active === '0' ? 'selected' : '' }}>Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.post.hot') }}</label>
                                                <select class="form-control form-control-sm select2" name="hot">
                                                    <option value="" {{ request()->hot === null ? 'selected' : '' }}>--Chọn--</option>
                                                    <option value="1" {{ request()->hot == 1 ? 'selected' : '' }}>Nổi bật</option>
                                                    <option value="0" {{ request()->hot === '0' ? 'selected' : '' }}>Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mr-2">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-search"></i>{{ trans('language.search') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <a href="{{ route('post.index') }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%;">#</th>
                                        <th class="text-center" style="width: 20%;">{{ trans('language.post.name') }}</th>
                                        <th class="text-center"style="width: 10%;">{{ trans('language.post.image_path') }}</th>
                                        <th class="text-center" style="width: 30%;">{{ trans('language.post.description') }}</th>
                                        <th class="text-center" style="width: 10%;">{{ trans('language.post.active') }}</th>
                                        <th class="text-center" style="width: 10%;">{{ trans('language.post.hot') }}</th>
                                        <th class="text-center" style="width: 15%;">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($listPost->count() > 0)
                                        @foreach ($listPost as $key => $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($listPost->currentPage() - 1) * $listPost->perPage() }}
                                                </td>
                                                <td class="text-left">
                                                    {{ $item->name }}
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="w-100">
                                                </td>
                                                <td>{!! $item->description !!}</td>
                                                <td class="text-center">
                                                    <button
                                                        class="toggle-active-btn btn {{ $item->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                        data-id="{{ $item->id }}" data-status="{{ $item->active }}"
                                                        data-url="{{ route('post.changeActive') }}">
                                                        {{ $item->active == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        class="toggle-hot-btn btn {{ $item->hot == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                        data-id="{{ $item->id }}" data-status="{{ $item->hot }}"
                                                        data-url="{{ route('post.changeHot') }}">
                                                        {{ $item->hot == 1 ? 'Nổi bật' : 'Ẩn' }}
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a class="flex items-center mr-3"
                                                            href="{{ route('post.edit', ['id' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ trans('language.edit') }}
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_banner') }}"
                                                            data-text="<span>{{ $item->name }}</span>"
                                                            data-url="{{ route('post.delete', ['id' => $item->id]) }}"
                                                            data-method="DELETE" data-icon="question">
                                                            <i class="fas fa-trash-alt"></i>
                                                            {{ trans('language.delete') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center"> {{ trans('language.no-data') }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    {{ $listPost->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
