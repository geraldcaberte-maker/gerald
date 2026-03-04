<?php

namespace App\Http\Controllers;

use App\Models\response;
use App\Http\Requests\StoreresponseRequest;
use App\Http\Requests\UpdateresponseRequest;
use Illuminate\Http\Request;
class ResponseController extends Controller

{

    public function index()
    {
        return view('response.index');
    }

    public function fetch()
    {
        $response = response::where('deleted', 0)->get();
        return response()->json($response);
    }

    public function save(Request $request){

        if(isset($_POST)){
            if($_POST['response']!=""){
                $response = response::find($_POST['response']);
            }else{
                $response = new response();
                $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $response->id = $timestamp . $random;
            }
     $response->question_id = $_POST['question_id'];
            $response->status = $_POST['status'];
             $response->remarks = $_POST['remarks'];
            if($response->save()){
                return response()->json(['status' => 'true', 'message' => 'Response saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save response']);
            }
        }
    }

    public function info(){
        if(isset($_POST['response'])){
            $response = response::find($_POST['response']);
            if($response){
                return response()->json($response);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Response not found']);
            }
        }
    }



    
//computer
    public function delete(){
        if(isset($_POST['response_id'])){
            $response = response::find($_POST['response_id']);
            $response->deleted = 1;
            if($response->save()){
                return response()->json(['status' => 'true', 'message' => 'Response deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete response']);
            }
        }
    }


}