@extends('admin.layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"> --}}
@endpush

@section('main')
    <div class="modal" id="customerModal" data-backdrop="static" tabindex="-1" role="dialog"
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
                                    <input type="hidden" id="edit">

                                    <div class="form-group">
                                        <label for="email">Customer Email:</label>
                                        <input type="email" class="form-control" placeholder="Enter Email" id="email"
                                            name="email">
                                    </div>
                                    <span class="text-danger" id="email_error"></span>

                                    <div class="form-group">
                                        <label for="password" id="pass_label">Customer Password:</label>
                                        <input type="password" class="form-control" placeholder="Enter Password"
                                            id="password" name="password">
                                    </div>
                                    <span class="text-danger" id="password_error"></span>

                                    <div class="form-group">
                                        <label for="name">Customer Name:</label>
                                        <input type="text" class="form-control" placeholder="Enter Name" id="name"
                                            name="name">
                                    </div>
                                    <span class="text-danger" id="name_error"></span>

                                    <div class="form-group">
                                        <label for="contact_no">Contact No:</label>
                                        <input type="text" class="form-control" placeholder="Enter Contact"
                                            id="contact_no" name="contact_no">
                                    </div>
                                    <span class="text-danger" id="contact_no_error"></span>

                                    <div class="form-group">
                                        <label for="vatno">VAT NO:</label>
                                        <input type="text" class="form-control" placeholder="Enter VAT NO" id="vatno"
                                            name="vatno">
                                    </div>
                                    <span class="text-danger" id="vatno_error"></span>

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
                @can('customer-create')
                    <div class="float-right px-2 py-2">
                        <button type="button" id="addCustomer" class="btn btn-primary" data-target="#customerModal"
                            data-toggle="modal">Add
                            Customer</button>
                    </div>
                @endcan
                
                <h4 class="card-title">Customers Table</h4>
                <div class="table-responsive">
                    <div class="table table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> --}}

    {!! $dataTable->scripts() !!}

    <script>
        $(document).on('click', '#addCustomer', function() {
            $("#categoryForm")[0].reset();
            $('#name_error').text('');
            $('#name-error').text('');
            $('#contact_no-error').text('');
            $('#vatno-error').text('');
            $(".submit").attr('id', 'save');
            $('#password').show();
            $('#pass_label').show();
            $('#email').attr('disabled', false);
        });

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#categoryForm").validate({
                errorClass: "text-danger",
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                    name: {
                        required: true,
                        minlength: 3,
                    },
                    contact_no: {
                        required: true,
                        number: true,
                    },
                    vatno: {
                        required: true,
                        number: true,
                    }

                },
                submitHandler: function(form, e) {
                    e.preventDefault();
                    var id = $('#edit').val();
                    var form = $("#categoryForm")[0];
                    var data = new FormData(form);
                    var submitBtnId = $(".submit").attr('id');
                    if (submitBtnId == 'update') {
                        data.append('id', id);
                    }
                    $.ajax({
                        url: "{{ route('admin.customer.store') }}",
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
                                $('#customerModal').modal('hide');
                                window.LaravelDataTables['customerdatatable-table']
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
        });


        $(document).on('click', '#edit', function() {
            var id = $(this).val();
            var url = "{{ route('admin.customer.edit', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $('#name').val(response.data.name);
                        $('#edit').val(response.data.id);
                        $('#contact_no').val(response.data.contact_no);
                        $('#vatno').val(response.data.VATNO);
                        $('#email').val(response.data.email);
                        $('#email').attr('disabled', true);
                        $('#password').hide();
                        $('#pass_label').hide();
                        $('#password').val(response.data.password);
                        $('#save').attr('id', 'update');
                    }
                },
            });
        });

        $(document).on('click', '#delete', function() {
            var id = $(this).val();
            var url = "{{ route('admin.customer.destroy', ['id' => ':id']) }}";
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
                        window.LaravelDataTables['itemcategorydatatable-table'].draw();
                    }
                });
        });
    </script>
@endpush
