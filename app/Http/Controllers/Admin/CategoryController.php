<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate and store data
        $this->validate($request, [
            'categoryname' => 'required',
            'categorydescription' => 'required',
        ]);
        //store date in Category table
        $category = new Category();
        $category->categoryname = $request->categoryname;
        $category->categorydescription = $request->categorydescription;
        $category->save();
        return redirect()->route('admin.category.index')->with('success', 'Category created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate and save data in category table
        $this->validate($request, [
            'editcategoryname' => 'required',
            'editcategorydescription' => 'required',
        ]);
        //store date in Category table
        $category = Category::findorfail($id);
        $category->categoryname = $request->editcategoryname;
        $category->categorydescription = $request->editcategorydescription;
        $category->save();
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete dae from DB
        $category = Category::findorfail($id);
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
    }
}
