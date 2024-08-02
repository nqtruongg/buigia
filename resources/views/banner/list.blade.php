@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.banner.add'),
        'middle_page' => trans('language.banner.title'),
        'current_page' => trans('language.banner.add'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                                aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i>Tìm kiếm nâng cao</button>
                        <a href="{{ route('banner.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.banner.add') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'active', 'hot']) ? 'show' : '' }}"
                             id="collapseExample">
                            <form action="{{ route('banner.index') }}" method="get">
                                @if(!empty($_GET['parent_id']))
                                    <input type="hidden" name="parent_id" value="{{ request()->parent_id }}">
                                @endif
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.banner.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                       value="{{ request()->name ?? '' }}"
                                                       placeholder="{{ trans('language.banner.name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.banner.active') }}</label>
                                                <select class="form-control form-control-sm select2" name="active">
                                                    <option value="" {{ request()->active === null ? 'selected' : '' }}>--Chọn--</option>
                                                    <option value="1" {{ request()->active == 1 ? 'selected' : '' }}>Hiển thị</option>
                                                    <option value="0" {{ request()->active === '0' ? 'selected' : '' }}>Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.banner.hot') }}</label>
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
                                                <a href="{{ route('banner.index') }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Folder</th>
                                    <th class="text-center">{{ trans('language.banner.name') }}</th>
                                    <th class="text-center">{{ trans('language.banner.active') }}</th>
                                    <th class="text-center">{{ trans('language.banner.hot') }}</th>
                                    <th class="text-center">{{ trans('language.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($_GET['parent_id']))
                                        @if ($listBannerByCate->count() > 0)
                                            @foreach ($listBannerByCate as $key => $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $key + 1 + ($listBannerByCate->currentPage() - 1) * $listBannerByCate->perPage() }}
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="nav-icon fas {{ $item->child_count > 0 ? 'fa-folder-open' : 'fa-file' }}"></i>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('banner.index').'?parent_id='. $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="toggle-active-btn btn {{ $item->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                            data-id="{{ $item->id }}" data-status="{{ $item->active }}"
                                                            data-url="{{ route('banner.changeActive') }}">
                                                            {{ $item->active == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="toggle-hot-btn btn {{ $item->hot == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                            data-id="{{ $item->id }}" data-status="{{ $item->hot }}"
                                                            data-url="{{ route('banner.changeHot') }}">
                                                            {{ $item->hot == 1 ? 'Nổi bật' : 'Ẩn' }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="flex justify-center items-center">
                                                            <a class="flex items-center mr-3"
                                                               href="{{ route('banner.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                               class="flex items-center text-danger deleteTable"
                                                               data-id="{{ $item->id }}"
                                                               data-title="{{ trans('message.confirm_delete_banner') }}"
                                                               data-text="<span>{{ $item->name }}</span>"
                                                               data-url="{{ route('banner.delete', ['id' => $item->id]) }}"
                                                               data-method="DELETE"
                                                               data-icon="question">
                                                                <i class="fas fa-trash-alt"></i>
                                                                {{ trans('language.delete') }}
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center"> {{ trans('language.no-data') }} </td>
                                            </tr>
                                        @endif
                                    @else
                                        @if ($listBanner->count() > 0)
                                            @foreach ($listBanner as $key => $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $key + 1 + ($listBanner->currentPage() - 1) * $listBanner->perPage() }}
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="nav-icon fas {{ $item->child_count > 0 ? 'fa-folder-open' : 'fa-file' }}"></i>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('banner.index').'?parent_id='. $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="toggle-active-btn btn {{ $item->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                            data-id="{{ $item->id }}" data-status="{{ $item->active }}"
                                                            data-url="{{ route('banner.changeActive') }}">
                                                            {{ $item->active == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="toggle-hot-btn btn {{ $item->hot == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                            data-id="{{ $item->id }}" data-status="{{ $item->hot }}"
                                                            data-url="{{ route('banner.changeHot') }}">
                                                            {{ $item->hot == 1 ? 'Nổi bật' : 'Ẩn' }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="flex justify-center items-center">
                                                            <a class="flex items-center mr-3"
                                                               href="{{ route('banner.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                               class="flex items-center text-danger deleteTable"
                                                               data-id="{{ $item->id }}"
                                                               data-title="{{ trans('message.confirm_delete_banner') }}"
                                                               data-text="<span>{{ $item->name }}</span>"
                                                               data-url="{{ route('banner.delete', ['id' => $item->id]) }}"
                                                               data-method="DELETE"
                                                               data-icon="question">
                                                                <i class="fas fa-trash-alt"></i>
                                                                {{ trans('language.delete') }}
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center"> {{ trans('language.no-data') }} </td>
                                            </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    @if(!empty($_GET['parent_id']))
                                        {{ $listBannerByCate->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    @else
                                        {{ $listBanner->links('pagination::bootstrap-4') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
