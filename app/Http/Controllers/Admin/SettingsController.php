<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class SettingsController extends Controller
{
    public function index()
    {
        return view("admin.settings.index");
    }

    public function save(Request $request)
    {
        $setting_detail = $request->post('settings');
        $logo = $request->file('logo');
        $favicon = $request->file('favicon');

        foreach ($setting_detail as $key => $value) {
            $existingSetting = Settings::where('name', $key)->first();

            if (!empty($key)) {
                if ($existingSetting) {

                    $existingSetting->update(['value' => $value]);
                } else {
                    Settings::create(['name' => $key, 'value' => $value]);
                }
            }
        }
        // }

        // Handle logo
        if (!empty($logo)) {
            $imageName = time() . "_" . rand() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('logos'), $imageName);

            $existingLogo = Settings::where('name', 'logo')->first();
            if ($existingLogo) {
                $existingLogo->update(['value' => $imageName]);
            } else {
                Settings::create(['name' => 'logo', 'value' => $imageName]);
            }
        }

        // Handle favicon
        if (!empty($favicon)) {
            $faviconName = time() . "_" . rand() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('favicons'), $faviconName);

            $existingFavicon = Settings::where('name', 'favicon')->first();
            if ($existingFavicon) {
                $existingFavicon->update(['value' => $faviconName]);
            } else {
                Settings::create(['name' => 'favicon', 'value' => $faviconName]);
            }
        }

        return response()->json(['message' => 'Settings saved successfully', 'status' => true], 200);
    }

    public function remove_logo()
    {
        $logo = Settings::where('name', 'logo')->first();

        $logoName = $logo['value'];
        $uploadDirectory = 'logos';
        $uploadPath = public_path($uploadDirectory);

        if (file_exists("$uploadPath/$logoName")) {
            unlink("$uploadPath/$logoName");
            Settings::where('value', $logo['value'])->update(['value' => '']);
            return redirect()->route('admin.settings')->with('message', 'Record delete successfully!');
        } else {
            return redirect()->route('admin.settings')->with('message', 'image does not exist!');
        }
    }

    public function remove_favicon()
    {
        $favicon = Settings::where('name', 'favicon')->first();

        $faviconName = $favicon['value'];
        $uploadDirectory = 'favicons';
        $uploadPath = public_path($uploadDirectory);

        if (file_exists("$uploadPath/$faviconName")) {
            unlink("$uploadPath/$faviconName");
            Settings::where('value', $favicon['value'])->update(['value' => '']);
            return redirect()->route('admin.settings')->with('message', 'Record delete successfully!');
        } else {
            return redirect()->route('admin.settings')->with('message', 'image does not exist!');
        }
    }
}
