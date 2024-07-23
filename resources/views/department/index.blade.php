@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.department.title'),
        'current_page' => trans('language.department.title'),
    ])

    <section class="content">
        @permission('manager', 'add')
            <div class="container-fluid pb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('department.create') }}" type="button" class="btn btn-success">
                                <i class="fas fa-plus"></i>{{ trans('language.department.add') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endpermission
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ trans('language.department.name') }}</th>
                                        <th class="text-center">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $key => $item)
                                        <tr>
                                            <td class="text-center">
                                                {{ $key + 1 + ($departments->currentPage() - 1) * $departments->perPage() }}
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td class="text-center">
                                                <div class="flex justify-center items-center">
                                                    @permission('manager', 'edit')
                                                        <a class="flex items-center mr-3"
                                                            href="{{ route('department.edit', ['id' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ trans('language.edit') }}
                                                        </a>
                                                    @endpermission
                                                    @permission('manager', 'edit')
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_department') }}"
                                                            data-text="<span >{{ $item->name }}</span>"
                                                            data-url="{{ route('department.delete', ['id' => $item->id]) }}"
                                                            data-method="DELETE" data-icon="question">
                                                            <i class="fas fa-trash-alt"></i>
                                                            {{ trans('language.delete') }}
                                                        </a>
                                                    @endpermission
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    {{ $departments->links('pagination::bootstrap-4') }}
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
