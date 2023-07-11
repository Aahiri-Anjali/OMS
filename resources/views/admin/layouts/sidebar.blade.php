@push('css')
    <script src="https://kit.fontawesome.com/68c42cf296.js" crossorigin="anonymous"></script>
@endpush
<aside class="left-sidebar sidebar-dark" id="left-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand">
            <a href="{{route('admin.dashboard')}}">
                <img src={{ asset('admin/images/logo.png') }} alt="Mono">
                <span class="brand-name">  OMS </span>
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-left" data-simplebar style="height: 100%;">
            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">

                <li class="{{Request::routeIs('admin.dashboard') ? 'active' : ''}}">
                    <a class="sidenav-item-link" href="{{route('admin.dashboard')}}">
                        <i class="mdi mdi-briefcase-account-outline"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="section-title">
                    Dashboard Elements
                </li>
                @can('itemcategory-view')
                <li class="{{ Request::routeIs('admin.category.create') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.category.create')}}">
                        <i class="fa-solid fa-mobile"></i>
                        <span class="nav-text">Item Category</span>
                    </a>
                </li>
                @endcan

                @can('subcategory-view')
                <li class="{{ Request::routeIs('admin.subcategory.create') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.subcategory.create')}}">
                        <i class="fa-solid fa-building"></i>                        
                        <span class="nav-text">Sub Category</span>
                    </a>
                </li>
                @endcan 

                @can('brand-view')
                <li class="{{ Request::routeIs('admin.brand.create') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.brand.create')}}">
                        <i class="fa-solid fa-square"></i>
                        <span class="nav-text">Brands</span>
                    </a>
                </li>
                @endcan

                @can('subbrand-view')
                <li class="{{ Request::routeIs('admin.subbrand.create') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.subbrand.create')}}">
                        <i class="fa-solid fa-table"></i>
                        <span class="nav-text">Sub Brands</span>
                    </a>
                </li>
                @endcan

                @can('customer-view')
                <li class="{{ Request::routeIs('admin.customer.create') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.customer.create')}}">
                        <i class="fa-solid fa-user-tie"></i>
                    <span class="nav-text pl-2">Customers</span>
                    </a>
                </li>
                @endcan

                @can('itemmaster-view')
                <li class="{{ Request::routeIs('admin.itemmaster.create') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.itemmaster.create')}}">
                        <i class="fa-solid fa-sitemap"></i>                        
                        <span class="nav-text pl-2">Item Master</span>
                    </a>
                </li>
                @endcan

                @can('order-view')
                <li class="{{ Request::routeIs('admin.order.list') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.order.list')}}">
                        <i class="fa-brands fa-first-order"></i>
                    <span class="nav-text pl-2">Orders</span>
                    </a>
                </li>
                @endcan

                @can('user-view')
                <li class="{{ Request::routeIs('admin.user.create') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.user.create')}}">
                        <i class="fa-solid fa-user"></i>
                    <span class="nav-text pl-2">Users</span>
                    </a>
                </li>
                @endcan

                @can('role-view')
                <li class="{{ Request::routeIs('admin.role.index') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{route('admin.role.index')}}">
                        <i class="fa-solid fa-users"></i>
                    <span class="nav-text pl-2">Role and Permission</span>
                    </a>
                </li>
                @endcan
                

                {{-- <li class="{{ Request::routeIs('admin.brand.index') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.brand.index') }}">
                        <i class="fa-solid fa-bars"></i>
                        <span class="nav-text">Brand</span>
                    </a>
                </li> --}}

            </ul>

        </div>

        <div class="sidebar-footer">
            <div class="sidebar-footer-content">
                <ul class="d-flex">
                    <li>
                        <a href="#" data-toggle="tooltip" title="User Panel settings"><i
                                class="mdi mdi-settings"></i></a>
                    </li>
                    <li>
                        <a href="#" data-toggle="tooltip" title="No chat messages"><i
                                class="mdi mdi-chat-processing"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
