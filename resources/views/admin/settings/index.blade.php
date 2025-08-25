@extends('admin.layouts.index')
@section('admin-title', 'Settings')
@section('page-title', 'Settings')
@section('admin-content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card-body">
            <div style="padding: 10px; width: 20%;" class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                aria-orientation="vertical">

                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                    <li class="nav-item"><a class="nav-link active" href="#general_setting_tab_content"
                            data-toggle="tab">General</a></li>
                    <li class="nav-item"><a class="nav-link" href="#socialMedia_setting_tab_content"
                            data-toggle="tab">Social Media</a></li>
                </ul>
            </div>

            <div class="tab-content" id="v-pills-tabContent" style="width: 90%;">
                {{-- General Setting --}}
                <div class="tab-pane fade show active" id="general_setting_tab_content" role="tabpanel"
                    aria-labelledby="general_setting_tab">
                    <form id="general_setting_form" name="general_setting_form" onsubmit="return false" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <label for="logo" class="form-label">Logo</label>
                                    <div class="form-group">
                                        @if (!empty(setting_data()['logo']))
                                            <div class="" style="height: auto;">
                                                <img src="{{ asset('logos/' . (get_setting('logo') != '' ? get_setting('logo') : '')) }}"
                                                    alt="logo">
                                                <a href="/admin/settings/remove_logo" style="float:right; color:grey;">X</a>
                                            </div>
                                        @else
                                            <input class="form-control" type="file" id="logo" name="logo">
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="favicon" class="form-label">Favicon</label>

                                        @if (!empty(setting_data()['favicon']))
                                            <div class="" style="height: auto;">
                                                <img src="{{ asset('favicons/' . (get_setting('favicon') != '' ? get_setting('favicon') : '')) }}"
                                                    alt="favicon icon">
                                                <a href="/admin/settings/remove_favicon"
                                                    style="float:right;color:grey;">X</a>
                                            </div>
                                        @else
                                            <input class="form-control" type="file" id="favicon" name="favicon">
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input class="form-control" type="text" id="settings[company_name]"
                                            name="settings[company_name]" placeholder="Enter Company Name"
                                            value="{{ get_setting('company_name') != '' ? get_setting('company_name') : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="Address" class="form-label">Address</label>
                                        <input class="form-control" type="text" id="settings[address]"
                                            name="settings[address]" placeholder="Enter Address"
                                            value="{{ get_setting('address') != '' ? get_setting('address') : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="city" class="form-label">City</label>
                                        <input class="form-control" type="text" id="settings[city]" name="settings[city]"
                                            placeholder="Enter City"
                                            value="{{ get_setting('city') != '' ? get_setting('city') : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="state" class="form-label">State</label>
                                        <input class="form-control" type="text" id="settings[state]"
                                            name="settings[state]" placeholder="Enter State"
                                            value="{{ get_setting('state') != '' ? get_setting('state') : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="state" class="form-label">Country</label>
                                        <input class="form-control" type="text" id="settings[country]"
                                            name="settings[country]" placeholder="Enter Country"
                                            value="{{ get_setting('country') != '' ? get_setting('country') : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="zip_code" class="form-label">Zip code</label>
                                        <input class="form-control" type="number" id="settings[zip_code]"
                                            name="settings[zip_code]" placeholder="Enter Zip code"
                                            value="{{ get_setting('zip_code') != '' ? get_setting('zip_code') : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input class="form-control" type="text" id="settings[phone_number]"
                                            name="settings[phone_number]" placeholder="Enter Phone Number"
                                            value="{{ get_setting('phone_number') != '' ? get_setting('phone_number') : '' }}">
                                        <span>Use (,) to add multiple phone number</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input class="form-control" type="text" id="settings[email]"
                                            name="settings[email]" placeholder="Enter Email address"
                                            value="{{ get_setting('email') != '' ? get_setting('email') : '' }}">
                                        <span>Use (,) to add multiple email address</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- End general --}}

                <div class="tab-pane fade" id="socialMedia_setting_tab_content" role="tabpanel"
                    aria-labelledby="socialMedia_setting_tab">
                    <form id="socialMedia_setting_form" name="socialMedia_setting_form" onsubmit="return false"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label" for="basic-default-company">Facebook</label>
                                        <input type="text" class="form-control" id="settings[facebook]"
                                            name="settings[facebook]"
                                            value="{{ get_setting('facebook') != '' ? get_setting('facebook') : '' }}"
                                            placeholder="facebook..." />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basic-default-company">Googleplus</label>
                                        <input type="text" class="form-control" id="settings[google_plus]"
                                            name="settings[google_plus]" placeholder="googleplus.."
                                            value="{{ get_setting('google_plus') != '' ? get_setting('google_plus') : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basic-default-company">YouTube</label>
                                        <input type="text" class="form-control" id="settings[youtube]"
                                            name="settings[youtube]" placeholder="YouTube.."
                                            value="{{ get_setting('youtube') != '' ? get_setting('youtube') : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basic-default-company">Instagram</label>
                                        <input type="text" class="form-control" id="settings[instagram]"
                                            name="settings[instagram]" placeholder="Instagram.."
                                            value="{{ get_setting('instagram') != '' ? get_setting('instagram') : '' }}" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin-js')
    <script src="{{ asset('assets/admin/theme/js/custom/settings.js') }}"></script>
@endsection
