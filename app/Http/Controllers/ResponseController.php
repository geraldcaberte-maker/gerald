<?php

namespace App\Http\Controllers;

use App\Models\response;
use App\Models\questioner;
use App\Models\category;
use App\Http\Requests\StoreresponseRequest;
use App\Http\Requests\UpdateresponseRequest;
use App\Models\Staffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sectype;
use App\Models\Peripheral;
use App\Models\Application;



use Illuminate\Support\Facades\Auth;



class ResponseController extends Controller

{

    public function index()
    {      
     $responses = Response::with('answers.question')->get();
    return view('response.index', compact('responses'));
    }
public function answers()
{
    return $this->hasMany(ResponseAnswer::class);
}
public function fetch()
{
    $data = \App\Models\Response::where('deleted', 0)->get();

    return response()->json($data);
}
public function sections(Request $request)
{

      $sections = Sectype::select('id','section_code')->get();

    return response()->json($sections);

}
    public function staffs(){
        $data=[];
        $response = Staffs::where('deleted', 0)->orderBy('last_name')->get();
        foreach($response as $key => $staff){
            $data[$key]['user_id'] = $staff->user_id;
            $data[$key]['fullname'] = $staff->FullName1();
            $data[$key]['section'] = $staff->Section();
            $data[$key]['section_id'] = $staff->Section_id();
        }
        return response()->json($data);
    }

    public function ict_staffs(){
        $data=[];
        $response = Staffs::where('deleted', 0)->orderBy('last_name')->get();
        foreach($response as $key => $staff){
            // if($staff->Section_id() == '1626919276261161883185'){
                $data[$key]['user_id'] = $staff->user_id;
                $data[$key]['fullname'] = $staff->FullName1();
            // }
        }
        return response()->json($data);
    }

//////////////////////////////////////////
    
   public function save(Request $request)
  {
    // ✅ VALIDATION
    $request->validate([
        'application_id' => 'required',
        'division_id'    => 'required',
        'ict_staff'      => 'required',
        'answers'        => 'required|array',
        'category_id'    => 'required',
    ]);

   $user = Auth::user();
    $userId = $user ? $user->id : 1;

    // ✅ SAFE JSON
    $applicants = is_array($request->applicants)
        ? $request->applicants
        : json_decode($request->applicants, true) ?? [];

    $peripherals = is_array($request->peripherals)
        ? $request->peripherals
        : json_decode($request->peripherals, true) ?? [];

    DB::beginTransaction();

    try {

        // ✅ SAVE RESPONSE
        $response = Response::create([
            'application_id' => $request->application_id,
            'user_id'        => $userId,
            'division_id'    => $request->division_id,
            'ict_staff'      => $request->ict_staff,
            'custodian'      => $request->custodian ?? null,
            'status'         => 1,
        ]);

        // ✅ SAVE ANSWERS
        foreach ($request->answers as $question_id => $answer) {
            DB::table('response_answers')->insert([
                'response_id' => $response->id,
                'question_id' => $question_id,
                'answer'      => $answer,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // ✅ SAVE APPLICATION
        foreach ($applicants as $app) {
            DB::table('application')->insert([
                'category_id' => $request->category_id,
                'question_id' => $app['question_id'] ?? null,
                'name'        => $app['name'] ?? null,
                'date_exp'    => $app['expiration'] ?? null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // ✅ SAVE PERIPHERALS
        foreach ($peripherals as $periph) {
            DB::table('peripherals')->insert([
                'category_id' => $request->category_id,
                'peripheral'  => $periph['name'] ?? null,
                'brand'       => $periph['brand'] ?? null,
                'serial'      => $periph['serial'] ?? null,
                'year'        => $periph['year'] ?? null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Saved successfully'
        ]);

    } catch (\Exception $e) {

        DB::rollback();

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}



    public function questioner()
    {
        $categories = Category::with('questions:id,category_id,question,is_required,input_type')->get();
        return response()->json($categories);
        $categories = Category::with(['questions' => function($q){
        $q->where('deleted',0);
    }])->where('deleted',0)->get();

    return response()->json($categories);
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