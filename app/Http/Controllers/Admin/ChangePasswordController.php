<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard.changePassword');
    }
    public function updatepassword(Request $request)
    {
        $post = $request->post();
        $hid = isset($post['hid']) ? intval($post['hid']) : null;
        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required|min:8',
            'confirmpassword' => 'required|same:newpassword',
        ],
        $messages = [
            'oldpassword.required' => 'This field is required',
            'newpassword.required' => 'This field is required',
            'newpassword.min' => 'Password must be at least 8 characters long',
           // 'newpassword.different' => 'New password cannot be the same as the old password.',
            'confirmpassword.required' => 'This field is required',
            'confirmpassword.same' => 'Confirm password must match the new password',
        ]);
        $staff = DB::table('staff')->where('id', Auth::id())->first();
       // dd($staff);
    if (!$staff) {
        return response()->json(['status' => 0, 'message' => 'User not found.']);
    }

    if (!Hash::check($request->oldpassword, $staff->password)) {
        return response()->json(['status' => 0, 'message' => 'The current password is incorrect.']);
    }
     // Ensure old password and new password are not the same
     if (Hash::check($request->newpassword, $staff->password)) {
        return response()->json(['status' => 0, 'message' => 'New password cannot be the same as the old password.']);
    }

    DB::table('staff')->where('id', Auth::id())->update([
        'password' => Hash::make($request->newpassword),
    ]);

    return response()->json(['status' => 1, 'message' => 'Password changed successfully.']);

    }
}
