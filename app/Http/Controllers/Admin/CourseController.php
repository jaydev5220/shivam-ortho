<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        return view('admin.Course.index');
    }

    public function save(Request $request)
    {
        $post = $request->post();
        $hid = isset($post['hid']) ? intval($post['hid']) : null;
        $response['status'] = 0;
        $response['message'] = "Something went wrong!";

        // Fields for validation
        $fields = [
            'title' => $request->title,
            'short_description' => $request->short_description,
            'thumbnail' => $request->file('thumbnail'),
            'description' => $request->description,
            'video' => $request->file('video'),
        ];

        // Validation rules
        $rules = [
            'title' => 'required|max:191',
            'short_description' => 'required|max:255',
            'thumbnail' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048', // Max 2MB
            'description' => 'required',
            'video' => $hid ? 'nullable|mimes:mp4,mov,avi|max:51200' : 'required|mimes:mp4,mov,avi|max:51200', // Max 50MB
        ];

        // Custom error messages
        $msg = [
            'title.required' => 'Please enter the course title',
            'short_description.required' => 'Please enter a short description',
            'thumbnail.mimes' => 'Only JPG, JPEG, PNG, and GIF formats are allowed for the thumbnail',
            'description.required' => 'Please enter the course description',
            'video.required' => 'Please upload a course video',
            'video.mimes' => 'Only MP4, MOV, or AVI formats are allowed for the video',
        ];

        $validator = Validator::make($fields, $rules, $msg);

        if (!$validator->fails()) {


            // Create folders if they don't exist
            if (!Storage::disk('public')->exists('thumbnail')) {
                Storage::disk('public')->makeDirectory('thumbnail');
            }

            if (!Storage::disk('public')->exists('video')) {
                Storage::disk('public')->makeDirectory('video');
            }

            // Handle Thumbnail and Video Upload
            if ($hid) {
                // If no new file uploaded, extract relative path from URL for old values
                $thumbnailPath = $request->file('thumbnail')
                    ? $request->file('thumbnail')->store('thumbnails', 'public')
                    : str_replace(asset('storage/') . '/', '', $request->old_thumbnail);

                $videoPath = $request->file('video')
                    ? $request->file('video')->store('videos', 'public')
                    : str_replace(asset('storage/') . '/', '', $request->old_video);
            } else {
                // For new entries, ensure new files are uploaded
                $thumbnailPath = $request->file('thumbnail') ?
                    $request->file('thumbnail')->store('thumbnails', 'public') :
                    null;

                $videoPath = $request->file('video') ?
                    $request->file('video')->store('videos', 'public') :
                    null;
            }
            $courseData = [
                'title' => $post['title'] ?? "",
                'short_description' => $post['short_description'] ?? "",
                'thumbnail' => $thumbnailPath ?? "",
                'description' => $post['description'] ?? "",
                'video' => $videoPath ?? "",
            ];

            if ($hid) {
                // Update existing record
                $course = Course::where('id', $hid)->first();

                if ($course) {
                    $course->update($courseData);
                    $response['status'] = 1;
                    $response['message'] = "Course updated successfully!";
                } else {
                    $response['message'] = "Course not found!";
                }
            } else {
                // Create new record
                if (Course::create($courseData)) {
                    $response['status'] = 1;
                    $response['message'] = "Course added successfully!";
                } else {
                    $response['message'] = "Failed to add course!";
                }
            }
        } else {
            $response['message'] = $validator->errors()->first();
        }

        return response()->json($response);
    }

    // // // // List Show
    public function courselist()
    {
        $course_data = Course::select('course.*')
            ->where('course.is_deleted', '!=', 1)
            ->orderBy('course.id', 'desc')
            ->get();

        return Datatables::of($course_data)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($row) {
                if ($row->thumbnail) {
                    return '<img src="' . asset("storage/$row->thumbnail") . '" alt="Thumbnail" width="50" height="50" />';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('video', function ($row) {
                if ($row->video) {
                    return '<a href="' . asset("storage/$row->video") . '" target="_blank" class="btn btn-primary btn-sm">
                            <i class="bx bx-video"></i> View
                        </a>';
                }
                return '<span class="text-muted">No Video</span>';
            })
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
                                <a class="btn btn-sm bg-success-light" data-toggle="modal" href="javascript:void(0);" id="edit_course" data-id="' . $row->id . '">
                                   <i class="fe fe-pencil"></i>
                               </a>
                               <a data-toggle="modal" class="btn btn-sm bg-danger-light" href="javascript:void(0);" id="delete_course" data-id="' . $row->id . '">
                                   <i class="fe fe-trash"></i>
                               </a>
                           </div>';

                return $action;
            })
            ->rawColumns(['thumbnail', 'video', 'action']) // Ensure HTML rendering
            ->make(true);
    }


    public function delete(Request $request)
    {
        $post = $request->post();
        $id = isset($post['id']) ? $post['id'] : "";
        $response['status']  = 0;
        $response['message']  = "Somthing Goes Wrong!";
        if (is_numeric($id)) {
            $delete_user = Course::where('id', $id)->update(['is_deleted' => 1]);
            if ($delete_user) {
                $response['status'] = 1;
                $response['message'] = 'Course deleted successfully.';
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
            $course_data = Course::where('id', $id)->first();
            if ($course_data) {
                $course_data->thumbnail = $course_data->thumbnail ? asset("storage/$course_data->thumbnail") : null;
                $course_data->video = $course_data->video ? asset("storage/$course_data->video") : null;

                $response = [
                    'status' => 1,
                    'course_data' => $course_data
                ];
            }
        }

        return response()->json($response);
        exit; // Proper JSON response
    }
}
