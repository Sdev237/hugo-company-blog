<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthor extends Controller
{
    /**
     * function login
     */
    public function login(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'name'=>['required', 'string'],
                'password'=>['required', 'string'],
            ]);

            if($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all()
                ]);
            }else{
                $users=User::where('name', $request->name)->first();
                if(!$users){
                    return response()->json([
                        'success'=>false,
                        'message'=>'Invalid username and password'
                    ]); 
                }else{
                    if(!Hash::check($request->password, $users->password)){
                        return response()->json([
                            'success'=>false,
                            'message'=>'Invalid username and password'
                        ]);
                    }else{
                        $token=$users->createToken('token')->plainTextToken;
                        
                        return response()->json([
                            'success'=>true,
                            'message'=>'Login successfully',
                            'token'=>$token
                        ]);
                    }
                }
            }
           
        }  catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * function admins
     */
    public function admins(Request $request)
    {
        $users = $request->user();
        return response()->json([$users]);
    }

    /**
     * function logout
     */
    /*
    public function logout(Request $request)
    {
        try {
            $id = $request->user()->id;
            auth()->user()->tokens()->where('tokenable_id', $id)->delete();
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }*/
}
