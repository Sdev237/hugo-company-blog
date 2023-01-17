<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getContacts()
    {
        try {
            $contacts=Contact::orderBy('id', 'desc')->get();
            return response()->json([
                'success'=>true,
                'cotacts'=>$contacts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    //function deleteContacts
    public function deleteContacts($id)
    {
        $result=Contact::findOrFail($id)->delete();
        if($result){
            return response()->json([
                'success'=>true,
                'message'=>'Contact Delete Successfully',
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Some problem',
            ]);
        }

    }
}
