<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            $subscribe=Subscribe::create([
                'email'=>$request->email,
            ]);
            if($subscribe){
                return response()->json([
                    'success'=>true,
                    'message'=>'Subscribe successfully',
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Some problem'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
