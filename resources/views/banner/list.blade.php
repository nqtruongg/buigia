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
                                aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
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
                        <div class="collapse {{ optional(request())->hasAny(['name', 'email', 'phone', 'role_id', 'department_id']) ? 'show' : '' }}"
                             id="collapseExample">
                            <form action="{{ route('banner.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.banner.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                       value="{{ request()->name ?? '' }}"
                                                       placeholder="{{ trans('language.banner.name') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{ trans('language.banner.parent_id') }}<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" name="parent_id">
                                                        <option disabled selected>--chọn--</option>
                                                        @foreach($parentBanner as $category)
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
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ trans('language.banner.name') }}</th>
                                    <th class="text-center">{{ trans('language.banner.hot') }}</th>
                                    <th class="text-center">{{ trans('language.banner.active') }}</th>
                                    <th class="text-center">{{ trans('language.banner.order') }}</th>
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
                                                    <td>
                                                        <a href="{{ route('banner.index').'?parent_id='. $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td>{{ $item->hot }}</td>
                                                    <td>{{ $item->active }}</td>
                                                    <td>{{ $item->order }}</td>
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
                                                    <td>
                                                        <a href="{{ route('banner.index').'?parent_id='. $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td>{{ $item->hot }}</td>
                                                    <td>{{ $item->active }}</td>
                                                    <td>{{ $item->order }}</td>
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
                                    {{ $listBanner->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
