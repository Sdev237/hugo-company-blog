<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * get all posts controller function
     */
    public function index()
    {
        try {
            $posts = Post::orderBy('id', 'desc')->with('categorys')->get();
            if($posts){
                return response()->json([
                    'success'=>true,
                    'posts'=>$posts
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * get all categories controller function
     */
    public function categoryes()
    {
        try {
            $posts = Post::orderBy('id', 'desc')->with('categories')->get();
            $categories = Category::orderBy('id', 'desc')->get();
            if($posts){
                return response()->json([
                    'success'=>true,
                    'posts'=>$posts
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
    
    /**
     * function add new post
     */
    public function store(Request $request)
    {
        try {
            $validation=Validator::make($request->all(),[
                'title' => ['required', 'string', 'max:100', 'min:3', 'unique:posts'],
                'description' => ['required', 'string', 'max:1000', 'min:3'],
                'cat_id' => ['required'],
                'image' => ['required'],
            ]);
            if($validation->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validation->errors()->all(),
                ]);
            }else{
                $filename = "";
                if($request->file('image')){
                    $filename = $request->file('image')->store('posts', 'public');
                }else{
                    $filename='null';
                }
                $result=Post::create([
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'image'=>$request->image,
                    'cat_id'=>$request->cat_id,
                    'views'=>1,

                ]);
                if($result){
                    return response()->json([
                        'success' => true,
                        'message' => 'Post Add Successfully',
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Some problem',
                    ]);
                }
                
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * function edit post
     */
    public function edit($id)
    {
        try {
            $posts = Post::findOrFail($id);
            return response()->json([
                'success'=>true,
                'posts'=>$posts,
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'categorys' => $e->getMessage(),
                ]
            );
        }
    }

    /**
     * function update post
     */
    public function update(Request $request, $id)
    {
        try {
            $posts = Post::findOrFail($id);
            $validation = Validator::make($request->all(),[
                'title' => ['required', 'string', 'max:100', 'min:3', 'unique:posts'],
                'description' => ['required', 'string', 'max:1000', 'min:3'],
                'cat_id' => ['required'],
            ]);
            if($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all()
                ]);
            }else{
                $filename = "";
                $destination=public_path('storage\\'. $posts->image);
                if($request->file('new_image')){
                    if(File::exists($destination)){
                        File::delete($destination);
                    }
                    $filename = $request->file('new_image')->store('posts', 'public');
                }else{
                    $filename = $request->old_image;
                }
                $posts->title=$request->title;
                $posts->description=$request->description;
                $posts->cat_id=$request->cat_id;
                $posts->image=$request->image;
                $result = $posts->save();
                if($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Post Update Successfully',
                    ]);
                }else{
                    return response()->json([
                        'success'=>false,
                        'message'=>'Some problem',
                    ]);
                }
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

    /**
     * function delete post
     */
    public function delete($id)
    {
        try {
            $posts = Post::findOrFail($id);
            $destination=public_path('storage\\'. $posts->image);
            if(File::exists($destination)){
                File::delete($destination);
            }
            $result = $posts->delete();
            if($result){
                return response()->json([
                    'success'=>true,
                    'message'=>'Post Delete Successfully',
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

    /**
     * function search TchoffoBright Josephine@1997*
     */
    public function search($search)
    {
        try {
            $posts = Post::where('title', 'LIKE', '%'.$search.'%')->orderBy('id', 'desc')->with('categorys')->get();
            if($posts){
                return response()->json([
                    'success'=>true,
                    'posts'=>$posts,
                ]);
            }else{
                return response()->json([
                    'success'=>true,
                    'message'=>'some problem',
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
