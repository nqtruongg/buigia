@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => trans('language.customer.detail'),
        'middle_page' => trans('language.customer.title'),
        'current_page' => trans('language.customer.detail'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    @php
                        if ($customer->status == 2) {
                            $class_stt = 'background-info';
                        } elseif ($customer->status == 3) {
                            $class_stt = 'background-success';
                        } else {
                            $class_stt = '';
                        }
                    @endphp
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title pt-1">{{ trans('language.customer.info') }}</h3>
                            <div class="card-tools">
                                <a class="btn btn-tool" href="{{ route('customer.edit', ['id' => $customer->id]) }}">
                                    <i class="fas fa-edit"></i>
                                    {{ trans('language.edit') }}
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-sm-12">
                                <b>{{ trans('language.customer.name') }}:</b> <span>{{ $customer->name }}</span><br>
                                <b>{{ trans('language.customer.code') }}:</b> <span>{{ $customer->code }}</span><br>
                                <b>{{ trans('language.customer.responsible_person') }}:</b>
                                <span>{{ $customer->responsible_person }}</span><br>
                                <b>{{ trans('language.customer.tax_code') }}:</b>
                                <span>{{ $customer->tax_code }}</span><br>
                                <b>{{ trans('language.phone') }}:</b> <span><a
                                        href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></span><br>
                                <b>{{ trans('language.email') }}:</b> <span><a
                                        href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></span><br>
                                <b>{{ trans('language.customer.status') }}:</b>
                                <span class="{{ $class_stt }}">{{ $customer->status_name }}</span><br>
                                <b>{{ trans('language.customer.address') }}:</b> <span>{{ $customer->address }}</span><br>
                                <b>{{ trans('language.customer.invoice_address') }}:</b>
                                <span>{{ $customer->invoice_address }}</span><br>
                                <b>{{ trans('language.customer.supplier') }}:</b>
                                <span>{{ $customer->supplier }}</span><br>
                                <b>{{ trans('language.customer.career') }}:</b> <span>{{ $customer->career }}</span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="col-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <div class="nav nav-tabs justify-content-between" id="custom-tabs-four-tab" role="tablist">
                                    <div class="d-flex">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                                href="#custom-tabs-four-home" role="tab"
                                                aria-controls="custom-tabs-four-home"
                                                aria-selected="true">{{ trans('language.customer.document') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="{{ route('customer.dialog', ['id' => $customer->id]) }}">{{ trans('language.customer.dialog') }}</a>
                                        </li>
                                    </div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="collapse"
                                            data-target="#multiCollapseExample1" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-toggle="collapse"
                                            data-target="#multiCollapseExample2" aria-expanded="false"
                                            aria-controls="multiCollapseExample2">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-home-tab">
                                        <div class="row">
                                            <div class="col">
                                                <div class="collapse multi-collapse {{ request()->has(['name', 'from', 'to']) ? 'show' : '' }}"
                                                    id="multiCollapseExample1">
                                                    <form action="{{ route('customer.detail', ['id' => $customer->id]) }}"
                                                        method="get">
                                                        <div class="border row search-file">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>{{ trans('language.file_name') }}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" name="name"
                                                                        value="{{ request()->name ?? '' }}"
                                                                        placeholder="{{ trans('language.file_name') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>{{ trans('language.started_at') }}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm datepicker_start"
                                                                        name="from" value="{{ request()->from ?? '' }}"
                                                                        placeholder="{{ trans('language.started_at') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>{{ trans('language.ended_at') }}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm datepicker_end"
                                                                        name="to" value="{{ request()->to ?? '' }}"
                                                                        placeholder="{{ trans('language.ended_at') }}">
                                                                </div>
                                                            </div>
                                                            <div class="mr-2">
                                                                <div class="form-group d-flex flex-column">
                                                                    <label>&nbsp;</label>
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="">
                                                                <div class="form-group d-flex flex-column">
                                                                    <label>&nbsp;</label>
                                                                    <a href="{{ route('customer.detail', ['id' => $customer->id]) }}"
                                                                        class="btn btn-success btn-sm">
                                                                        <i class="fas fa-sync-alt"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="collapse multi-collapse" id="multiCollapseExample2">
                                                    <form action="{{route('customer.uploadDetail', ['id' => $customer->id])}}" method="post" class="col-12">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="dropzone" id="customerDropzone">
                                                                <div class="fallback">
                                                                    <input type="file" name="file" multiple />
                                                                </div>
                                                                <div class="dz-message">
                                                                    <span>Tải lên file khách hàng</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button class="btn btn-primary btn-sm mr-2"
                                                                type="submit">{{ trans('language.save') }}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>

                                        @if (count($documents) > 0)
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="bt-none"></th>
                                                        <th class="bt-none">{{ trans('language.file_name') }}</th>
                                                        <th class="bt-none">{{ trans('language.file_size') }}</th>
                                                        <th class="bt-none"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($documents as $item)
                                                        <tr>
                                                            <td class="file-block align-middle">
                                                                @if (strpos($item->file_type, 'image/') === 0)
                                                                    <img src="{{ $item->file_path }}" alt="">
                                                                @else
                                                                    <img src="/dist/img/file-default.png" alt="">
                                                                @endif

                                                            </td>
                                                            <td class="align-middle">{{ $item->file_name }}</td>
                                                            <td class="align-middle">{{ $item->file_size }}kb</td>
                                                            <td class="text-right py-0 align-middle">
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{ route('customer.download', ['id' => $customer->id, 'file_name' => $item->file_name]) }}"
                                                                        class="btn btn-info">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-danger deleteTable"
                                                                        data-id="{{ $item->id }}"
                                                                        data-title="{{ trans('message.confirm_delete_file') }}"
                                                                        data-text="<span >{{ $item->file_name }}</span>"
                                                                        data-url="{{ route('customer.deleteFile', ['file_id' => $item->id]) }}"
                                                                        data-method="DELETE" data-icon="question">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <span>{{ trans('language.no-data') }}</span>
                                        @endif

                                        <div>
                                            <div class="text-center">
                                                {{ $documents->links('pagination::bootstrap-4') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        {{-- service --}}
        @include('partials.form-edit-customer-service', [
            'customer' => $customer,
            'services' => $services,
            'list_services' => $list_services,
        ])
    </section>
@endsection

@section('js')
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/customer_detail.js') }}"></script>
    <script>
        function formatDate(dateStr) {
            var parts = dateStr.split('/');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }

        $('#btnSave').on('click', function (e) {
            e.preventDefault();

            let url = $(this).data('url');
            let method = $(this).data('method');
            let form = $(this).closest('form');

            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');

            let bookings = [];
            $('.booking-box').each(function(index) {
                let serviceId = $(this).find('.service_change').val();
                let startDate = formatDate($(this).find('.started_date').val());
                let endDate = formatDate($(this).find('.ended_date').val());
                let currentBookingId = $(this).data('booking-id');

                console.log('ID:', currentBookingId);
                console.log('Service ID:', serviceId);
                console.log('Start Date:', startDate);
                console.log('End Date:', endDate);

                if (serviceId && startDate && endDate) {
                    bookings.push({
                        id: currentBookingId,
                        service_id: serviceId,
                        started_at: startDate,
                        ended_at: endDate,
                    });
                } else {
                    console.error('Một hoặc nhiều giá trị thiếu hoặc không hợp lệ.');
                }
            });


            formData.append('bookings', JSON.stringify(bookings));

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // console.log(response);
                    if(response.bookingError == false) {
                        Swal.fire(
                            response.message
                        );
                    } else {
                        form.submit();
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        xhr.message
                    );
                    // console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
