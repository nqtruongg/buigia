@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.categoryService.add'),
        'middle_page' => trans('language.categoryService.title'),
        'current_page' => trans('language.categoryService.add'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                        <a href="{{ route('categoryService.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.categoryService.add') }}</a>
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
                            <form action="{{ route('banner.index') }}" method="get">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.categoryService.name') }}</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="name" value="{{ request()->categoryService ?? '' }}"
                                                        placeholder="{{ trans('language.categoryService.name') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>{{ trans('language.categoryService.parent_id') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control" name="parent_id">
                                                            <option value="" disabled selected>--chọn--</option>
                                                            @foreach ($categoryServices as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}
                                                                </option>
                                                                @if (count($category->childrenRecursive) > 0)
                                                                    @include('components.child-category', [
                                                                        'children' => $category->childrenRecursive,
                                                                        'depth' => 1,
                                                                    ])
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
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
                                        <th class="text-center">{{ trans('language.categoryService.name') }}</th>
                                        <th class="text-center">{{ trans('language.categoryService.description') }}</th>
                                        <th class="text-center">{{ trans('language.categoryService.active') }}</th>
                                        <th class="text-center">{{ trans('language.categoryService.hot') }}</th>
                                        <th class="text-center">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($_GET['parent_id']))
                                        @if ($listCategoryServiceByCate->count() > 0)
                                            @foreach ($listCategoryServiceByCate as $key => $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $key + 1 + ($listCategoryServiceByCate->currentPage() - 1) * $listCategoryServiceByCate->perPage() }}
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="nav-icon fas {{ $item->child_count > 0 ? 'fa-folder-open' : 'fa-file' }}"></i>
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ route('categoryService.index') . '?parent_id=' . $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td>{{ $item->description }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            class="toggle-active-btn btn {{ $item->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                            data-id="{{ $item->id }}"
                                                            data-status="{{ $item->active }}"
                                                            data-url="{{ route('categoryService.changeActive') }}">
                                                            {{ $item->active == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="toggle-hot-btn btn {{ $item->hot == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                            data-id="{{ $item->id }}"
                                                            data-status="{{ $item->hot }}"
                                                            data-url="{{ route('categoryService.changeHot') }}">
                                                            {{ $item->hot == 1 ? 'Nổi bật' : 'Ẩn' }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="flex justify-center items-center">
                                                            <a class="flex items-center mr-3"
                                                                href="{{ route('categoryService.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                class="flex items-center text-danger deleteTable"
                                                                data-id="{{ $item->id }}"
                                                                data-title="{{ trans('message.confirm_delete_category_post') }}"
                                                                data-text="<span>{{ $item->name }}</span>"
                                                                data-url="{{ route('categoryService.delete', ['id' => $item->id]) }}"
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
                                    @else
                                        @if ($categoryServices->count() > 0)
                                            @foreach ($categoryServices as $key => $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $key + 1 + ($categoryServices->currentPage() - 1) * $categoryServices->perPage() }}
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="nav-icon fas {{ $item->child_count > 0 ? 'fa-folder-open' : 'fa-file' }}"></i>
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ route('categoryService.index') . '?parent_id=' . $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td>{{ $item->description }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            class="toggle-active-btn btn {{ $item->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                            data-id="{{ $item->id }}"
                                                            data-status="{{ $item->active }}"
                                                            data-url="{{ route('categoryService.changeActive') }}">
                                                            {{ $item->active == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="toggle-hot-btn btn {{ $item->hot == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                            data-id="{{ $item->id }}"
                                                            data-status="{{ $item->hot }}"
                                                            data-url="{{ route('categoryService.changeHot') }}">
                                                            {{ $item->hot == 1 ? 'Nổi bật' : 'Ẩn' }}
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="flex justify-center items-center">
                                                            <a class="flex items-center mr-3"
                                                                href="{{ route('categoryService.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                class="flex items-center text-danger deleteTable"
                                                                data-id="{{ $item->id }}"
                                                                data-title="{{ trans('message.confirm_delete_banner') }}"
                                                                data-text="<span>{{ $item->name }}</span>"
                                                                data-url="{{ route('categoryService.delete', ['id' => $item->id]) }}"
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
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    @if(!empty($_GET['parent_id']))
                                        {{ $listCategoryServiceByCate->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    @else
                                        {{ $categoryServices->links('pagination::bootstrap-4') }}
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

@section('js')
@endsection
