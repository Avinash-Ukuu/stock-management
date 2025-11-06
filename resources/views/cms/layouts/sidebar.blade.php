<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Stock Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name ?? 'N/A' }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- User Management -->
                @can('admin', new App\Models\User())
                    <li class="nav-item @if (in_array(Route::currentRouteName(), ['user.index', 'role.index', 'module.index', 'permission.index'])) menu-open @endif">
                        <a href="#" class="nav-link  @if (in_array(Route::currentRouteName(), ['user.index', 'role.index', 'module.index', 'permission.index'])) active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p> User Management <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}"
                                    class="nav-link @if (Route::currentRouteName() == 'user.index') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('role.index') }}"
                                    class="nav-link @if (Route::currentRouteName() == 'role.index') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('permission.index') }}"
                                    class="nav-link @if (Route::currentRouteName() == 'permission.index') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('module.index') }}"
                                    class="nav-link @if (Route::currentRouteName() == 'module.index') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Modules</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                <!-- /.User Management -->

                <!-- Department -->
                <li class="nav-item">
                    <a href="{{ route('department.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Department</p>
                    </a>
                </li>
                <!-- /.Department -->

                <!-- /.Stock Management -->
                <li class="nav-item @if (in_array(Route::currentRouteName(), ['category.index', 'stock.index','stock-item.index','stock-usage.index','stock-usage.create'])) menu-open @endif">
                    <a href="#" class="nav-link  @if (in_array(Route::currentRouteName(), ['category.index', 'stock.index','stock-item.index','stock-usage.index','stock-usage.create'])) active @endif">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p> Stock Management <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}"
                                class="nav-link @if (Route::currentRouteName() == 'category.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock.index') }}"
                                class="nav-link @if (Route::currentRouteName() == 'stock.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-item.index') }}"
                                class="nav-link @if (Route::currentRouteName() == 'stock-item.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Item List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-usage.index') }}"
                                class="nav-link @if (Route::currentRouteName() == 'stock-usage.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Usage List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-usage.create') }}"
                                class="nav-link @if (Route::currentRouteName() == 'stock-usage.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Assign Stock Form</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.Stock Management -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
