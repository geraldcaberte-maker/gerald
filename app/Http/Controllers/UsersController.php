<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Brand;
class UsersController extends Controller
{
    // Show users page
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
public function nextpage()
{$brands = Brand::where('deleted',0)->orderBy('id','desc')->get();
    return view('users.nextpage', compact('brands'));
   // return view('users.nextpage'); // siguraduhin may blade file ka
}
public function dashboard()
{
    return view('users.dashboard'); // siguraduhin may blade file ka
}
public function technical()
{
    return view('users.technical'); // siguraduhin may blade file ka
}
    // Fetch users via AJAX
    public function fetch()
    {
        $model = User::where('deleted', 0)->orderBy('name')->get();
        return response()->json(['users' => $model]);
    }

    // Save or update user via AJAX
    public function save(Request $request)
    {
        if ($request->id) {
            $user = User::find($request->id);
            if (!$user) return response()->json(['status' => 'false']);
        } else {
            $user = new User();
            $timestamp = substr(round(microtime(true) * 1000), -13);
            $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
            $user->id = $timestamp . $random;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $status = $user->save() ? 'true' : 'false';

        return response()->json(['status' => $status]);
    }

    // Fetch single user info
    public function info(Request $request)
    {
        $user = User::find($request->id);
        return response()->json($user);
    }

    // Soft delete user
    public function delete(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->deleted = 1;
            $status = $user->save() ? 'true' : 'false';
        } else {
            $status = 'false';
        }

        return response()->json(['status' => $status]);
    }
}
