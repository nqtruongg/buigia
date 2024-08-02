@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
    <style>
        .border-left-primary {
            border-left: .25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: .25rem solid #1cc88a !important;
        }

        .border-left-danger {
            border-left: .25rem solid #ef1717 !important;
        }

        .border-left-secondary {
            border-left: .25rem solid #b9c2bf !important;
        }
    </style>
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => 'Trang chủ',
        'current_page' => 'Dashboard',
    ])
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                        Tổng doanh số</div>
                                    @if (auth()->user()->department->type == 'manager')
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format(\App\Models\Receipt::sum(\DB::raw('CAST(REPLACE(price, \',\', \'\') AS UNSIGNED)')), 0, ',', ',') }}đ
                                        </div>
                                    @else
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format(\App\Models\Receipt::where('user_id', auth()->user()->id)->sum(\DB::raw('CAST(REPLACE(price, \',\', \'\') AS UNSIGNED)')), 0, ',', ',') }}đ
                                        </div>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-md font-weight-bold text-success text-uppercase mb-1">
                                        @if (auth()->user()->department->type == 'manager')
                                            Tổng hoa hồng phải chi
                                        @else
                                            Tổng hoa hồng nhận được
                                        @endif
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        @if (auth()->user()->department->type == 'manager')
                                            {{ number_format(\App\Models\CommissionBonus::sum('price')) ?? 0 }}đ
                                    </div>
                                @else
                                    {{ number_format(\App\Models\CommissionBonus::where('user_id', auth()->user()->id)->sum('price')) ?? 0 }}đ
                                </div>
                                @endif
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @if(auth()->user()->department->type !== 'manager')
        <div class="container-fluid">
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-md font-weight-bold text-danger text-uppercase mb-1">
                                        Hoa hồng tháng này</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format(\App\Models\CommissionBonus::where('user_id', auth()->user()->id)
                                            ->whereMonth('created_at', date('m'))
                                            ->whereYear('created_at', date('Y'))
                                            ->sum('price')) ?? 0 }}đ
                                        </div>
                                    </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-md font-weight-bold text-secondary text-uppercase mb-1">
                                            Khách hàng của tôi
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ \App\Models\Customer::where('user_id', auth()->user()->id)->count() }}
                                    </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif
        @if (auth()->user()->department->type == 'manager')
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ App\Models\Customer::count() }}</h3>

                            <p>Khách hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('customer.index') }}" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $noti30 }}</h3>

                            <p>Dịch vụ hết hạn sau 30 ngày</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('noti.thirtyDay') }}" class="small-box-footer">Xem thêm<i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $noti7 }}</h3>

                            <p>Dịch vụ hết hạn sau 7 ngày</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('noti.sevenDay') }}" class="small-box-footer">Xem thêm<i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $noti1 }}</h3>

                            <p>Dịch vụ hết hạn sau 1 ngày</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('noti.oneDay') }}" class="small-box-footer">Xem thêm<i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        @endif
        @if (auth()->user()->department->type == 'manager')
            <div class="row">
                <div class="col-md-12">
                    <!-- BAR CHART -->
                    <div class="d-flex align-items-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('language.started_at') }}</label>
                                <input name="from" type="text" placeholder="{{ trans('language.started_at') }}"
                                    value="{{ request()->from ?? '' }}"
                                    class="datepicker_start form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('language.ended_at') }}</label>
                                <input name="to" type="text" placeholder="{{ trans('language.ended_at') }}"
                                    value="{{ request()->to ?? '' }}" class="datepicker_end form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-1 filter">
                            <div class="form-group d-flex flex-column">
                                <label>&nbsp;</label>
                                <button id="fillter_date" type="button" class="btn btn-primary btn-sm">Lọc</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ trans('language.ended_at') }}</label>
                                <select class="form-control form-control-sm" name="" id="filter">
                                    <option class="choose-data" value="week">Lọc theo tuần</option>
                                    <option class="choose-data" value="month">Lọc theo tháng</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê doanh số</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thống kê</h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <label for="">Thống kê khách hàng:</label>
                            <ul>
                                @foreach ($customers as $item)
                                    <li>
                                        <p>{{ $item->name }}: <span>{{ $item->total_customers }}</span></p>
                                    </li>
                                    <li>
                                        <p>Tổng số nhân viên kinh doanh:
                                            <span>{{ \App\Models\User::where('department_id', 3)->where('role_id', 5)->count() }}</span>
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Báo giá mới nhất</h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <label for="">Danh sách báo giá:</label>
                            <ul>
                                @foreach ($price_quote as $item)
                                    <li><a
                                            href="{{ route('priceQuote.detail', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/home.js') }}"></script>
@endsection
