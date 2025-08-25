@php
    $currentRouteName = \Route::currentRouteName();
    $staffData = session('staff_data');
    $currentloginRole = isset($staffData['role_name']) ? $staffData['role_name'] : '';

    $currentloginName = isset($staffData['username']) ? $staffData['username'] : '';
@endphp


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | @yield('admin-title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/admin/theme/img/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/font-awesome.min.css') }}">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/feathericon.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/theme/plugins/morris/morris.css') }}">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/plugins/datatables/datatables.min.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/select2.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/style.css') }} ">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            @include('admin.layouts.navbar')
        </div>
        <!-- /Header -->
        @include('admin.layouts.sidebar')
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-7 col-auto">
                            @if ($currentRouteName === 'admin.home')
                                <h3 class="page-title">Welcome, {{ isset($currentloginName) ? $currentloginName : '' }}
                                </h3>
                            @else
                                <h3 class="page-title">@yield('page-title')</h3>
                            @endif
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.home') }}">Dashboard</a>
                                </li>
                                @hasSection('center-title')
                                    <li class="breadcrumb-item active">
                                        <a href="@yield('center-title-route')">@yield('center-title')</a>
                                    </li>
                                @endif
                                @hasSection('page-title')
                                    <li class="breadcrumb-item active">
                                        @yield('page-title')
                                    </li>
                                @endif
                            </ul>
                        </div>
                        @yield('add-button')
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                {{-- @if ($currentRouteName != 'admin.home')
                                    <div id="loader-container">
                                        <div class="loader"></div>
                                    </div>
                                @endif --}}
                                @yield('admin-content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script type="text/javascript">
        var BASE_URL = "{{ url('/') }}";
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
    </script>

    @if (session('message'))
        <script>
            Toast.fire({
                icon: "{{ session('type') }}",
                title: "{{ session('message') }}"
            });
        </script>
    @endif

    <!-- jQuery -->
    <script src="{{ asset('assets/admin/theme/js/jquery-3.2.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/admin/theme/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/js/bootstrap.min.js') }}"></script>

    {{-- validate JS  --}}
    <script src="{{ asset('assets/admin/theme/cdnFiles/validate.min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/cdnFiles/additional-methods.min.js') }}"></script>
    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/admin/theme/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/js/chart.morris.js') }}"></script>
    {{-- toastr --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/cdnFiles/toastr.css') }}" />
    <script src="{{ asset('assets/admin/theme/cdnFiles/toastr.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('assets/admin/theme/js/select2.min.js') }}"></script>

    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script src="{{ asset('assets/admin/theme/cdnFiles/ckeditor.js') }}"></script>

    <!-- Datatables JS -->
    <script src="{{ asset('assets/admin/theme/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/plugins/datatables/datatables.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/admin/theme/js/script.js') }}"></script>
    @yield('admin-js')

</body>

</html>
