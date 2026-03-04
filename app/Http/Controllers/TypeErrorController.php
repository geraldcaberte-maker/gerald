<?php

namespace App\Http\Controllers;

use App\Models\type_error;
use App\Http\Requests\Storetype_errorRequest;
use App\Http\Requests\Updatetype_errorRequest;

class TypeErrorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return view('type_error.index');
    }   
    public function fetch()
    {
        $categories =type_error::where('deleted', 0)->orderBy('description', 'asc')->get();
        return response()->json($categories);
    }

    public function save(){
        if(isset($_POST)){
            if($_POST['type_error_id']!=""){
                $category = type_error::find($_POST['type_error_id']);
            }else{
                $category = new type_error();
                $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $category->id = $timestamp . $random;
            }

            $category->description = $_POST['name'];
            // $category->sorting = $_POST['sorting'];
            if($category->save()){
                return response()->json(['status' => 'true', 'message' => 'Category saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save category']);
            }
        }
    }
  public function info(){
        if(isset($_POST['type_error_id'])){
            $category = type_error::find($_POST['type_error_id']);
            if($category){
                return response()->json($category);
            }else{
                return response()->json(['status' => 'false', 'message' => 'type error not found']);
            }
        }
    }


    
//computer
    public function delete(){
        if(isset($_POST['type_error_id'])){
            $category = type_error::find($_POST['type_error_id']);
            $category->deleted = 1;
            if($category->save()){
                return response()->json(['status' => 'true', 'message' => 'type error deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete type error']);
            }
        }
    }  

    

}