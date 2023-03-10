<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class GetPostController extends Controller
{
    /**
     * get all post
     */
    public function index()
    {
        try {
            $posts = Post::orderBy('id', 'desc')->get();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * function get  viewPosts
     */
    public function viewPosts()
    {
        try {
            $posts = Post::with('categorys')->where('views', '>', 0)->orderBy('id', 'desc')->get();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * function get-posts-ById
     */
    public function getPostsById($id)
    {
        try {
            $posts = Post::with('categorys')->findOrFail($id);
            $posts->views = $posts->views + 1;
            $posts->save();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]);

            $posts->increment('views', 1);
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * function get-posts-ByCategory
     */
    public function getPostsByCategory($id)
    {
        try {
            $posts = Post::with('categorys')->where('cat_id', $id)->orderBy('id', 'desc')->get();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]); 

            $posts->increment('views', 1);
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * function search-Post
     */
    public function searchPost($search)
    {
        try {
            $posts = Post::with('categorys')->where('title', 'LIKE', '%'.$search.'%')->orderBy('id', 'desc')->get();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]); 

            $posts->increment('views', 1);
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
}
