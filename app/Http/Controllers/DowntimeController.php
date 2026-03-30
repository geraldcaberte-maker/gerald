<?php

namespace App\Http\Controllers;

use App\Models\downtime;
use App\Http\Requests\StoredowntimeRequest;
use App\Http\Requests\UpdatedowntimeRequest;
use Illuminate\Http\Request;
class DowntimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
return view('downtime.index');
    }

    public function fetch()
    {
        $downtime = downtime::where('deleted', 0)->get();
        $downtime->load('system_server');
        return response()->json($downtime);
    }

    public function save(Request $request){

        if(isset($_POST)){
            if($_POST['downtime_id']!=""){
                $downtime = downtime::find($_POST['downtime_id']);
            }else{
                $downtime = new downtime();
                $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $downtime->id = $timestamp . $random;
            }
     $downtime->system_id = $_POST['system_id'];
            $downtime->description = $_POST['description'];
                 $downtime->start = $_POST['start'];
                   $downtime->end = $_POST['end'];
                     $downtime->remarks = $_POST['remarks'];
            if($downtime->save()){
                return response()->json(['status' => 'true', 'message' => 'Downtime Records saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save Downtime Records']);
            }
        }
    }

    public function info(){
        if(isset($_POST['downtime_id'])){
            $downtime = downtime::find($_POST['downtime_id']);
            if($downtime){
                return response()->json($downtime);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Downtime not found']);
            }
        }
    }



    
//computer
    public function delete(){
        if(isset($_POST['downtime_id'])){
            $downtime = downtime::find($_POST['downtime_id']);
            $downtime->deleted = 1;
            if($downtime->save()){
                return response()->json(['status' => 'true', 'message' => 'downtime Records deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete Downtime Records']);
            }
        }
    }


}
