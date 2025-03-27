@extends('backend.layouts')

@section('backend_contains')
    @push('url')
        {!! generateBreadcrumbs() !!}
    @endpush

    @push('backend_css')
        <style>
            table.dataTable thead th {
                position: relative;
                padding-right: 20px;
            }

            /* Add sorting arrows manually */
            table.dataTable thead th.sorting::after {
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
                content: "\f0dc";
                /* Default sort icon */
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                opacity: 0.6;
            }

            table.dataTable thead th.sorting_asc::after {
                content: "\f0de";
                /* Up arrow */
            }

            table.dataTable thead th.sorting_desc::after {
                content: "\f0dd";
                /* Down arrow */
            }

            /* Fix pagination color */
            .dataTables_paginate .pagination .page-item.active .page-link {
                background-color: #490697 !important;
                color: #ffffff !important;
            }

            .dataTables_paginate .pagination .page-link {
                color: #000 !important;
            }

            .dataTables_paginate .pagination .page-link:hover {
                background-color: #0056b3 !important;
                color: #ffffff !important;
            }
        </style>
    @endpush


    <div class="container">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Sub Category </th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

@section('backend_js')
    @push('backend_js')
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,
                    ajax: "{{ route('category.all') }}",
                    columns: [{
                            data: null,
                            name: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'category_name',
                            name: 'category_name'
                        },
                        {
                            data: 'subcategories',
                            name: 'subcategories',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: function(data) {
                                let date = new Date(data);
                                return date.toLocaleString('en-US', {
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    hour12: true
                                });
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    language: {
                        paginate: {
                            previous: "&laquo;",
                            next: "&raquo;"
                        }
                    }
                });

                // Delete button handler
                $(document).on('click', '.delete-category', function() {
                    var categoryId = $(this).data('id');
                    var row = $(this).closest('tr');

                    if (confirm("Are you sure you want to delete this category?")) {
                        $.ajax({
                            url: '/admin/category/' + categoryId, // Corrected URL
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content') // Ensure CSRF token is included
                            },
                            success: function(response) {
                                alert(response.success);
                                table.row(row).remove().draw();
                            },
                            error: function(xhr) {
                                alert('Error: ' + xhr.responseJSON.error);
                            }
                        });
                    }
                });

            });
        </script>
    @endpush
@endsection

@endsection
