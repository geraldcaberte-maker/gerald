<?php

namespace App\Http\Controllers;


use App\Http\Requests\StorequestionerRequest;
use App\Http\Requests\UpdatequestionerRequest;

use Illuminate\Http\Request;  
use App\Models\Questioner;

class QuestionerController extends Controller
{

    public function index()
    {
       return view('questioner.index');
    }

  
    public function fetch()
    {
        $questioner = questioner::where('deleted', 0)->orderBy('sorting', 'asc')->get();
          return response()->json($questioner);
    }

      public function info(){
        if(isset($_POST['questioner_id'])){
            $questioner = questioner::find($_POST['questioner_id']);
            if($questioner){
                return response()->json($questioner);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Questioner not found']);
            }
        }
    }
    public function save(Request $request){
        if(isset($_POST)){
            if($_POST['questioner_id']!=""){
                $questioner = questioner::find($_POST['questioner_id']);
            }else{
                $questioner = new questioner();
                $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $questioner->id = $timestamp . $random;
            }
          $questioner->category_id = $_POST['category_id'];
            $questioner->question = $_POST['question'];
            $questioner->sorting = $_POST['sorting'];
            if($questioner->save()){
                return response()->json(['status' => 'true', 'message' => 'Questioner saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save questioner']);
            }
        }
    }
    public function delete(){
        if(isset($_POST['questioner_id'])){
            $questioner = questioner::find($_POST['questioner_id']);
            if($questioner){
                $questioner->deleted = 1;
                $questioner->save();
                return response()->json(['status' => 'true', 'message' => 'Questioner deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Questioner not found']);
            }
        }
    }

    }         
 
    
