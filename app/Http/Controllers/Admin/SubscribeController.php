<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Exception;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{

    /**
     * function to get all subscribes
     */
    public function index()
    {
        try {
            $subscribes = Subscribe::get();
            return response()->json([
                'success'=>true,
                'message'=>$subscribes,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    
    public function getAllSubscribe()
    {
        try {
            $subscribes = Subscribe::count();
            return response()->json([
                'success'=>true,
                'message'=>$subscribes,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * function to delete subscribe
     */
    public function delete($id)
    {
        try {
            $subscribes = Subscribe::findOrFail($id);
            $result = $subscribes->delete();
            if($result){
                return response()->json([
                    'success'=>true,
                    'message'=>'Subscribetion Delete Successfully',
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Some problem',
                ]);
            }

        } catch (Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'categorys' => $e->getMessage(),
                ]
            );
        }
    }
}
