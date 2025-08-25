<?php

namespace App\Http\Controllers;

use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::where('is_deleted', '!=', 1)->orderBy('id', 'desc')->get();
        return view('frontend.doctors', compact('doctors'));
    }
}
