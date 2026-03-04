<?php

namespace App\Http\Controllers;

use App\Models\custodian_info;
use App\Http\Requests\Storecustodian_infoRequest;
use App\Http\Requests\Updatecustodian_infoRequest;
use Illuminate\Http\Request;
class CustodianInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('custodian_info.index');
    }

    public function fetch()
    {
        $custodian_info = custodian_info::where('deleted', 0)->get();
        return response()->json($custodian_info);
    }

    public function save(Request $request){

        if(isset($_POST)){
            if($_POST['custodian_id']!=""){
                $custodian_info = custodian_info::find($_POST['custodian_id']);
            }else{
                $custodian_info = new custodian_info();
                $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $custodian_info->id = $timestamp . $random;
            }
     $custodian_info->user_id = $_POST['user_id'];
            $custodian_info->brand = $_POST['brand'];
            $custodian_info->model = $_POST['model'];
            $custodian_info->type = $_POST['type'];
            $custodian_info->serial_number = $_POST['serial_number'];
            $custodian_info->mac_address = $_POST['mac_address'];
            $custodian_info->ip_address = $_POST['ip_address'];

            if($custodian_info->save()){
                return response()->json(['status' => 'true', 'message' => 'Custodian Info saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save custodian info']);
            }
        }
    }

    public function info(){
        if(isset($_POST['custodian_id'])){
            $custodian_info = custodian_info::find($_POST['custodian_id']);
            if($custodian_info){
                return response()->json($custodian_info);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Custodian Info not found']);
            }
        }
    }



    
//computer
    public function delete(){
        if(isset($_POST['custodian_info_id'])){
            $custodian_info = custodian_info::find($_POST['custodian_info_id']);
            $custodian_info->deleted = 1;
            if($custodian_info->save()){
                return response()->json(['status' => 'true', 'message' => 'Custodian Info deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete custodian info']);
            }
        }
    }
}
