@extends('backend.index')
@section('backend_contains')
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- CSRF Token --}}

    <div class="main_content_iner ">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="row justify-content-center">
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

                            <form action="{{ route('category.subcategory.store') }}" method="post">
                                @csrf

                                <select class="js-example-basic-single w-100" name="foreign_id">
                                    @foreach ($sub_categories as $sub_category)
                                        <option value="{{ $sub_category->id }}"> {{ $sub_category->category_name }}
                                        </option>
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
                                timer: 3000,
                                showConfirmButton: false
                            });

                            form[0].reset(); // Reset form
                            $('.category_btn').prop('disabled', true).text(
                                'Submit'); // Disable again
                            setTimeout(function() {
                                location.reload(); // Reloads the current page
                            }, 3000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Failed to insert category!'
                            });

                            $('.category_btn').prop('disabled', false).text('Submit');
                            setTimeout(function() {
                                location.reload(); // Reloads the current page
                            }, 3000);
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

        });
    </script>
@endpush
