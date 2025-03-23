@extends('backend.index')
@section('backend_contains')
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
                            <div class=" mb-0">

                                <form action="{{ route('category.store') }}" class="category_submit" method="post">
                                    @csrf
                                    <input name="category_name" type="text"class="form-control category_name"
                                        id="inputText" placeholder="Category name">
                                    <p class=" category_error_message">please wire a category name before inserting</p>

                                    <button type="submit" class="btn_1 full_width text-center category_btn mt-2"
                                        disabled>submit</button>
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


                            <h6 class="card-subtitle">select category</h6>
                            <select class="js-example-basic-single w-100" name="state">
                                <option value="AL">Alabama</option>
                                ...
                                <option value="WY">Wyoming</option>
                            </select>


                            <h6 class="card-subtitle mt-3">sub category name</h6>
                            <div class=" mb-0">
                                <input type="text" class="form-control" name="inputText" id="inputText"
                                    placeholder="Text Input">

                                <button class="btn_1 full_width text-center mt-3">submit</button>

                            </div>

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
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            $('.category_name').on('keyup input', function() {
                let inputVal = $(this).val().trim();

                if (inputVal === '') {
                    $('.category_btn').attr('disabled', true);
                    $('.category_error_message').css('display', 'block');
                } else {
                    $('.category_btn').attr('disabled', false);
                    $('.category_error_message').css('display', 'none');
                }
            });




            $('.category_submit').on('submit', function(e) {
                // SWEET ALERT 
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Category inserted successfully!"
                });
            })


        });
    </script>
@endpush
