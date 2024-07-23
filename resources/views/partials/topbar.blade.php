{{-- <div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $titleTab }}</li>
        </ol>
    </nav>
    <!-- END: Breadcrumb -->

    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button"
            aria-expanded="false" data-tw-toggle="dropdown">
            <img alt="Midone - HTML Admin Template" src="{{ asset('/storage/default-user.jpg') }}">
        </div>
        <div class="dropdown-menu w-56">
            <ul class="dropdown-content bg-primary text-white">
                <li class="p-2">
                    <div class="font-medium">tên người đăng nhập</div>
                    <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <a style="cursor: pointer;" class="dropdown-item hover:bg-white/5" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i>
                        Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Account Menu -->
</div> --}}


<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ $count }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="max-width:400px">
                <span class="dropdown-item dropdown-header">{{ $count }} Thông báo</span>
                @if ($noti1 > 0)
                    <div class="dropdown-divider"></div>
                    <a href="{{route('noti.oneDay')}}" class="dropdown-item">
                        <i class="fas fa-exclamation mr-2"></i> {{ $noti1 }} dịch vụ hết hạn trong một ngày tới
                        <span class="float-right text-muted text-sm"></span>
                    </a>
                @endif
                @if ($noti7 > 0)
                    <div class="dropdown-divider"></div>
                    <a href="{{route('noti.sevenDay')}}" class="dropdown-item">
                        <i class="fas fa-exclamation mr-2"></i> {{ $noti7 }} dịch vụ hết hạn trong bảy ngày tới
                        <span class="float-right text-muted text-sm"></span>
                    </a>
                @endif
                @if ($noti30 > 0)
                    <div class="dropdown-divider"></div>
                    <a href="{{route('noti.thirtyDay')}}" class="dropdown-item">
                        <i class="fas fa-exclamation mr-2"></i> {{ $noti30 }} dịch vụ hết hạn trong ba mươi ngày
                        tới
                        <span class="float-right text-muted text-sm"></span>
                    </a>
                    <div class="dropdown-divider"></div>
                @endif
                {{-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
            </div>
        </li>
		<li class="nav-item">
            <a href="" class="nav-link"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">

                <i class="fas fa-sign-out-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
