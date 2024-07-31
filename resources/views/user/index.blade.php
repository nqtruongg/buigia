@extends('layout.master')

@section('css')
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.user.title'),
        'current_page' => trans('language.user.title'),
    ])

    <section class="content">
        <div class="container-fluid pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mr-2" data-toggle="collapse" href="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i></button>
                        <a href="{{ route('user.create') }}" type="button" class="btn btn-info">
                            <i class="fas fa-plus"></i>{{ trans('language.user.add') }}</a>
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
                            <form action="{{ route('user.index') }}" method="get">
                                <div class="card-header">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.user.name') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    value="{{ request()->first_name ?? '' }}"
                                                    placeholder="{{ trans('language.user.first_name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.phone') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="phone"
                                                    value="{{ request()->phone ?? '' }}"
                                                    placeholder="{{ trans('language.phone') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('language.email') }}</label>
                                                <input type="text" class="form-control form-control-sm" name="email"
                                                    value="{{ request()->email ?? '' }}"
                                                    placeholder="{{ trans('language.email') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>{{ trans('language.department.title') }}</label>
                                                <select class="form-control form-control-sm select2" name="department_id"
                                                    id="department_id">
                                                    <option selected="selected" value="">Phòng ban</option>
                                                    @foreach ($departments as $item)
                                                        <option @if (request()->department_id == $item->id) selected @endif
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>{{ trans('language.role.title') }}</label>
                                                <select class="form-control form-control-sm select2" id="role_id"
                                                    name="role_id">
                                                    <option selected="selected" value=" ">Vai trò</option>
                                                    @foreach ($roles as $item)
                                                        <option @if (request()->role_id == $item->id) selected @endif
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
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
                                                <a href="{{ route('user.index') }}" class="btn btn-success btn-sm"><i
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
                                        <th class="text-center">{{ trans('language.user.name') }}</th>
                                        <th class="text-center">{{ trans('language.number_phone') }}</th>
                                        <th class="text-center">{{ trans('language.email') }}</th>
                                        <th class="text-center">{{ trans('language.department.title') }}</th>
                                        <th class="text-center">{{ trans('language.role.title') }}</th>
                                        <th class="text-center">Hoa hồng tháng này</th>
                                        <th class="text-center">Tổng tiền hoa hồng</th>
                                        <th class="text-center">{{ trans('language.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->count() > 0)
                                        @foreach ($users as $key => $item)
                                            @php
                                                $total_commission_month = \App\Models\CommissionBonus::where(
                                                    'user_id',
                                                    $item->id,
                                                )
                                                    ->whereMonth('created_at', date('m'))
                                                    ->sum('price');

                                                $total_commssion = \App\Models\CommissionBonus::where(
                                                    'user_id',
                                                    $item->id,
                                                )->sum('price');
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($users->currentPage() - 1) * $users->perPage() }}
                                                </td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->department_name }}</td>
                                                <td>{{ $item->role_name }}</td>
                                                <td class="text-center">{{ number_format($total_commission_month) }}đ</td>
                                                <td class="text-center">{{ number_format($total_commssion) }}đ</td>
                                                <td class="text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a class="flex items-center mr-3"
                                                            href="{{ route('user.edit', ['id' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ trans('language.edit') }}
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                            class="flex items-center text-danger deleteTable"
                                                            data-id="{{ $item->id }}"
                                                            data-title="{{ trans('message.confirm_delete_user') }}"
                                                            data-text="<span >{{ $item->full_name }}</span>"
                                                            data-url="{{ route('user.delete', ['id' => $item->id]) }}"
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
                                            <td colspan="7" class="text-center"> {{ trans('language.no-data') }} </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                <div class="text-center">
                                    {{ $users->links('pagination::bootstrap-4') }}
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
