<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function index()
    {
        return view('admin.Users.index');
    }

    public function save(Request $request)
    {
        $post = $request->post();
        $hid = isset($post['hid']) ? intval($post['hid']) : null;
        $response['status'] = 0;
        $response['message'] = "Something went wrong!";

        $fields = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Validation rules
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ];
        if (!$hid) {
            $rules['password'] = 'required|min:6';
        }

        // Custom error messages
        $msg = [
            'firstname.required' => 'Please enter first name',
            'lastname.required' => 'Please enter last name',
            'phone.required' => 'Please enter the phone number',
            'email.required' => 'Please enter the email address',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Please enter the password',
            'password.min' => 'Password must be at least 6 characters',
        ];

        $validator = Validator::make($fields, $rules, $msg);

        if (!$validator->fails()) {
            // Check if email already exists for another user and is not deleted
            $existingEmailQuery = User::where('email', $request->email)
                ->where('is_deleted', '!=', 1);

            // Exclude the current record from the check if updating
            if ($hid) {
                $existingEmailQuery->where('id', '!=', $hid);
            }
            if ($existingEmailQuery->exists()) {
                return response()->json([
                    'status' => 0,
                    'message' => 'The email address is already in use by another user.',
                ]);
            }

            $user_insert_data = [
                'firstname' => $post['firstname'] ?? "",
                'lastname' => $post['lastname'] ?? "",
                'phone' => $post['phone'] ?? "",
                'email' => $post['email'] ?? "",
            ];

            // Avoid re-hashing the password if not changed
            if (!$hid || $request->filled('password')) {
                $user_insert_data['password'] = Hash::make($request->password);
            }

            if ($hid) {
                // Update existing record
                $user = User::where('id', $hid)->first();


                if ($user) {
                    $user->update($user_insert_data);
                    $response['status'] = 1;
                    $response['message'] = "User updated successfully!";
                } else {
                    $response['message'] = "user not found!";
                }
            } else {
                // Create new record
                if (User::create($user_insert_data)) {
                    $response['status'] = 1;
                    $response['message'] = "User added successfully!";
                } else {
                    $response['message'] = "Failed to add user!";
                }
            }
        } else {
            $response['message'] = $validator->errors()->first();
        }

        return response()->json($response);
        exit;
    }


    // // // List Show
    public function userslist()
    {
        $user_data = User::select('users.*')
            ->where('users.is_deleted', '!=', 1)
            ->orderBy('users.id', 'desc')
            ->get();

        return Datatables::of($user_data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action = '<div class="dropdown dropup d-flex justify-content-center">
                            <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="bx bx-dots-vertical-rounded"></i>
                             </button>
                             <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                 <a class="teamroleDelete dropdown-item" href="javascript:void(0);" data-id="' . $row->id . '">
                                     <i class="bx bx-trash me-1"></i> Delete
                                 </a>
                             </div>
                           </div>
                           <div class="actions text-center">
                                <a class="btn btn-sm bg-success-light" data-toggle="modal" href="javascript:void(0);" id="edit_user" data-id="' . $row->id . '">
                                   <i class="fe fe-pencil"></i>
                               </a>
                               <a data-toggle="modal" class="btn btn-sm bg-danger-light" href="javascript:void(0);" id="delete_user" data-id="' . $row->id . '">
                                   <i class="fe fe-trash"></i>
                               </a>
                           </div>';

                return $action;
            })
            ->rawColumns(['action']) // Ensure HTML is not escaped
            ->make(true);
    }

    public function delete(Request $request)
    {
        $post = $request->post();
        $id = isset($post['id']) ? $post['id'] : "";
        $response['status']  = 0;
        $response['message']  = "Somthing Goes Wrong!";
        if (is_numeric($id)) {
            $delete_user = User::where('id', $id)->update(['is_deleted' => 1]);
            if ($delete_user) {
                $response['status'] = 1;
                $response['message'] = 'user deleted successfully.';
            } else {
                $response['message'] = 'something went wrong.';
            }
        }
        echo json_encode($response);
        exit;
    }

    public function edit(Request $request)
    {
        $id = $request->query('id');
        // Initialize response
        $response = [
            'status' => 0,
            'message' => 'Something went wrong!'
        ];

        // Check if ID is valid
        if (is_numeric($id)) {
            $users_data = User::where('id', $id)->first();
            if ($users_data) {
                $response = [
                    'status' => 1,
                    'users_data' => $users_data
                ];
            }
        }

        return response()->json($response);
        exit; // Proper JSON response
    }
}
