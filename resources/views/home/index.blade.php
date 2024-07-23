@extends('layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    @include('partials.breadcrumb', [
        'title' => 'Trang chủ',
        'current_page' => 'Dashboard',
    ])
    <section class="content">
        <div class="container-fluid">
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
                                        <li><p>{{$item->name}}: <span>{{$item->total_customers}}</span></p></li>
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
                                        <li><a href="{{route('priceQuote.detail', ['id' => $item->id])}}">{{$item->name}}</a></p></li>
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
