@extends('admin.layouts.app')

@section('main')
    <div class="content">
        <!-- Top Statistics -->
        <div class="row">

            {{-- For Customers --}}
            @php $customers = DB::table('customers')->get(); @endphp
            <div class="col-xl-4 col-sm-6">
                <div class="card card-default card-mini">
                    <div class="card-header">
                        <h2>{{ count($customers) }} Customers</h2>
                        <div class="dropdown">
                            <button><a href="#" style="color:black;">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> </button>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper">
                            <div>
                                <div id="spline-area-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- For Categories --}}
            @php $categories = DB::table('item_category')->get();@endphp
            <div class="col-xl-4 col-sm-6">
                <div class="card card-default card-mini">
                    <div class="card-header">
                        <h2>{{ count($categories) }} Categories</h2>
                        <div class="dropdown">
                            <button><a href="#" style="color:black;">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> </button>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper">
                            <div>
                                <div id="spline-area-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- For Owners --}}
            @php $subcategory = DB::table('sub_category')->get();@endphp
            <div class="col-xl-4 col-sm-6">
                <div class="card card-default card-mini">
                    <div class="card-header">
                        <h2>{{ count($subcategory) }} SubCategories</h2>
                        <div class="dropdown">
                            <button><a href="#" style="color:black;">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> </button>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper">
                            <div>
                                <div id="spline-area-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- For stores --}}
            @php $brands = DB::table('brands')->get();@endphp
            <div class="col-xl-4 col-sm-6 py-6">
                <div class="card card-default card-mini">
                    <div class="card-header">
                        <h2>{{ count($brands) }} Brands</h2>
                        <div class="dropdown">
                            <button><a href="#" style="color:black;">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> </button>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper">
                            <div>
                                <div id="spline-area-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- For Products --}}
            @php $subbrands = DB::table('sub_brand')->get();@endphp
            <div class="col-xl-4 col-sm-6 py-6">
                <div class="card card-default card-mini">
                    <div class="card-header">
                        <h2>{{ count($subbrands) }} SubBrands</h2>
                        <div class="dropdown">
                            <button><a href="#" style="color:black;">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> </button>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper">
                            <div>
                                <div id="spline-area-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        @php $customers = DB::table('customers')->get(); @endphp
        <div class="main-card mb-3 card">
            <b><h4><div class="card-header text-center">Customers Details<div class="btn-actions-pane-right">
                    {{-- <div role="group" class="btn-group-sm btn-group"><button class="active btn btn-focus">
                            </button><button class="btn btn-focus"> </button></div> --}}
                </div>
            </div></h4></b>
            @php $i = 0; @endphp

            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name/Email</th>
                            <th class="text-center">Contact</th>
                            {{-- <th class="text-center">Order Status</th> --}}
                            <th class="text-center">Pending Orders</th>
                            <th class="text-center">Payment Status</th>
                        </tr>
                    </thead>
                    @foreach ($customers as $customer)
                        <tbody>
                            @php  $i++ @endphp
                            <tr>
                                <td class="text-center text-muted">{{ $i }}</td>
                                <td>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper d-flex">
                                            <div class="widget-content-left mr-3">
                                                <div class="widget-content-left"><img width="40"
                                                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRdIx5P4tKEkAg4YGcDZbqkaQ3EzfNfZrPOCw&usqp=CAU"
                                                        alt="" class="rounded-circle"></div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading"><b>{{ $customer->name }}</b></div>
                                                <div class="widget-subheading opacity-7">{{ $customer->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $customer->contact_no }}</td>
                                {{-- <td class="text-center">
                                    <div class="badge badge-warning">Pending</div>
                                </td> --}}
                                <td class="text-center" style="width: 150px;"><div class="badge badge-warning"> 0 </div></td>
                                <td class="text-center"><button type="button" class="btn btn-success btn-sm">Done</button>
                                </td>
                            </tr>
                            {{-- <tr>
                            <td class="text-center text-muted">#347</td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left"><img width="40"
                                                    src="./assets/images/avatars/3.jpg" alt=""
                                                    class="rounded-circle"></div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">Ruben Tillman</div>
                                            <div class="widget-subheading opacity-7">Etiam sit amet orci eget</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">Berlin</td>
                            <td class="text-center">
                                <div class="badge badge-success">Completed</div>
                            </td>
                            <td class="text-center" style="width: 150px; position: relative;"> chart </td>
                            <td class="text-center"><button type="button"
                                    class="btn btn-primary btn-sm">Details</button></td>
                        </tr>
                        <tr>
                            <td class="text-center text-muted">#321</td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left"><img width="40"
                                                    src="./assets/images/avatars/2.jpg" alt=""
                                                    class="rounded-circle"></div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">Elliot Huber</div>
                                            <div class="widget-subheading opacity-7">Lorem ipsum dolor sic</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">London</td>
                            <td class="text-center">
                                <div class="badge badge-danger">In Progress</div>
                            </td>
                            <td class="text-center" style="width: 150px; position: relative;"> chart </td>
                            <td class="text-center"><button type="button"
                                    class="btn btn-primary btn-sm">Details</button></td>
                        </tr>
                        <tr>
                            <td class="text-center text-muted">#55</td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left"><img width="40"
                                                    src="./assets/images/avatars/1.jpg" alt=""
                                                    class="rounded-circle"></div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">Vinnie Wagstaff</div>
                                            <div class="widget-subheading opacity-7">UI Designer</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">Amsterdam</td>
                            <td class="text-center">
                                <div class="badge badge-info">On Hold</div>
                            </td>
                            <td class="text-center" style="width: 150px; position: relative;"> chart </td>
                            <td class="text-center"><button type="button"
                                    class="btn btn-primary btn-sm">Details</button></td>
                        </tr> --}}
                        </tbody>
                    @endforeach

                </table>
            </div>
            <div class="d-block text-center card-footer"><button
                    class="mr-2 btn-icon btn-icon-only btn btn-danger">
                    <i class="fa-solid fa-trash"></i></button><button
                    class="btn-wide btn btn-primary">Save</button></div>
        </div>


    </div>
@endsection
