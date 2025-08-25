<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // $tables = ['doctors', 'staff', 'patients'];
        // $counts = [];

        // foreach ($tables as $table) {
        //     $counts[$table] = DB::table($table)
        //         ->where('isdeleted', '!=', 1)
        //         ->count();
        // }

        return view('admin.dashboard.index');
        // return view('admin.dashboard.index');
    }
}
