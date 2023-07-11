@extends('admin.layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">

    <style>
        body {
            font-family: 'Lato', sans-serif;
        }

        h1 {
            margin-bottom: 40px;
        }

        label {
            color: #333;
        }

        .btn-send {
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            width: 80%;
            margin-left: 3px;
        }

        .help-block.with-errors {
            color: #ff5050;
            margin-top: 5px;

        }

        .card {
            margin-left: 10px;
            margin-right: 10px;
        }
    </style>
@endpush

@section('main')
    <div class="col-lg-12 grid-margin stretch-card py-3">
        <div class="card">
            <div class="card-body">
                <div class="">

                    {{-- <div class="container"> --}}
                    <div class=" text-center mt-5 ">
                        <h1>Bootstrap Contact Form</h1>
                    </div>

                    <div class="row ">
                        <div class="col-lg-7 mx-auto">
                            <div class="card mt-2 mx-auto p-4 bg-light">
                                <div class="card-body bg-light">

                                    <div class="container">
                                        <form id="edititem_form" role="form">
                                            <div class="controls">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect12">Select Brand</label>
                                                            <select class="form-control selectpicker border"
                                                                data-live-search="true" id="brand_type" name="brand_type">

                                                                <option value="">Select Brand</option>
                                                                @if (isset($brands))
                                                                    @foreach ($brands as $brand)
                                                                        <option value="{{ $brand->id }}" {{$itemmaster->brand_id == $brand->id ? 'selected' : ''}}>
                                                                            {{ $brand->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group category">
                                                            <label for="exampleFormControlSelect12">Select SubBrand</label>
                                                            <select class="form-control selectpicker" id="subbrand_type"
                                                                name="subbrand_type" data-live-search="true">
                                                                <option value="">Select SubBrand</option>
                                                                @if (isset($subbrands))
                                                                    @foreach ($subbrands as $subbrand)
                                                                        <option value="{{ $subbrand->id }}" {{$itemmaster->sub_brand_id == $subbrand->id ? 'selected' : ''}}>
                                                                            {{ $subbrand->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlSelect12">Select Category</label>
                                                        <select class="form-control selectpicker" id="category_type"
                                                            name="category_type" data-live-search="true">
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}" {{$itemmaster->category_id == $category->id ? 'selected' : ''}}>{{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group category">
                                                            <label for="exampleFormControlSelect12">Select
                                                                SubCategory</label>
                                                            <select class="form-control selectpicker" id="subcategory_type"
                                                                name="subcategory_type" data-live-search="true">
                                                                <option value="">Select Subcategory</option>
                                                                @foreach ($subcategories as $subcategory)
                                                                <option value="{{ $subcategory->id }}" {{$itemmaster->subcategory_id == $subcategory->id ? 'selected' : ''}}>{{ $subcategory->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="name">Item Name:</label>
                                                                <input type="text" class="form-control" placeholder="Enter Item Name"
                                                                    id="item_name" name="item_name" value="{{@$itemmaster->item_name}}">
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="name">Item Code:</label>
                                                                <input type="text" class="form-control" placeholder="Enter Item Name"
                                                                    id="item_code" name="item_code" value="{{@$itemmaster->item_code}}">
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="name">Item SellPrice:</label>
                                                                <input type="text" class="form-control" placeholder="Enter Item Name"
                                                                    id="sellprice" name="sellprice" min="0" value="{{@$itemmaster->sellprice}}">
                                                            </div>
                                                        </div>



                                                    <div class="col-md-12">

                                                        <input type="submit"
                                                            class="btn btn-success btn-send  pt-2 btn-block
                                            "
                                                            value="Update">

                                                    </div>

                                                </div>


                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                    {{-- </div> --}}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function(){
            
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

            
            $("#edititem_form").validate({
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
                    item_code: {
                        required: true,
                    },
                    item_name: {
                        required: true,
                    }

                },
                submitHandler: function(form, e) {
                    e.preventDefault();
                    var id = "{{Crypt::encryptString($itemmaster->id)}}";
                    console.log(id);
                    var form = $("#edititem_form")[0];
                    var data = new FormData(form);
                    data.append('id', id);
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
                                window.location.href = "{{route('admin.itemmaster.create')}}";
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
            });

        });
    </script>
@endpush
