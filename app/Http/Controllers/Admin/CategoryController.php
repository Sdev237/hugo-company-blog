<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use PDO;

class CategoryController extends Controller
{
    /**
     * get  category controller function
     */
    public function index()
    {
        try {
            $categorys = Category::orderBy('id', 'desc')->get();
            if($categorys){
                return response()->json([
                    'success' => true,
                    'categorys' => $categorys
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * get all category controller function
     */
    public function getAllCategory()
    {
        try {
            $categorys = Category::count();
            if($categorys){
                return response()->json([
                    'success' => true,
                    'categorys' => $categorys
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    
    /**
     * function add new category
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'Category_name' => ['required','string','max:20','min:3','unique:categories'],
            ]);

            if($validation->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validation->errors()->all(),
                ]);
            }else{
                $result = Category::create([
                    'Category_name' => $request->Category_name,
                ]);
                if($result){
                    return response()->json([
                        'success' => true,
                        'message' => "Category Add Successfully"
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => "Some problem"
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * function edit category
     */
    public function edit($id)
    {
        try {
            $categorys = Category::findOrFail($id);
            if($categorys){
                return response()->json(
                    [
                        'success' => true,
                        'categorys' => $categorys,
                    ]
                );
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
     * function update category
     */
    public function update(Request $request,$id)
    {
        try {
            
            $categorys = Category::findOrFail($id);
            $validation = Validator::make($request->all(), ['Category_name' => ['required','string','max:20','min:3','unique:categories'],]);
            if ($validation->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validation->errors()->all()
                ]);
            }else{
                $categorys->Category_name = $request->Category_name;
                $result = $categorys->save();
                if($result){
                    return response()->json ([
                        'success' => true,
                        'message' => "Category Update Successfully"
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => "Some problem"
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
     * function to delete category
     */
    public function delete($id)
    {
        try {
            $result = Category::findOrFail($id)->delete();
            if($result){
                return response()->json([
                    'success' => true,
                    'message' => "Category delete Successfully"
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Some problem"
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
     * function search
     */
    public function search($search)
    {
        try {
            $categorys = Category::WHERE('Category_name','LIKE','%'.$search.'%')->orderBy('id', 'desc')->get();
            if($categorys){
                return response()->json([
                    'success' => true,
                    'categorys' => $categorys
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
