@extends('admin.layouts.index')
@section('admin-title', 'Doctors')
@section('page-title', 'List of Doctors')
@section('add-button')
    <div class="col-sm-5 col">
        <a id="Add_doctors" data-toggle="modal" data-target="#Add_doctors_details"
            class="btn btn-primary float-right mt-2 text-light">Add</a>
    </div>
@endsection
@section('admin-content')
    <div class="table-responsive">
        <table class="datatable table table-hover mb-0" id="DoctorTable">
            <thead class="text-left">
                <tr>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Image</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @include('admin.Doctor.DoctorModal')
@endsection
@section('admin-js')
    <script src="{{ asset('assets/admin/theme/js/custom/Doctor.js') }}"></script>
@endsection
