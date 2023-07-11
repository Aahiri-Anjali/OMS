@extends('admin.layouts.app')


@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    
@endpush


@section('main')
    <div class="col-lg-12 grid-margin stretch-card py-3">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Create Role & Permissions</h4>
                <form id="roleForm">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Role Name">
                        <span class="text-danger" id="name_error"></span>
                    </div>
                    <br><br>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th>List</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permission_modules as $permission_module)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input module" type="checkbox"
                                                id="{{ @$permission_module->module }}">
                                            <label class="form-check-label">
                                                {{ @$permission_module->module }}
                                            </label>
                                        </div>
                                    </td>
                                    @php
                                        $permissions_name = DB::table('permissions')
                                            ->where('module', $permission_module->module)
                                            ->get();
                                    @endphp
                                    @foreach ($permissions_name as $permission_name)
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input permission" type="checkbox"
                                                    id="{{ @$permission_name->name }}" name="permission">
                                                <label class="form-check-label">
                                                    {{ @$permission_name->name }}
                                                </label>
                                            </div>
                                        </td>
                                        <span class="text-danger" id="permission_error"></span>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <center><button type="submit" class="btn btn-primary" id="submit">Submit</button></center>

                </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.module', function() {

                var modules = $(this).attr('id');

                if ($(this).is(':checked', true)) {
                    $("#" + modules + "-view").prop('checked', true);
                    $("#" + modules + "-create").prop('checked', true);
                    $("#" + modules + "-update").prop('checked', true);
                    $("#" + modules + "-delete").prop('checked', true);
                    $("#" + modules + "-status").prop('checked', true);
                } else {
                    $("#" + modules + "-view").prop('checked', false);
                    $("#" + modules + "-create").prop('checked', false);
                    $("#" + modules + "-update").prop('checked', false);
                    $("#" + modules + "-delete").prop('checked', false);
                    $("#" + modules + "-status").prop('checked', false);
                }
            });


            $('#submit').on('click', function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var permissions = [];
                $.each($("input[name='permission']:checked"), function() {
                    permissions.push($(this).attr('id'));
                });

                $.ajax({
                    url: "{{ route('admin.role.store') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        name: name,
                        permissions: permissions,
                    },
                    beforeSend: function() {
                        $(document).find('span.text-danger').text('');
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#roleForm')[0].reset();
                            toastr.success(response.data);
                            $('#permission_error').text('');
                            window.location.href = "{{route('admin.role.index')}}";

                        }
                        if (response.status == 400) {
                            $('#permission_error').text(response.data);
                        }
                    },
                    error: function(response) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            var error = "#" + key + "_error";
                            $(error).text(value);
                        });
                    },
                });
            });

        });
    </script>
@endpush
