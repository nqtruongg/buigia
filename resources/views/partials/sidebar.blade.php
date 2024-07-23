<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>


    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            @php
                $user = App\Models\User::select(DB::raw('CONCAT(first_name, " ", last_name) as full_name'))
                    ->where('id', Auth::id())
                    ->first();
            @endphp
            <div class="info">
                <a href="#" class="d-block">{{ $user->full_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Bảng điều khiển
                        </p>
                    </a>
                </li>
                {{-- @dd(auth()->user()->hasPermission('manager', 'view')) --}}
                {{-- department --}}
                @permission('manager', 'view')
                    <li class="nav-item">
                        <a href="{{ route('home.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                {{ trans('language.department.title') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('department.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-columns"></i>
                                    <p>{{ trans('language.department.list') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('department.create') }}" class="nav-link">
                                    <i class="nav-icon far fa-plus-square"></i>
                                    <p>{{ trans('language.department.add') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endpermission

                {{-- role --}}
                @permission('manager', 'view')
                    <li class="nav-item">
                        <a href="{{ route('role.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                {{ trans('language.role.title') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('role.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-columns"></i>
                                    <p>{{ trans('language.role.list') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('role.create') }}" class="nav-link">
                                    <i class="nav-icon far fa-plus-square"></i>
                                    <p>{{ trans('language.role.add') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endpermission

                {{-- user --}}
                <li class="nav-item">
                    <a href="{{ route('home.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('language.user.title') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>{{ trans('language.user.list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.create') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.user.add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- service --}}
                <li class="nav-item">
                    <a href="{{ route('service.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('language.service.title') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('service.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>{{ trans('language.service.list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('service.create') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.service.add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('language.supplier.title') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('supplier.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>{{ trans('language.supplier.list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplier.create') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.supplier.add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- customer --}}
                <li class="nav-item">
                    <a href="{{ route('home.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('language.customer.title') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>{{ trans('language.customer.list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.create') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.customer.add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- receivable --}}
                <li class="nav-item">
                    <a href="{{ route('receivable.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('language.receivable.title') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('receivable.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>{{ trans('language.receivable.list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('receivable.create') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.receivable.new') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('receivable.createExtend') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.receivable.extend') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- price quote --}}
                <li class="nav-item">
                    <a href="{{ route('priceQuote.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('language.price_quote.title') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('priceQuote.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>{{ trans('language.price_quote.list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('priceQuote.create') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.price_quote.add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- receipt --}}
                <li class="nav-item">
                    <a href="{{ route('receipt.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('language.receipt.title') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('receipt.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>{{ trans('language.receipt.list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('receipt.create') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.receipt.add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- payment --}}
                <li class="nav-item">
                    <a href="{{ route('payment.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ trans('language.payment.title') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('payment.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>{{ trans('language.payment.list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payment.create') }}" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>{{ trans('language.payment.add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
