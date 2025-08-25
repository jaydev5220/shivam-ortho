@extends('admin.layouts.index')
@section('admin-title', 'Courses')
@section('page-title', 'List of Courses')
@section('add-button')
    <div class="col-sm-5 col">
        <a id="Add_courses" data-toggle="modal" data-target="#Add_courses_details"
            class="btn btn-primary float-right mt-2 text-light">Add</a>
    </div>
@endsection
@section('admin-content')
    <div class="table-responsive">
        <table class="datatable table table-hover mb-0" id="CourseTable">
            <thead class="text-left">
                <tr>
                    <th>Title</th>
                    <th>Short Description</th>
                    <th>Thumbnail</th>
                    <th>Video</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @include('admin.Course.CourseModal')
@endsection
@section('admin-js')
    <script src="{{ asset('assets/admin/theme/js/custom/Course.js') }}"></script>
@endsection
