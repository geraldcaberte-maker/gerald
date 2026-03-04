<?php

namespace App\Http\Controllers;

use App\Models\technical;
use App\Http\Requests\StoretechnicalRequest;
use App\Http\Requests\UpdatetechnicalRequest;


class TechnicalController extends Controller
{
    public function index()
    {
        return view('Technical.index');
    }

    public function fetch()
    {
        $technicals = technical::where('deleted', 0)->get();
        return response()->json($technicals);
        
    }

    public function save(){
        
        
        if(isset($_POST)){
            if($_POST['technical_id']!=""){
                $category = technical::find($_POST['technical_id']);
            }else{
                $category = new technical();
                $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $category->id = $timestamp . $random;
            }

            $category->type_computer = $_POST['type_computer'];
            $category->model = $_POST['model'];
            $category->status = $_POST['status'];  
            if($category->save()){
                return response()->json(['status' => 'true', 'message' => 'Technical saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save technical']);
            }
        }
    }

    public function info(){
        if(isset($_POST['technical_id'])){
            $technical = technical::find($_POST['technical_id']);
            if($technical){
                return response()->json($technical);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Technical not found']);
            }
        }
    }

    public function delete(){
        if(isset($_POST['technical_id'])){
            $category = technical::find($_POST['technical_id']);
            $category->deleted = 1;
            if($category->save()){
                return response()->json(['status' => 'true', 'message' => 'Technical deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete technical']);
            }
        }
    }

}
