<?php

namespace App\Http\Controllers;

use App\Models\error_and_concern;
use App\Http\Requests\Storeerror_and_concernRequest;
use App\Http\Requests\Updateerror_and_concernRequest;
use Illuminate\Http\Request;

class ErrorAndConcernController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
return view ('error_and_concern.index');
    }

   public function fetch()
    {        
        
        $categories = error_and_concern::where('deleted', 0)->get();
         //$error_and_concern->load('type_error');
        return response()->json($categories);
    }

    public function save(){
        if(isset($_POST)){
            if($_POST['eac_id']!=""){
                $category = error_and_concern::find($_POST['eac_id']);
            }else{
                $category = new error_and_concern();
               $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $category->id = $timestamp . $random;
            }

            $category->Date = $_POST['Date'];
            $category->system_id = $_POST['system_id'];
            $category->type_error = $_POST['type_error'];
$category->requirments = $_POST['requirments'];
$category->module = $_POST['module'];
$category->action = $_POST['action'];
$category->update_status = $_POST['update_status'];
$category->target_start = $_POST['target_start'];
$category->target_end = $_POST['target_end'];
$category->status = $_POST['status'];
$category->date_accomplished = $_POST['date_accomplished'];
$category->date_reviewed = $_POST['date_reviewed'];
$category->upload_date = $_POST['upload_date'];
$category->backup_date = $_POST['backup_date'];
$category->backup_location = $_POST['backup_location'];
$category->filelink = $_POST['filelink'];
$category->remarks = $_POST['remarks'];
            if($category->save()){
                return response()->json(['status' => 'true', 'message' => 'monitoring saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save category']);
            }
        }
    }

    public function info(){
        if(isset($_POST['eac_id'])){
            $category = error_and_concern::find($_POST['eac_id']);
            if($category){
                return response()->json($category);
            }else{
                return response()->json(['status' => 'false', 'message' => 'monitoring not found']);
            }
        }
    }
 public function delete(){
        if(isset($_POST['eac_id'])){
            $category = error_and_concern::find($_POST['eac_id']);
            $category->deleted = 1;
            if($category->save()){
                return response()->json(['status' => 'true', 'message' => 'Category deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete category']);
            }
        }
    }

}
