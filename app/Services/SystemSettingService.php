<?php

namespace App\Services;

use App\Models\SystemSetting;
use Illuminate\Validation\ValidationException;
class SystemSettingService
{
    public function getAll()
    {
        return SystemSetting::with('media')->get();
    }   

    public function getByName($name)
    {
        return SystemSetting::with('media')->where('key', $name)->first();
    }
    
    public function update($key, $value)
    {
        $systemSetting = SystemSetting::where('key', $key)->first();
        if (!$systemSetting) {
            throw ValidationException::withMessages(['system_setting' => ['System setting not found']]);
        }
        $systemSetting->value = $value;
        $systemSetting->save();
        return $systemSetting;
    }
    
}