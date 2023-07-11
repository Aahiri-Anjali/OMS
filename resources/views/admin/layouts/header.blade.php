<header class="main-header" id="header">
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
        <!-- Sidebar toggle button -->
        <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span>
        </button>

        <span class="page-title">dashboard</span>

        <div class="navbar-right ">

            <!-- search form -->


            <ul class="nav navbar-nav">
                {{-- @php $pending_stores = DB::table('stores')->where('request_status',0)->get(); @endphp --}}

                <li class="custom-dropdown">
                    <button class="notify-toggler custom-dropdown-toggler" data-toggle="dropdown">
                        <i class="mdi mdi-bell-outline icon"></i>
                        <span class="badge badge-xs rounded-circle">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" >
                        <div class="dropdown-notify" style="display: block;">

                            <header>
                                <div class="nav nav-underline" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="all-tabs" data-toggle="tab" href="#all"
                                        role="tab" aria-controls="nav-home" aria-selected="true">All (0)</a>
                                </div>
                            </header>
                            <div class="" data-simplebar="init" style="height: 150px;">
                                <div class="simplebar-wrapper" style="margin: 0px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper"
                                                style="height: 100%; overflow: hidden scroll;">
                                                <div class="simplebar-content" style="padding: 0px;">
                                                    <div class="tab-content" id="myTabContent">

                                                        <div class="tab-pane fade show active" id="all"
                                                            role="tabpanel" aria-labelledby="all-tabs">

                                                            {{-- @forelse($pending_stores as $store)
                                                            <div class="media media-sm bg-warning-10 p-4 mb-0">
                                                                <div class="media-sm-wrapper">
                                                                    <a href="#">
                                                                        <img src="{{asset('storage/business/storeImg/'.$store->image)}}" class="rounded-circle" height="30px" width="auto"
                                                                            alt="User Image">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <a href="#">
                                                                        <span class="title mb-0">{{$store->name}}</span>
                                                                        <span class="time"><b>{{$store->name}}'s Status is in  <time><span class="badge badge-danger">Pending</span></time> state.....</b>
                                                                           </span>
                                                                        <span class="time">
                                                                            <time></time>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            <div class="media-body py-6">
                                                              <center><b><h3>No one store is in pending state </h3> </b></center> 
                                                            </div>
                                                          @endforelse --}}
                                                       </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: auto; height: 583px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                    <div class="simplebar-scrollbar"
                                        style="height: 181px; display: block; transform: translate3d(0px, 0px, 0px);">
                                    </div>
                                </div>
                            </div>
                            <footer class="border-top dropdown-notify-footer">
                                <div class="d-flex justify-content-between align-items-center py-2 px-4">
                                  <span>Last updated 3 min ago</span>
                                  <a id="refress-button" href="javascript:" class="btn mdi mdi-cached btn-refress"></a>
                                </div>
                              </footer>

                        </div>
                    </ul>
                </li>


                <!-- User Account -->
                <li class="dropdown user-menu">
                    <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <img src={{ asset('admin/images/user/user-xs-01.jpg') }} class="user-image rounded-circle"
                            alt="User Image" />
                        <span class="d-none d-lg-inline-block">Admin</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a class="dropdown-link-item" href="#">
                                <i class="fa-solid fa-unlock-keyhole"></i>
                                <span class="nav-text">Change Password</span>
                            </a>
                        </li>

                        <li class="dropdown-footer">
                            <a class="dropdown-link-item" href="{{ route('admin.logout') }}">
                                <i class="mdi mdi-logout"></i>
                                <span class="nav-text">Log out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
