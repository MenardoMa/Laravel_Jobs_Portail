@extends('jobs_portail.layout.layout')

@section('title', '| Create-Job')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Post a Job</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                @include('jobs_portail.includes.sidebare')
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4 ">
                        <form action="{{ route('jobs.create_job_save') }}" method="post" id="formJobs">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Create</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            class="form-control">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $categorie)
                                                <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select" name="job_nature" id="job_nature">
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy"
                                            class="form-control">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            class="form-control">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="location" id="location" name="location"
                                            class="form-control">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Experiences<span class="req">*</span></label>
                                    <select class="form-select" name="experiences" id="experiences">
                                        @foreach ($experiences as $experience)
                                            <option value="{{ $experience->value }}">
                                                {{ $experience->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5"
                                        placeholder="Benefits"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5"
                                        rows="5" placeholder="Responsibility"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" cols="5"
                                        rows="5" placeholder="Qualifications"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords<span class="req">*</span></label>
                                    <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                        class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name" name="company_name"
                                            class="form-control">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location</label>
                                        <input type="text" placeholder="Location" id="company_location"
                                            name="company_location" class="form-control">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" id="company_website" name="company_website"
                                        class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary btn-sm" id="btn_save">Save Job</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
    </section>

@endsection

@section('custom_js')
    <script>
        function createJobs(e) {
            e.preventDefault()
            const btn_save = $("#btn_save")
            const originalText = btn_save.text()
            const form = $(this)

            let method = 'POST';
            let data = form.serializeArray();

            $.ajax({
                url: form.attr('action'),
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: data,
                success: function (response) {
                    if (response.status === false && response.type === 'validation_error') {
                        let errors = response.errors
                        showFeedbackError(errors)
                    }
                },
                error: function (xhr) {
                    console.log(xhr)
                },
                complete: function () {
                    console.log('ok')
                }
            });
        }

        // Return error for validation
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

        $(document).ready(function () {
            $(document).on('submit', '#formJobs', createJobs)

            // Focus inputs
            $(document).on('input', '#formJobs input', function () {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid')
                        .next('.invalid-feedback')
                        .html('');
                }
            });

        });
    </script>
@endsection