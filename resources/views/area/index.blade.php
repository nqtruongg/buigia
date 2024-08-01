@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.area.title'),
        'current_page' => trans('language.area.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                        <a href="{{ route('area.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.area.add') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="collapse {{ optional(request())->hasAny(['name', 'email', 'phone', 'code', 'tax_code', 'career']) ? 'show' : '' }}"
                            id="collapseExample">
                            <form action="{{ route('area.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('language.area.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    value="{{ request()->name ?? '' }}"
                                                    placeholder="{{ trans('language.area.name') }}">
                                            </div>
                                        </div>
                                        <div class="mr-2">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-sm"><i
                                                        class="fas fa-search"></i>{{ trans('language.search') }}</button>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="form-group d-flex flex-column">
                                                <label>&nbsp;</label>
                                                <a href="{{ route('area.index') }}" class="btn btn-success btn-sm"><i
                                                        class="fas fa-sync-alt"></i></a>
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
                                        <th class="text-center" style="width: 20px;">Folder</th>
                                        <th class="text-center">{{ trans('language.area.name') }}</th>
                                        <th class="text-center">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($_GET['city_id']))
                                        @if ($districts->count() > 0)
                                            @foreach ($districts as $key => $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $key + 1 + ($districts->currentPage() - 1) * $districts->perPage() }}
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="nav-icon fas {{ $item->child_count > 0 ? 'fa-folder-open' : 'fa-file' }}"></i>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('area.index').'?district_id='. $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="flex justify-center items-center">
                                                            <a class="flex items-center mr-3"
                                                               href="{{ route('area.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                               class="flex items-center text-danger deleteTable"
                                                               data-id="{{ $item->id }}"
                                                               data-title="{{ trans('message.confirm_delete_area') }}"
                                                               data-text="<span >{{ $item->name }}</span>"
                                                               data-url="{{ route('area.delete', ['id' => $item->id]) }}"
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
                                                <td colspan="9" class="text-center"> {{ trans('language.no-data') }} </td>
                                            </tr>
                                        @endif
                                    @elseif(!empty($_GET['district_id']))
                                        @if ($communes->count() > 0)
                                            @foreach ($communes as $key => $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $key + 1 + ($communes->currentPage() - 1) * $communes->perPage() }}
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="nav-icon fas fa-file"></i>
                                                    </td>
                                                    <td>
                                                        {{ $item->name }}
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="flex justify-center items-center">
                                                            <a class="flex items-center mr-3"
                                                               href="{{ route('area.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                               class="flex items-center text-danger deleteTable"
                                                               data-id="{{ $item->id }}"
                                                               data-title="{{ trans('message.confirm_delete_area') }}"
                                                               data-text="<span >{{ $item->name }}</span>"
                                                               data-url="{{ route('area.delete', ['id' => $item->id]) }}"
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
                                                <td colspan="9" class="text-center"> {{ trans('language.no-data') }} </td>
                                            </tr>
                                        @endif
                                    @else
                                        @if ($cities->count() > 0)
                                            @foreach ($cities as $key => $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $key + 1 + ($cities->currentPage() - 1) * $cities->perPage() }}
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="nav-icon fas {{ $item->child_count > 0 ? 'fa-folder-open' : 'fa-file' }}"></i>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('area.index').'?city_id='. $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="flex justify-center items-center">
                                                            <a class="flex items-center mr-3"
                                                               href="{{ route('area.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ trans('language.edit') }}
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                               class="flex items-center text-danger deleteTable"
                                                               data-id="{{ $item->id }}"
                                                               data-title="{{ trans('message.confirm_delete_area') }}"
                                                               data-text="<span >{{ $item->name }}</span>"
                                                               data-url="{{ route('area.delete', ['id' => $item->id]) }}"
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
                                                <td colspan="9" class="text-center"> {{ trans('language.no-data') }} </td>
                                            </tr>
                                        @endif
                                    @endif

                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    @if(!empty($_GET['district_id']))
                                        {{ $communes->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    @elseif(!empty($_GET['city_id']))
                                        {{ $districts->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    @else
                                        {{ $cities->appends(request()->query())->links('pagination::bootstrap-4') }}
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
