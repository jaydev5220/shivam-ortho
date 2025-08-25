<?php
if (!function_exists('setting_data')) {
    function setting_data()
    {
        $settings = \App\Models\Settings::all();
        $settingData = [];
        foreach ($settings as $setting) {
            $settingData[$setting->name] = $setting->value;
        }
        return $settingData;
    }
}

if (!function_exists('get_setting')) {
    function get_setting($name)
    {
        $setting = \App\Models\Settings::where('name', $name)->first();
        if (!empty($setting)) {
            return $setting['value'];
        }
        return '';
    }
}
