@extends('admin.layouts.index')
@section('admin-title', 'Users')
@section('page-title', 'List of Users')
@section('add-button')
    <div class="col-sm-5 col">
        <a id="Add_Users" data-toggle="modal" data-target="#Add_Users_details"
            class="btn btn-primary float-right mt-2 text-light">Add</a>
    </div>
@endsection
@section('admin-content')
    <div class="table-responsive">
        <table class="datatable table table-hover mb-0" id="UserTable">
            <thead class="text-left">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @include('admin.Users.UserModal')
@endsection

@section('admin-js')
    <script src="{{ asset('assets/admin/theme/js/custom/Users.js') }}"></script>
@endsection
