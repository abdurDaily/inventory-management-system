@extends('backend.index')
@section('backend_contains')
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- CSRF Token --}}

    @push('head_btn')
    <a href="{{ route('category.all') }}" class="white_btn3">all categories</a>
        
    @endpush
    <div class="main_content_iner ">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="row justify-content-center">


                @push('url')
                    {!! generateBreadcrumbs() !!}
                @endpush




                {{-- CATEGORY --}}
                <div class="col-lg-6 h-100">
                    <div class="white_card card_height_100 mb_30">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Add new category</h3>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <h6 class="card-subtitle mb-2">Category name</h6>
                            <div class="mb-0">
                                <form action="{{ route('category.store') }}" method="post" class="category_submit"
                                    data-action="{{ route('category.store') }}">
                                    @csrf
                                    <input name="category_name" type="text" class="form-control category_name"
                                        placeholder="Category name">
                                    <p class="category_error_message" style="display: none; color: red;">
                                        Please enter a category name before inserting
                                    </p>
                                    <button type="submit" class="btn_1 full_width text-center category_btn mt-2" disabled>
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SUBCATEGORY --}}
                <div class="col-lg-6">
                    <div class="white_card card_height_100 mb_30">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Add new sub-category</h3>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <h6 class="card-subtitle">Select category</h6>

                            <form action="{{ route('category.subcategory.store') }}" method="post"
                                class="sub_category_submit" data-action="{{ route('category.subcategory.store') }}">
                                @csrf

                                <select class="js-example-basic-single w-100" name="foreign_id">
                                    <option value="" disabled selected>Please select a category</option>
                                    <!-- Placeholder -->
                                    @foreach ($sub_categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>

                                <h6 class="card-subtitle mt-3">Subcategory name</h6>
                                <div class="mb-0">
                                    <input type="text" class="form-control" name="sub_category"
                                        placeholder="sub category name">
                                    <button type="submit" class="btn_1 full_width text-center mt-3">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('backend_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 40px !important;
            padding: 6px 12px !important;
        }

        .select2-container .select2-selection__placeholder {
            color: #888 !important;
            font-weight: bold;
        }

        .select2-container .select2-selection__arrow {
            top: 50% !important;
            transform: translateY(-50%) !important;
        }

        /* Breadcrumb Styling */
        nav a {
            text-decoration: none;
            color: #fff;
            /* Bootstrap primary blue */
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        nav a:hover {
            color: #0056b3;
        }

        nav span {
            color: #6c757d;
            /* Gray color for active breadcrumb */
            font-weight: normal;
        }
    </style>
@endpush

@push('backend_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            // Enable/Disable submit button based on input
            $('.category_name').on('keyup input', function() {
                let inputVal = $(this).val().trim();
                if (inputVal === '') {
                    $('.category_btn').prop('disabled', true);
                    $('.category_error_message').show();
                } else {
                    $('.category_btn').prop('disabled', false);
                    $('.category_error_message').hide();
                }
            });

            // Submit form via AJAX
            $('.category_submit').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();
                let actionUrl = form.data('action'); // Get form action URL

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    beforeSend: function() {
                        $('.category_btn').prop('disabled', true).text('Submitting...');
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                                timer: 1000,
                                showConfirmButton: false
                            });

                            form[0].reset(); // Reset form
                            $('.category_btn').prop('disabled', true).text(
                                'Submit'); // Disable again
                            setTimeout(function() {
                                location.reload(); // Reloads the current page
                            }, 1000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Failed to insert category!'
                            });

                            $('.category_btn').prop('disabled', false).text('Submit');
                            setTimeout(function() {
                                location.reload(); // Reloads the current page
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = "Something went wrong. Please try again.";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join("\n");
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage
                        });
                        $('.category_btn').prop('disabled', false).text('Submit');
                        form[0].reset();
                    }
                });
            });


            $('.sub_category_submit').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();
                let actionUrl = form.data('action'); // Ensure form has data-action

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                                timer: 1000,
                                showConfirmButton: false
                            });

                            form[0].reset(); // Reset text inputs
                            $('.js-example-basic-single').val("").trigger(
                                'change'); // Reset Select2 and show placeholder

                            setTimeout(function() {
                                location.reload(); // Reload the page
                            }, 1000);


                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Failed to insert subcategory!'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = "Something went wrong. Please try again.";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join("\n");
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage
                        });
                        setTimeout(function() {
                            location.reload(); // Reload the page
                        }, 1000);
                    }
                });
            });




        });
    </script>
@endpush
