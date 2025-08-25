<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {
        return view('admin.Doctor.index');
    }

    public function save(Request $request)
    {
        $post = $request->post();
        $hid = isset($post['hid']) ? intval($post['hid']) : null;
        $response['status'] = 0;
        $response['message'] = "Something went wrong!";

        // Fields for validation
        $fields = [
            'name' => $request->name,
            'specialization' => $request->specialization,
            'image' => $request->file('image'),
            'description' => $request->description,
        ];

        // Validation rules
        $rules = [
            'name' => 'required|max:191',
            'specialization' => 'nullable|max:191',
            'image' => $hid ? 'nullable|mimes:jpg,jpeg,png,gif|max:2048' : 'required|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable',
        ];

        $validator = Validator::make($fields, $rules);

        if (!$validator->fails()) {
            if (!Storage::disk('public')->exists('doctor')) {
                Storage::disk('public')->makeDirectory('doctor');
            }

            if ($hid) {
                $imagePath = $request->file('image')
                    ? $request->file('image')->store('doctor', 'public')
                    : str_replace(asset('storage/') . '/', '', $request->old_image);
            } else {
                $imagePath = $request->file('image')
                    ? $request->file('image')->store('doctor', 'public')
                    : null;
            }

            $doctorData = [
                'name' => $post['name'] ?? "",
                'specialization' => $post['specialization'] ?? "",
                'image' => $imagePath ?? "",
                'description' => $post['description'] ?? "",
            ];

            if ($hid) {
                $doctor = Doctor::where('id', $hid)->first();
                if ($doctor) {
                    $doctor->update($doctorData);
                    $response['status'] = 1;
                    $response['message'] = "Doctor updated successfully!";
                } else {
                    $response['message'] = "Doctor not found!";
                }
            } else {
                if (Doctor::create($doctorData)) {
                    $response['status'] = 1;
                    $response['message'] = "Doctor added successfully!";
                } else {
                    $response['message'] = "Failed to add doctor!";
                }
            }
        } else {
            $response['message'] = $validator->errors()->first();
        }

        return response()->json($response);
    }

    public function doctorlist()
    {
        $doctor_data = Doctor::select('doctor.*')
            ->where('doctor.is_deleted', '!=', 1)
            ->orderBy('doctor.id', 'desc')
            ->get();

        return DataTables::of($doctor_data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    return '<img src="' . asset("storage/$row->image") . '" alt="Image" width="50" height="50" />';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('action', function ($row) {
                $action = '<div class="dropdown dropup d-flex justify-content-center">'
                    . '<button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    . '<i class="bx bx-dots-vertical-rounded"></i>'
                    . '</button>'
                    . '<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">'
                    . '<a class="teamroleDelete dropdown-item" href="javascript:void(0);" data-id="' . $row->id . '"><i class="bx bx-trash me-1"></i> Delete</a>'
                    . '</div>'
                    . '</div>'
                    . '<div class="actions text-center">'
                    . '<a class="btn btn-sm bg-success-light" data-toggle="modal" href="javascript:void(0);" id="edit_doctor" data-id="' . $row->id . '"><i class="fe fe-pencil"></i></a>'
                    . '<a data-toggle="modal" class="btn btn-sm bg-danger-light" href="javascript:void(0);" id="delete_doctor" data-id="' . $row->id . '"><i class="fe fe-trash"></i></a>'
                    . '</div>';
                return $action;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function delete(Request $request)
    {
        $post = $request->post();
        $id = isset($post['id']) ? $post['id'] : "";
        $response['status']  = 0;
        $response['message']  = "Somthing Goes Wrong!";
        if (is_numeric($id)) {
            $delete_user = Doctor::where('id', $id)->update(['is_deleted' => 1]);
            if ($delete_user) {
                $response['status'] = 1;
                $response['message'] = 'Doctor deleted successfully.';
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
        $response = [
            'status' => 0,
            'message' => 'Something went wrong!'
        ];

        if (is_numeric($id)) {
            $doctor_data = Doctor::where('id', $id)->first();
            if ($doctor_data) {
                $doctor_data->image = $doctor_data->image ? asset("storage/$doctor_data->image") : null;
                $response = [
                    'status' => 1,
                    'doctor_data' => $doctor_data
                ];
            }
        }

        return response()->json($response);
    }
}
