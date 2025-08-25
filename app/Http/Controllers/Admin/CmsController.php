<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class CmsController extends Controller
{
    public function index()
    {
        return view('admin.cms.index');
    }

    public function list(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view("admin.cms.index");
        }

        if ($request->ajax() && $request->isMethod('post')) {

            $cms = Cms::select('*')->where('status', '!=', -1)->get()->toArray();
            return DataTables::of($cms)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    $action = $data['status'] == 1 ? 'Active' : 'InActive';
                    return $action;
                })
                ->addColumn('action', function ($data) {
                    $action = '<div class="dropdown dropup d-flex justify-content-center">
                            <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="bx bx-dots-vertical-rounded"></i>
                             </button>
                             <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                 <a class="teamroleDelete dropdown-item" href="javascript:void(0);" data-id="' . $data['id'] . '">
                                     <i class="bx bx-trash me-1"></i> Delete
                                 </a>
                             </div>
                           </div>
                           <div class="actions text-center">
                                <a class="btn btn-sm bg-success-light" data-toggle="modal" href="javascript:void(0);" id="cmsEdit" data-id="' . $data['id'] . '">
                                   <i class="fe fe-pencil"></i>
                               </a>
                               <a data-toggle="modal" class="btn btn-sm bg-danger-light" href="javascript:void(0);" id="cmsDelete" data-id="' . $data['id'] . '">
                                   <i class="fe fe-trash"></i>
                               </a>
                           </div>';

                    return $action;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function save(Request $request)
    {
        $_data = $request->post();
        $response['status'] = 1;
        $cms_data = [];

        $validator = Validator::make($request->post(), [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 1,
                'message' => $validator->errors()->first(),
            ]);
        }

        if (!empty($_data)) {
            $hid = isset($_data['hid']) ? $_data['hid'] : '';

            $cms_data['title'] = isset($_data['title']) ? $_data['title'] : '';
            $cms_data['slug'] = Str::slug($cms_data['title']);
            $cms_data['description'] = isset($_data['description']) ? $_data['description'] : '';
            $cms_data['status'] = isset($_data['status']) ? $_data['status'] : '';
            $cms_data['meta_title'] = isset($_data['meta_title']) ? $_data['meta_title'] : null;
            $cms_data['meta_description'] = isset($_data['meta_description']) ? $_data['meta_description'] : null;
            $cms_data['meta_keyword'] = isset($_data['meta_keyword']) ? $_data['meta_keyword'] : null;

            if ($hid != "") {
                $updateCms = Cms::where('id', $hid);
                if ($updateCms->update($cms_data)) {
                    if ($cms_data) {
                        $response['status'] = 0;
                        $response['message'] = "Cms Updated Successfully!";
                    } else {
                        $response['status'] = 1;
                        $response['message'] = "Failed to update";
                    }
                }
            } else {
                if (Cms::where('slug', $cms_data['slug'])->exists()) {
                    $response['status'] = 1;
                    $response['message'] = "Slug already exists. Please choose a different title.";
                } else {
                    if (Cms::create($cms_data)) {
                        $response['status'] = 0;
                        $response['message'] = "CMS Created Successfully!";
                    } else {
                        $response['status'] = 1;
                        $response['message'] = "Failed to insert";
                    }
                }
            }
            return response()->json($response);
        }
    }


    public function edit($id)
    {
        $response['status'] = 0;
        if (is_numeric($id)) {
            $cms_data = Cms::where('id', $id)->first()->toArray();
            if (!empty($cms_data)) {
                $response['status'] = 1;
                $response['cms_data'] = $cms_data;
            }
        }
        return response()->json($response);
    }

    public function delete($id)
    {
        $response['status'] = 0;
        if (is_numeric($id)) {
            $delete_cms = Cms::where('id', $id)->update(['status' => -1]);

            if ($delete_cms) {
                $response['status'] = 1;
                $response['text'] = 'Your Cms has been deleted.';
                $response['title'] = 'Deleted';
                $response['icon'] = 'success';
            } else {
                $response['msg'] = 'something went wrong.';
            }
        }
        return response()->json($response);
    }

    public function check_slug(Request $request)
    {
        $slug = $request->input('slug');
        $id = $request->input('id');

        $query = Cms::where('slug', $slug);
        if ($id) {
            $query->where('id', '!=', $id);
        }
        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }
}
