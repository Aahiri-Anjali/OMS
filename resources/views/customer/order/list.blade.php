@extends('customer.layouts.app')

@push('css')
    <style>
        .center {
            width: 150px;
            margin: 40px auto;

        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush

@section('main')
    {{-- @can('order-create') --}}
        <li class="nav-item d-flex align-items-center justify-content-end m-2">
            <a class="btn btn-outline-primary btn-sm mb-0 me-3" id="add_order" data-bs-target="#orderModal"
                data-bs-toggle="modal">Create Order</a>
        </li>
    {{-- @endcan --}}

    <div class="modal fade" id="orderModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="orderForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Orders</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editid">

                        <div class="form-group" id="item_div">
                            <label for="exampleFormControlSelect12">Select Item</label>
                            <select class="form-control selectpicker border" data-live-search="true" id="item"
                                name="item" data-live-search="true">

                                <option value="">Select Item</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger" id="item_error"></span>


                        <div class="form-group py-2" id="item_price">
                            <label class="form-label" for="">Item Price</label>
                            <input type="text" class="form-control border" id="price" name="price" disabled>
                        </div>

                        <div class="d-flex">
                            <div class="form-group">
                                <button type="button" class="btn btn-success btn-sm m-2 quantity-left-plus"
                                    id="quantity-right-plus">Increment</button>
                            </div>

                            <div class="form-group">
                                <input type="number" value="1" class="form-control m-2 border" min="1"
                                    id="quantity" name="quantity">
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-danger btn-sm m-2 quantity-left-minus"
                                    id="quantity-left-minus">Decrement</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit" id="save">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Orders table</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-bordered">
                            {{ $dataTable->table() }}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function() {
            var quantitiy = 0;
            $('#quantity-right-plus').click(function(e) {
                var quantity = parseInt($('#quantity').val());
                $('#quantity').val(quantity + 1);
            });

            $('#quantity-left-minus').click(function(e) {
                var quantity = parseInt($('#quantity').val());
                if (quantity > 0) {
                    $('#quantity').val(quantity - 1);
                }
            });

            $('#add_order').click(function() {
                $('#item_price').hide();
                $('#item-error').text('');
                $('#orderForm')[0].reset();
            });

            $('#item').on('change', function() {
                var id = $(this).val();
                $.ajax({
                    url: "{{ route('customer.order.price') }}",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#item_price').show();
                            $('#price').val(response.data.sellprice);
                        }
                    }

                });
            });

            $("#orderForm").validate({
                errorClass: "text-danger",
                rules: {
                    item: {
                        required: true,
                    }
                },
                submitHandler: function(form, e) {
                    e.preventDefault();
                    var form = $('#orderForm')[0];
                    var data = new FormData(form);
                    var submit = $('.submit').attr('id');
                    var id = $('#editid').val();
                    if (submit == 'update') {
                        data.append('id', id);
                    } else {
                        data.append('id', 0);
                    }
                    $.ajax({
                        url: "{{ route('customer.order.store') }}",
                        method: "POST",
                        dataType: "json",
                        data: data,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $(document).find('span.text-danger').text('');
                        },
                        success: function(response) {
                            if (response.status == 200) {

                                toastr.success(response.data);
                                $('.close').click();
                                window.LaravelDataTables['orderdatatable-table']
                                    .draw();
                            }
                            if (response.status == 422) {
                                $('#seat').text(response.data);
                            }
                        },
                        error: function(response) {
                            $.each(response.responseJSON.errors, function(key,
                                value) {

                                var error = "#" + key + "_error";
                                $(error).text(value);
                            });
                        },
                    })

                },
            });

            $(document).on('click', '#edit', function() {
                var id = $(this).val();
                var url = "{{ route('customer.order.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "get",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            $('#item').val(response.data.item_id);
                            $('#editid').val(response.data.id);
                            $('#price').val(response.data.price);
                            $('#quantity').val(response.data.quantity);
                            $('#save').attr('id', 'update');
                        }
                    },
                });
            });

            $(document).on('click', '#delete', function() {
                var id = $(this).val();
                var url = "{{ route('customer.order.destroy', ['id' => ':id']) }}";
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

        });
    </script>
@endpush
