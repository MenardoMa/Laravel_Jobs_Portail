@extends('jobs_portail.layout.layout')

@section('title', '| Login')

@section('content')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Login</h1>
                        <form action="" method="post" name="authenticateForm" id="authenticateForm">
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="example@example.com">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter Password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="justify-content-between d-flex">
                                <button class="btn btn-primary mt-2" id="btn_login">Login</button>
                                <a href="forgot-password.html" class="mt-3">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Do not have an account? <a href="{{ route('auth.sign') }}">Register</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>

@endsection

@section('custom_js')
    {{-- Flash session --}}
    @if (session('success') || session('error'))
        <script>
            window.flash = {
                type: @json(session('success') ? 'success' : 'error'),
                message: @json(session('success') ?? session('error'))
            };
        </script>
    @endif
    {{-- Flash session --}}

    <script>

        function authenticate(e) {
            e.preventDefault()
            const btn_login = $("#btn_login");
            const originalText = btn_login.text();
            let data = $(this).serializeArray();

            // AJAX
            $.ajax({
                url: '{{ route('auth.authenticate') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                dataType: 'JSON',
                beforeSend: function () {
                    btn_login.prop('disabled', true)
                        .html(`<span class="spinner-border spinner-border-sm text-light" role="status"></span> Traitement...`);
                },

                success: function (response) {
                    if (response.status == false && response.type == 'validation_error') {
                        let errors = response.errors
                        showFeedbackError(errors)
                        return
                    } else if (response.status == false && response.type == 'auth_error') {
                        $("#password").val('')
                        notyf.error(response.message);
                    } else if (response.status) {
                        window.location.href = response.redirect;
                    }
                },

                error: function (xhr) {
                    console.log(xhr)
                },

                complete: function () {
                    btn_login.prop('disabled', false).html(originalText)
                }
            })

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

        }

        $(document).ready(function () {
            $("#authenticateForm").submit(authenticate)

            $(document).on('input', '#authenticateForm input', function () {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid')
                        .next('.invalid-feedback')
                        .html('');
                }
            });
        })

        if (window.flash) {
            const type = window.flash.type || 'success';

            if (type === 'success') {
                notyf.success(window.flash.message);
            } else {
                notyf.error(window.flash.message);
            }
        }
    </script>
@endsection