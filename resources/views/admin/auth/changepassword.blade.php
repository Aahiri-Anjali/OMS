@extends('admin.layouts.app')

@section('main')
    <div class="content">
        <div class="d-flex flex-column justify-content-between">
            <div class="row justify-content-center mt-5">
                <div class="col-md-10">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="app-brand w-100 d-flex justify-content-center border-bottom-0">
                                <div class="profile-avata">
                                    <img class="rounded-circle" src="images/user/user-md-01.jpg" alt="Avata Image">
                                    <span class="h5 d-block mt-3 mb-2">Albrecht Straub</span>
                                    <span class="d-block">admin@admin.com</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            <form action="#" id="changepassword">
                                <h5 class="text-dark mb-5">Current Password</h5>
                                <div class="form-group col-md-12 mb-4">
                                    <input type="password" class="form-control input-lg" id="currentpassword"
                                        name="currentpassword" aria-describedby="nameHelp"
                                        placeholder="Enter Current Password">
                                    <span class="text-danger" id="currentpassword_error"></span>
                                </div>

                                <h5 class="text-dark mb-5">New Password</h5>
                                <div class="form-group col-md-12 mb-4">
                                    <input type="password" class="form-control input-lg" id="newpassword" name="newpassword"
                                        aria-describedby="nameHelp" placeholder="Enter New Password">
                                    <span class="text-danger" id="newpassword_error"></span>
                                </div>

                                <h5 class="text-dark mb-5">Confirm Password</h5>
                                <div class="form-group col-md-12 mb-4">
                                    <input type="password" class="form-control input-lg" id="confirmpassword"
                                        name="confirmpassword" aria-describedby="nameHelp"
                                        placeholder="Enter Confirm Password">
                                    <span class="text-danger" id="confirmpassword_error"></span>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" id="submit"
                                        class="btn btn-primary btn-pill mb-4">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $('#submit').click(function(e) {
                e.preventDefault();
                form = $('#changepassword')[0];
                formData = new FormData(form);
                $.ajax({
                    url: "{{ route('admin.changepassword.store') }}",
                    type: "post",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.text-danger').text('');
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#changepassword')[0].reset();
                            window.location.href = response.route;
                        }
                        if (response.status == 400 || response.status == 401) {
                            toastr.error(response.data);
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
