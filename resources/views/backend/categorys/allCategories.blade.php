@extends('backend.layouts')
@section('backend_contains')
@push('url')
{!! generateBreadcrumbs() !!}
@endpush

    <table class="table table-hover table-striped">
        <tr>
            <td>#</td>
            <td>Category name</td>
            <td>Subcategoty</td>
            <td>Created at</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
        <tr>
            <td>#</td>
            <td>Category name</td>
            <td>Subcategoty</td>
            <td>Created at</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
        <tr>
            <td>#</td>
            <td>Category name</td>
            <td>Subcategoty</td>
            <td>Created at</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
        <tr>
            <td>#</td>
            <td>Category name</td>
            <td>Subcategoty</td>
            <td>Created at</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
    </table>
@endsection