@extends('layout.master')

@section('addcssadmin')
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.css') }}">
@endsection

@section('bodyadmin')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dự án</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="{{ $method }}" action="{{ $action }}" class="product-vali"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card ">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ Route::is('project.create') ? 'Tạo mới dự án' : 'Chỉnh sửa dự án' }}
                                </h3>
                            </div>
                            <div class="card-body grid-body">
                                <div class="form-group pdr5">
                                    <label for="exampleInputEmail1">Tên dự án:</label>
                                    <input type="text" class="form-control" id="slug" placeholder="Nhập tên dự án"
                                        name="name"
                                        value="{{ old('name') ? old('name') : (isset($project->name) ? $project->name : '') }}">
                                    @if ($errors->first('name'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group pdl5">
                                    <label>Chủ đầu tư:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="customer_id">
                                        @php
                                            $choose_brand = old('customer_id') ? old('customer_id') : (isset($project->customer_id) ? $project->customer_id : '');
                                        @endphp
                                        <option value="">Chọn khách hàng</option>
                                        @foreach ($customers as $customer)
                                            <option @if ($choose_brand == $customer->id) selected @endif
                                                value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->first('customer_id'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('customer_id') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group pdr5">
                                    <label>Dạng dự án:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="type">
                                        @php
                                            $choose_type = old('type') ? old('type') : (isset($project->type) ? $project->type : '');
                                        @endphp
                                        <option value="">Chọn dạng dự án</option>
                                        @foreach ($types as $type)
                                            <option @if ($choose_type == $type->id) selected @endif
                                                value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->first('type'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('type') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group pdl5">
                                    <label>Trạng thái dự án:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="status">
                                        @php
                                            $choose_status = old('status') ? old('status') : (isset($project->status) ? $project->status : '');
                                        @endphp
                                        <option value="">Chọn trạng thái dự án</option>
                                        @foreach ($status as $item)
                                            <option @if ($choose_status == $item->id) selected @endif
                                                value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->first('status'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('status') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group pdr5">
                                    <label>Ngày bắt đầu:</label>
                                    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input"
                                            data-target="#reservationdatetime" name="received_date"
                                            placeholder="Nhập ngày nhận"
                                            value="{{ old('received_date') ? old('received_date') : (isset($project->received_date) ? date('d/m/Y', strtotime($project->received_date)) : '') }}" />
                                        <div class="input-group-append" data-target="#reservationdatetime"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @if ($errors->first('received_date'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('received_date') }}
                                        </div>
                                    @endif

                                </div>
                                <div class="form-group pdl5">
                                    <label>Ngày kết thúc:</label>
                                    <div class="input-group date" id="reservationdatetime2" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input"
                                            data-target="#reservationdatetime2" name="reply_date"
                                            placeholder="Nhập ngày trả"
                                            value="{{ old('reply_date') ? old('reply_date') : (isset($project->reply_date) ? date('d/m/Y', strtotime($project->reply_date)) : '') }}" />
                                        <div class="input-group-append" data-target="#reservationdatetime2"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @if ($errors->first('reply_date'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('reply_date') }}
                                        </div>
                                    @endif

                                </div>

                                <div class="form-group pdr5">
                                    <label for="exampleInputEmail1">Chi phí:</label>
                                    <input type="number" class="form-control" id="slug" placeholder="Nhập chi phí"
                                        name="price"
                                        value="{{ old('price') ? old('price') : (isset($project->price) ? $project->price : '') }}">
                                    @if ($errors->first('price'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('price') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group pdl5">
                                    <label for="exampleInputEmail1">Chiết khấu:</label>
                                    <input type="number" class="form-control" id="slug"
                                        placeholder="Nhập khuyến mãi" name="discount"
                                        value="{{ old('discount') ? old('discount') : (isset($project->discount) ? $project->discount : '') }}">
                                    @if ($errors->first('discount'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('discount') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Thành viên dự án:</label>
                                    @php
                                        $choose_member = old('member') ? old('member') : (isset($members) ? $members : '');
                                    @endphp
                                    <select class="form-control" id="member" style="width: 100%;" multiple="multiple"
                                        name="member[]">
                                        @foreach ($users as $user)
                                            <option @if (!empty($choose_member) && in_array($user->id, $choose_member)) selected @endif
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->first('member'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('member') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ghi chú:</label>
                                    <textarea name="note" id="" style="width:100%">{{ old('note') ? old('note') : (isset($project->note) ? $project->note : '') }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit"
                                    class="btn btn-primary">{{ Route::is('project.create') ? 'Tạo mới' : 'Cập nhật' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection
@section('addjsadmin')
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script>
        $(".select2").select2();

        //Initialize Select2 Elements
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });
    </script>

    <script>
        $('#member').select2({
            tag: true,
            theme: "bootstrap4",
            tokenSeparators: [',', ' ']
        })
    </script>
@endsection
