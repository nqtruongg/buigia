@extends('layout.master')

@section('addcssadmin')
@endsection
@section('bodyadmin')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ trans('language.task') }}</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card ">
                        <div class="card-header">
                            <div class="filter">
                                <div class="search-container">
                                    <form action="">
                                        <input type="text" placeholder="Search.." name="search">
                                        <button type="submit">Submit</button>
                                    </form>
                                </div>
                                <a class="btn btn-success btn-sm rounded-0 create"
                                    href="{{ route('task.create') }}"><i
                                        class="fa fa-plus pad"></i>Tạo mới</a>
                            </div>

                        </div>
                        <!-- form start -->
                        <table class="table table-bordered table-image">
                            <thead>
                                <tr>
                                    <th class="text-center " scope="col">#</th>
                                    <th class="text-center " scope="col">Công việc</th>
                                    <th class="text-center " scope="col">Người đảm nhiệm</th>
                                    <th class="text-center " scope="col">Dự án</th>
                                    <th class="text-center " scope="col">Trạng thái</th>
                                    <th class="text-center " scope="col">% Hoàn thành</th>
                                    <th class="text-center " scope="col">Bắt đầu</th>
                                    <th class="text-center " scope="col">Kết thúc</th>
                                    <th class="text-center " scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $idx => $task)
                                    <tr br-name>
                                        <td class="text-center">
                                            {{ isset($idx) ? ($tasks->currentPage() - 1) * $tasks->perPage() + $idx + 1 : '' }}
                                        </td>
                                        <td class="text-center">{{ $task->title }}</td>
                                        <td class="text-center">{{ $task->user_name }}</td>
                                        <td class="text-center">{{ $task->project_name }}</td>
                                        <td class="text-center">{{ $task->name_status }}</td>
                                        <td class="text-center">{{ $task->percent }}%</td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($task->started_date)) }}
                                        </td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($task->ended_date)) }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-sm rounded-0"
                                                href="{{ route('task.edit', ['id' => $task->id]) }}"><i
                                                    class="fa fa-edit pad"></i>Chỉnh sửa</a>
                                            {{-- @if ($coupon->deleted_at == null)
                                                <a class="btn btn-danger btn-sm rounded-0 deleteTable"
                                                    href="{{ route('admin.coupon.destroy', ['id' => $coupon->id]) }}"
                                                    data-id="{{ $coupon->id }}"
                                                    data-title="{{ trans('message.confirm_delete_coupon') }}"
                                                    data-text="<span >{{ $coupon->name }}</span>"
                                                    data-url="{{ route('admin.coupon.destroy', ['id' => $coupon->id]) }}"
                                                    data-method="DELETE" data-icon="question">
                                                    <i class="fa fa-trash pad"></i>{{ trans('language.delete') }}</a>
                                            @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            <div style="float: right; padding-right: 10px">
                                {{ $tasks->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('addjsadmin')
@endsection
