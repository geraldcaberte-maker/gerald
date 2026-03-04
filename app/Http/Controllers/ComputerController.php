<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('welcome', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        Brand::create($request->all());

        return redirect()->route('brands.index')
            ->with('success', 'Brand Added Successfully!');
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $brand->update($request->all());

        return redirect()->route('brands.index')
            ->with('success', 'Brand Updated Successfully!');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'Brand Deleted Successfully!');
    }
}
