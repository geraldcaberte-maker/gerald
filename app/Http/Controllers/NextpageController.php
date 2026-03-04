<?php

namespace App\Http\Controllers;

use App\Models\nextpage;
use App\Http\Requests\StorenextpageRequest;
use App\Http\Requests\UpdatenextpageRequest;

class NextpageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return view('users.nextpage');
    }
public function fetch()
    {
        $nextpages = nextpage::where('deleted', 0)->get();
        return response()->json($nextpages);
    }

    public function save(){
        if(isset($_POST)){
            if($_POST['nextpage_id']!=""){
                $category = nextpage::find($_POST['nextpage_id']);
            }else{
                $category = new nextpage();
                $timestamp = substr(round(microtime(true) * 1000), -13);
                $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $category->id = $timestamp . $random;
            }

            $category->description = $_POST['name'];
            if($category->save()){
                return response()->json(['status' => 'true', 'message' => 'Nextpage saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save nextpage']);
            }
        }
    }

    public function info(){
        if(isset($_POST['nextpage_id'])){
            $category = nextpage::find($_POST['nextpage_id']);
            if($category){
                return response()->json($category);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Nextpage not found']);
            }
        }
    }

    public function delete(){
        if(isset($_POST['nextpage_id'])){
            $category = nextpage::find($_POST['nextpage_id']);
            $category->deleted = 1;
            if($category->save()){
                return response()->json(['status' => 'true', 'message' => 'Nextpage deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete nextpage']);
            }
        }
    }
}
