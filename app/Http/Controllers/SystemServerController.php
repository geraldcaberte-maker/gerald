<?php

namespace App\Http\Controllers;

use App\Models\system_server;
use App\Http\Requests\Storesystem_serverRequest;
use App\Http\Requests\Updatesystem_serverRequest;
use Illuminate\Http\Request;
class SystemServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     return view('system_server.index');
    }
    public function fetch()
    {
        $system_server = system_server ::where('deleted', 0)->get();
  
        return response()->json($system_server );
    }

    public function save(Request $request){

        if(isset($_POST)){
            if($_POST['system_server_id']!=""){
                $system_server = system_server ::find($_POST['system_server_id']);
            }else{
                $system_server= new system_server();
                $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $system_server->id = $timestamp . $random;
            }
   
            $system_server->system_server = $_POST['name'];
             
            if($system_server->save()){
                return response()->json(['status' => 'true', 'message' => 'System  saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save system']);
            }
        }
    }

    public function info(){
        if(isset($_POST['system_server_id'])){
            $system_server = system_server::find($_POST['system_server_id']);
            if($system_server){
                return response()->json($system_server);
            }else{
                return response()->json(['status' => 'false', 'message' => 'system not found']);
            }
        }
    }



    
//computer
    public function delete(){
        if(isset($_POST['system_server_id'])){
            $system_server = system_server::find($_POST['system_server_id']);
            $system_server->deleted = 1;
            if($system_server->save()){
                return response()->json(['status' => 'true', 'message' => 'System deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete system']);
            }
        }
    }


}
