<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * get all setting  function
     */
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

    /**
     * function update setting
     */
    public function update(Request $request, $id)
    {
        try {
            $validation=Validator::make(
                $request->all(),
                [
                    'header_logo' =>['required'],
                    'footer_logo' =>['required'],
                    'footer_desc' =>['required'],
                    'email' =>['required', 'email'],
                    'phone' =>['required'],
                    'address' =>['required'],
                    'facebook' =>['required'],
                    'instagram' =>['required'],
                    'linkedin' =>['required'],
                    'about_title' =>['required'],
                    'about_desc' =>['required'],
                ]
            );

            if($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $result=Setting::findOrfail($id)->update(
                    [
                        'header_logo' => $request->header_logo,
                        'footer_logo' => $request->footer_logo,
                        'footer_desc' => $request->footer_desc,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'facebook' => $request->facebook,
                        'instagram' => $request->instagram,
                        'linkedin' => $request->linkedin,
                        'about_title' => $request->about_title,
                        'about_desc' => $request->about_desc,
                    ]
                );
                if($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Setting Update Successfully',
                    ]);
                }else{
                    return response()->json([
                        'success'=>false,
                        'message'=>'Some problem',
                    ]);
                }
            }

        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
}
