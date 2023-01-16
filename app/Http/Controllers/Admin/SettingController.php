<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $settings = Setting::findOrfail(1);
            return response()->json([
                'success'=>false,
                'settings'=>$settings
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
}
