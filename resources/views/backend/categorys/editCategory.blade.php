@extends('backend.layouts')

@section('backend_contains')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('url')
        {!! generateBreadcrumbs() !!}
    @endpush

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="white_card card_height_100 mb_30">
                    <div class="white_card_header">
                        <div class="box_header m-0">
                            <div class="main-title">
                                <h3 class="m-0">Edit Category</h3>
                            </div>
                        </div>
                    </div>
                    <div class="white_card_body">
                        <form action="{{ route('category.update', $category->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="POST"> <!-- To handle PUT/PATCH -->

                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="category_name" value="{{ $category->category_name }}" placeholder="Category name">
                            </div>

                            <div class="mb-3">
                                <label for="sub_category_name" class="form-label">Sub Category Name</label>
                                <input type="text" class="form-control" name="sub_category_name" value="{{ $category->sub_category_name }}" placeholder="Sub Category name">
                            </div>

                            <div class="mb-3">
                                <label for="foreign_id" class="form-label">Select Parent Category</label>
                                <select class="form-control" name="foreign_id">
                                    <option value="" {{ is_null($category->foreign_id) ? 'selected' : '' }}>None</option>
                                    @foreach ($sub_categories as $sub_category)
                                        <option value="{{ $sub_category->id }}" {{ $category->foreign_id == $sub_category->id ? 'selected' : '' }}>
                                            {{ $sub_category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
