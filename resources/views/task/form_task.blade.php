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
                                    {{ Route::is('task.create') ? 'Tạo mới công việc' : 'Chỉnh sửa công việc' }}
                                </h3>
                            </div>

                            <div class="card-body-task">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên công việc:</label>
                                    <input type="text" class="form-control" id="slug" placeholder="Nhập công việc"
                                        name="name"
                                        value="{{ old('name') ? old('name') : (isset($task->title) ? $task->title : '') }}">
                                    @if ($errors->first('name'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body-task grid-body">
                                <div class="form-group pdr5">
                                    <label>Dự án:</label>
                                    <select class="form-control select2bs4" id="project_id" style="width: 100%;"
                                        name="project_id">
                                        @php
                                            $choose_project = old('project_id') ? old('project_id') : (isset($task->project_id) ? $task->project_id : '');
                                        @endphp
                                        <option value="">Chọn dự án</option>
                                        @foreach ($projects as $project)
                                            <option @if ($choose_project == $project->id) selected @endif
                                                value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->first('project_id'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('project_id') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group pdl5">
                                    <label>Loại công việc:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="type">
                                        @php
                                            $choose_type = old('type') ? old('type') : (isset($task->type) ? $task->type : '');
                                        @endphp
                                        <option value="">Chọn loại công việc</option>
                                        @foreach ($task_types as $task_types)
                                            <option @if ($choose_type == $task_types->id) selected @endif
                                                value="{{ $task_types->id }}">{{ $task_types->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->first('type'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('type') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body-task">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả:</label>
                                    <textarea name="description" class="w-100" id="">{{old('description') ? old('description') : (isset($task->description) ? $task->description : '')}}</textarea>
                                    @if ($errors->first('description'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body-task grid-body">
                                <div class="form-group pdr5">
                                    <label>Phân công cho:</label>
                                    <select class="form-control select2bs4" id="members" style="width: 100%;" name="user_id">
                                        @php
                                            $choose_project = old('user_id') ? old('user_id') : (isset($task->user_id) ? $task->user_id : '');
                                        @endphp
                                        <option value="">Chọn nhân viên</option>
                                        @if(isset($members))
                                            @foreach ($members as $member)
                                            <option @if ($choose_project == $member->user_id) selected @endif
                                                value="{{ $member->user_id }}">{{ $member->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->first('user_id'))
                                        <div class="invalid-alert text-danger">
                                            {{ $errors->first('user_id') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group pdl5">
                                    <div class="card-body-task grid-body">
                                        <div class="form-group pdr5">
                                            <label>Ngày bắt đầu:</label>
                                            <div class="input-group date" id="reservationdatetime"
                                                data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#reservationdatetime" name="started_at"
                                                    placeholder="Nhập thời gian bắt đầu"
                                                    value="{{ old('started_at') ? old('started_at') : (isset($task->started_at) ? date('d/m/Y', strtotime($task->started_at)) : '') }}" />
                                                <div class="input-group-append" data-target="#reservationdatetime"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            @if ($errors->first('started_at'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('started_at') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group pdl5">
                                            <label>Ngày kết thúc:</label>
                                            <div class="input-group date" id="reservationdatetime2"
                                                data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#reservationdatetime2" name="ended_at"
                                                    placeholder="Nhập thời gian kết thúc"
                                                    value="{{ old('ended_at') ? old('ended_at') : (isset($task->ended_at) ? date('d/m/Y', strtotime($task->ended_at)) : '') }}" />
                                                <div class="input-group-append" data-target="#reservationdatetime2"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            @if ($errors->first('ended_at'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('ended_at') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group pdr5">
                                    <label>Trạng thái công việc:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="status">
                                        @php
                                            $choose_status = old('status') ? old('status') : (isset($task->status) ? $task->status : '');
                                        @endphp
                                        @foreach ($task_status as $item)
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

                                <div class="form-group pdl5">
                                    <div class="card-body-task grid-body">
                                        <div class="form-group pdr5">
                                            <label>Thời gian dự kiến:</label>
                                            <input type="number" class="form-control" id="slug"
                                                placeholder="Nhập thời gian" name="estimate_time"
                                                value="{{ old('estimate_time') ? old('estimate_time') : (isset($task->estimate_time) ? $task->estimate_time : '') }}">
                                            @if ($errors->first('estimate_time'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('estimate_time') }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-group pdl5">
                                            <label>Phần trăm hoàn thành:</label>
                                            <input type="number" class="form-control" id="slug" min="0" max="100"
                                                placeholder="Nhập % hoàn thành" name="percent"
                                                value="{{ old('percent') ? old('percent') : (isset($task->percent) ? $task->percent : '') }}">
                                            @if ($errors->first('percent'))
                                                <div class="invalid-alert text-danger">
                                                    {{ $errors->first('percent') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit"
                                    class="btn btn-primary">{{ Route::is('task.create') ? 'Tạo mới' : 'Cập nhật' }}</button>
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

    <script>
        $(document).on('change', '#project_id', function() {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-Token": $('input[name="_token"]').val(),
                },
                url: "{{ route('task.getMember') }}",
                data: {
                    id: id,
                },
                success: function(response) {
                    $(".option-member").remove();

                    let option = "";
                    for (let i = 0; i < response.members.length; i++) {
                        option +=
                            `<option class"option-member" value="`+response.members[i].user_id+`">`+response.members[i].name+`</option>`;
                    }
                    $("#members").append(option);
                },
            });
        })
    </script>
@endsection
