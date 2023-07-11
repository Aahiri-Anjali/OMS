@extends('admin.layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
@endpush

@section('main')
    <div class="modal" id="itemModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-content">
                <form id="categoryForm">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Upload Data</h4>
                        <button type="button" class="close" data-dismiss="modal"
                            onclick="this.form.reset();">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="form-holder">
                                <div class="form-content">

                                    <div class="form-group category">
                                        <label for="exampleFormControlSelect12">Select Brand</label>
                                        <select class="form-control selectpicker" data-live-search="true" id="brand_type"
                                            name="brand_type">

                                            <option value="">Select Brand</option>
                                            @if (isset($brands))
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group category">
                                        <label for="exampleFormControlSelect12">Select SubBrand</label>
                                        <select class="form-control selectpicker" id="subbrand_type" name="subbrand_type"
                                            data-live-search="true">
                                            <option value="">Select SubBrand</option>
                                        </select>
                                    </div>

                                    <div class="form-group category">
                                        <label for="exampleFormControlSelect12">Select Category</label>
                                        <select class="form-control selectpicker" id="category_type" name="category_type"
                                            data-live-search="true">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group category">
                                        <label for="exampleFormControlSelect12">Select SubCategory</label>
                                        <select class="form-control selectpicker" id="subcategory_type"
                                            name="subcategory_type" data-live-search="true">
                                            <option value="">Select Brand</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Item Name:</label>
                                        <input type="text" class="form-control" placeholder="Enter Item Name"
                                            id="item_name" name="item_name">
                                    </div>
                                    <span class="text-danger" id="item_name_error"></span>

                                    {{-- <div class="form-group">
                                        <label for="name">Item Code:</label>
                                        <input type="text" class="form-control" placeholder="Enter Item Name"
                                            id="item_code" name="item_code">
                                    </div>
                                    <span class="text-danger" id="item_code_error"></span> --}}

                                    <div class="form-group">
                                        <label for="name">Item SellPrice:</label>
                                        <input type="text" class="form-control" placeholder="Enter Item Name"
                                            id="sellprice" name="sellprice" min="0">
                                    </div>
                                    <span class="text-danger" id="sellprice_error"></span>

                                    <!-- Modal footer -->
                                    <div class="form-button">
                                        <button type="submit" class="btn btn-primary submit" id="save">save</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="close"
                                            onclick="this.form.reset();">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="col-lg-12 grid-margin stretch-card py-3">
        <div class="card">
            <div class="card-body">
                @can('itemmaster-create')
                <div class="float-right px-2 py-2">
                    <button type="button" id="addItem" class="btn btn-primary" data-target="#itemModal"
                        data-toggle="modal">Add Item</button>
                </div>
                @endcan
                <div class="float-left px-2 py-2">
                    <a role="button" id="addItem" class="btn btn-danger" href="{{route('admin.itemmaster.pdf')}}"
                        ><i class="fa-solid fa-file-pdf"></i>  PDF</a>
                </div>
                <div class="float-left px-2 py-2">
                    <a role="button" id="addItem" class="btn btn-success" href="{{route('admin.itemmaster.excel')}}"
                        ><i class="fa-solid fa-file-excel"></i>  Excel</a>
                </div>
                <div class="float-right px-2 py-2">
                    {{-- <label for="exampleFormControlSelect12">Select Category</label> --}}
                    <select class="form-control selectpicker" id="categories" name="categories" data-live-search="true">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-right px-2 py-2">
                    <select class="form-control selectpicker" id="subcategories" name="subcategories"
                        data-live-search="true">
                        <option value="">Select SubCategory</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-right px-2 py-2">
                    <select class="form-control selectpicker" id="brands" name="brands" data-live-search="true">
                        <option value="">Select Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-right px-2 py-2">
                    <select class="form-control selectpicker" id="subbrands" name="subbrands" data-live-search="true">
                        <option value="">Select SubBrand</option>
                        @foreach ($subbrands as $subbrand)
                            <option value="{{ $subbrand->id }}">{{ $subbrand->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <h4 class="card-title">Customers Table</h4> --}}
                <div class="table-responsive">
                    <div class="table table-responsive table" id="myDataTable">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>

    {{-- <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script> --}}

    <script>

        $('#categories').on('change', function(e) {
            if (e.type == 'submit') {
                e.preventDefault();
            }
            setTimeout(function() {
                $('#subcategories').val('');
                $('#brands').val('');
                $('#subbrands').val('');

                window.LaravelDataTables['itemmasterdatatable-table'].draw();
            }, 500);
        });
        $('#subcategories').on('change', function(e) {
            if (e.type == 'submit') {
                e.preventDefault();
            }
            setTimeout(function() {
                $('#categories').val('');
                $('#brands').val('');
                $('#subbrands').val('');
                window.LaravelDataTables['itemmasterdatatable-table'].draw();
            }, 500);
        });
        $('#brands').on('change', function(e) {
            if (e.type == 'submit') {
                e.preventDefault();
            }
            setTimeout(function() {
                $('#subcategories').val('');
                $('#categories').val('');
                $('#subbrands').val('');
                window.LaravelDataTables['itemmasterdatatable-table'].draw();
            }, 500);
        });
        $('#subbrands').on('change', function(e) {
            if (e.type == 'submit') {
                e.preventDefault();
            }
            setTimeout(function() {
                $('#subcategories').val('');
                $('#categories').val('');
                $('#brands').val('');
                window.LaravelDataTables['itemmasterdatatable-table'].draw();
            }, 500);
        });

        $('#itemmasterdatatable-table').on('preXhr.dt', function(e, settings, data) {
            data.category = $('#categories').val();
            data.subcategory = $('#subcategories').val();
            data.brand = $('#brands').val();
            data.subbrand = $('#subbrands').val();
            console.log(data.subbrand);
        });

        $('.close,#close').click(function() {
            $("#categoryForm")[0].reset();
            $("#name-error").hide();
            $('#name_error').text('');
            $('#brand_type-error').text('');
            $('#subbrand_type-error').text('');
            $('#subcategory_type-error').text('');
            $('#item_code-error').text('');
            $('#item_name-error').text('');
            $('#sellprice-error').text('');
            $('#category_type-error').text('');
            // $('.filter-option-inner-inner').text('Select ');
        });

        $(document).on('click', '#addItem', function() {
            // $("#itemModal").reload();
            $("#categoryForm")[0].reset();
            $(".submit").attr('id', 'save');
            // $('.filter-option-inner-inner').text('Select ');
        });

        $("#categoryForm").validate({
            errorClass: "text-danger",
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                },
                brand_type: {
                    required: true,
                },
                subbrand_type: {
                    required: true,
                },
                category_type: {
                    required: true,
                },
                subcategory_type: {
                    required: true,
                },
                sellprice: {
                    required: true,
                },
                item_name: {
                    required: true,
                }

            },
            submitHandler: function(form, e) {
                e.preventDefault();
                var form = $("#categoryForm")[0];
                var data = new FormData(form);
                $.ajax({
                    url: "{{ route('admin.itemmaster.store') }}",
                    method: "POST",
                    dataType: "json",
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $(document).find('span.text-danger').text('');
                    },
                    success: function(response) {
                        if (response.status == 200) {

                            toastr.success(response.data);
                            $('#itemModal').modal('hide');
                            window.LaravelDataTables['itemmasterdatatable-table']
                                .draw();
                        }
                    },
                    error: function(response) {
                        $.each(response.responseJSON.errors, function(key, value) {

                            var error = "#" + key + "_error";
                            $(error).text(value);
                        });
                    },
                })
            },
            highlight: function(element, errorClass, validClass) {
                $(element)
                    .parent("div.form-group")
                    .addClass(errorClass)
                    .removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element)
                    .parent("div.form-group")
                    .removeClass(errorClass)
                    .addClass(validClass);
            },
        });

        $(document).on('click', '#delete', function() {
            var id = $(this).val();
            var url = "{{ route('admin.itemmaster.destroy', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Data!..",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        js_delete(url);
                    }
                });
        });

        $('#brand_type').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('admin.itemmaster.brand') }}",
                type: "post",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == 200) {
                        var html =
                            `<select class="form-control selectpicker"  data-live-search="true" id="subbrand_type" name="subbrand_type"><option value="">Select SubBrand</option>`;
                        $('#subbrand_type').html(html);
                        $.each(response.data, function(index, value) {
                            $("#subbrand_type").append('<option value="' + value
                                .id + '">' +
                                value.name + '</option>');
                        });
                        html = "</select>";
                        $('#subbrand_type').selectpicker('refresh');
                    }
                }

            })
        });

        $('#category_type').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('admin.itemmaster.category') }}",
                type: "post",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == 200) {
                        var html =
                            `<select class="form-control "  data-live-search="true" id="subcategory_type" name="subcategory_type"><option value="">Select SubCategory</option>`;
                        $('#subcategory_type').html(html);
                        $.each(response.data, function(index, value) {
                            $("#subcategory_type").append('<option value="' + value
                                .id + '">' +
                                value.name + '</option>');
                        });
                        html = "</select>";
                        $('#subcategory_type').selectpicker('refresh');
                    }
                }
            })
        });

        // $('#category').change(function() {
        //     var id = $(this).val();
        //     $.ajax({
        //         url: "{{ route('admin.itemmaster.category') }}",
        //         type: "post",
        //         dataType: "json",
        //         data: {
        //             id: id
        //         },
        //         success: function(response) {
        //             if (response.status == 200) {

        //             }
        //         }
        //     });
        // })
    </script>
@endpush
