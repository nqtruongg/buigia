@extends('layout.master')

@section('addcssadmin')
@endsection
@section('bodyadmin')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ trans('language.project') }}</h1>
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
                                    href="{{ route('project.create') }}"><i
                                        class="fa fa-plus pad"></i>Tạo mới</a>
                            </div>

                        </div>
                        <!-- form start -->
                        <table class="table table-bordered table-image">
                            <thead>
                                <tr>
                                    <th class="text-center " scope="col">#</th>
                                    <th class="text-center " scope="col">Dự án</th>
                                    <th class="text-center " scope="col">Khách hàng</th>
                                    <th class="text-center " scope="col">Dạng dự án</th>
                                    <th class="text-center " scope="col">Trạng thái</th>
                                    <th class="text-center " scope="col">Ngày bắt đầu</th>
                                    <th class="text-center " scope="col">Ngày kết thúc</th>
                                    <th class="text-center " scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $idx => $project)
                                    <tr br-name>
                                        <td class="text-center">
                                            {{ isset($idx) ? ($projects->currentPage() - 1) * $projects->perPage() + $idx + 1 : '' }}
                                        </td>
                                        <td class="text-center">{{ $project->name }}</td>
                                        <td class="text-center">{{ $project->customer_name }}</td>
                                        <td class="text-center">{{ $project->type_name }}</td>
                                        <td class="text-center">{{ $project->status_name }}</td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($project->received_date)) }}
                                        </td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($project->reply_date)) }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-sm rounded-0"
                                                href="{{ route('project.edit', ['id' => $project->id]) }}"><i
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
                                {{ $projects->links('pagination::bootstrap-4') }}
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
