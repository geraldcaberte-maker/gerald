<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
{
    $brands = Brand::where('deleted', 0)
               ->orderBy('id', 'desc')
               ->get();
    return view('welcome', compact('brands'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $brand = Brand::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json($brand);
    }

   public function update(Request $request, $id)
{
    // Validate inputs
    $request->validate([
        'name' => 'required|string|max:50',
        'status' => 'required|in:0,1',
    ]);

    // Hanapin ang brand
    $brand = Brand::findOrFail($id);

    // I-update lang ang name at status
    $brand->update([
        'name' => $request->name,
        'status' => $request->status,
    ]);

    // Ibalik sa JSON response
    return response()->json($brand);
}

// BrandController.php

public function destroy($id)
{
    Brand::findOrFail($id)->delete();
    return response()->json(['success' => true]);
}

public function fetch()
{
    $brands = Brand::where('deleted', 0)->orderBy('id', 'desc')->get();
    return view('users.partials.brands_table', compact('brands'));
}


}
