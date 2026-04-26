@extends('jobs_portail.layout.layout')

@section('title', '| Profile')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                @include('jobs_portail.includes.sidebare')
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4">
                        <form action="" method="POST" id="userForm">
                            <div class="card-body p-4">
                                <h3 class="fs-4 mb-1">My Profile</h3>
                                <div class="mb-4">
                                    <label for="name" class="mb-2">Name*</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                        placeholder="Enter Name" class="form-control" value="">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="mb-2">Email*</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        placeholder="Enter Email" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="designation" class="mb-2">Designation*</label>
                                    <input type="text" name="designation" id="designation"
                                        value="{{ old('designation', $user->designation) }}" placeholder="Designation"
                                        class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="mobile" class="mb-2">Mobile*</label>
                                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $user->mobile) }}"
                                        placeholder="Mobile" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="card-footer p-4">
                                <button type="submit" class="btn btn-primary" id="btn_save_generale">Update</button>
                            </div>
                        </form>
                    </div>

                    <div class="card border-0 shadow mb-4">
                        <form action="" method="post" id="userFormPassword">
                            <div class="card-body p-4">
                                <h3 class="fs-4 mb-1">Change Password</h3>
                                <div class="mb-4">
                                    <label for="current_password" class="mb-2">Old Password*</label>
                                    <input type="password" name="current_password" id="current_password"
                                        placeholder="Old Password" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="new_password" class="mb-2">New Password*</label>
                                    <input type="password" name="new_password" id="new_password" placeholder="New Password"
                                        class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="new_password_confirmation" class="mb-2">Confirm Password*</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        placeholder="Confirm Password" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary" id="btn_save_password">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mx-3">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>

        // Update Info
        function updateUserInfo(e) {
            e.preventDefault();
            let btn_save = $("#btn_save_generale");
            let originalText = btn_save.text();
            let data = $(this).serializeArray()

            // AJAX
            $.ajax({
                url: '{{ route('account.update') }}',
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                data: data,
                beforeSend: function () {
                    btn_save.prop('disabled', true)
                        .html(`<span class="spinner-border spinner-border-sm text-light" role="status"></span> Traitement...`);
                },

                success: function (response) {
                    if (response.status == true) {
                        notyf.success(response.message);

                        let user = response.data;

                        $('#name').val(user.name);
                        $("#name_text").text(user.name);
                        $('#email').val(user.email);
                        $('#designation').val(user.designation);
                        $("#designation_text").text(user.designation);
                        $('#mobile').val(user.mobile);

                    }
                },
                error: function (xhr) {
                    let response = xhr.responseJSON;
                    if (response.status == false && response.type == 'validation_error') {
                        showFeedbackError(response.errors)
                        notyf.error(response.message);
                    }
                },

                complete: function () {
                    btn_save.prop('disabled', false).html(originalText)
                }
            })

        }

        // Update Password
        function updateUserPassword(e) {
            e.preventDefault()
            let btn_save = $("#btn_save_password");
            let originalText = btn_save.text();
            let data = $(this).serializeArray()

            // AJAX
            $.ajax({
                url: '{{ route('account.update_password') }}',
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                data: data,
                beforeSend: function () {
                    btn_save.prop('disabled', true)
                        .html(`<span class="spinner-border spinner-border-sm text-light" role="status"></span> Traitement...`);
                },

                success: function (response) {
                    if (response.status == true) {
                        $("#current_password").val('');
                        $("#new_password").val('');
                        $("#new_password_confirmation").val('');
                        notyf.success(response.message);
                    }

                    else if (response.status == false && response.type == 'auth_error') {
                        $("#current_password").val('');
                        $("#new_password").val('');
                        $("#new_password_confirmation").val('');
                        notyf.error(response.message);
                    }
                },
                error: function (xhr) {
                    let response = xhr.responseJSON;
                    if (response.status == false && response.type == 'validation_error') {
                        showFeedbackError(response.errors)
                        notyf.error(response.message);
                    }
                },

                complete: function () {
                    btn_save.prop('disabled', false).html(originalText)
                }
            })
        }

        // ShowFeedBackError
        function showFeedbackError(errors) {
            $.each(errors, function (field, messages) {
                let input = $("#" + field);
                input.addClass("is-invalid");
                let message = Array.isArray(messages)
                    ? messages[0]
                    : messages;
                input.next(".invalid-feedback").html(message);
            });
        }

        // Load
        $(document).ready(function () {
            $('#userForm').on('submit', updateUserInfo);
            $("#userFormPassword").on('submit', updateUserPassword);

            // Saissie caracteres User general info
            $(document).on('input', '#userForm input', function () {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid')
                        .next('.invalid-feedback')
                        .html('');
                }
            });

            // Saissie caracteres User Password
            $(document).on('input', '#userFormPassword input', function () {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid')
                        .next('.invalid-feedback')
                        .html('');
                }
            });
        });
    </script>
@endsection