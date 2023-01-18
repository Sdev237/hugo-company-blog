<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getComments()
    {
        try {
            $comments=Comment::orderBy('id', 'desc')->get();
            return response()->json([
                'success'=>true,
                'cotacts'=>$comments,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getAllComments()
    {
        try {
            $comments=Comment::count();
            return response()->json([
                'success'=>true,
                'cotacts'=>$comments,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    //function deletecomments
    public function deleteContacts($id)
    {
        $result=Comment::findOrFail($id)->delete();
        if($result){
            return response()->json([
                'success'=>true,
                'message'=>'Comment Delete Successfully',
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Some problem',
            ]);
        }

    }
}
