<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoxCategory;
use Illuminate\Http\Request;

class BoxCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BoxCategory::orderBy('name')->get();
        return view('admin.box-categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:box_categories,name',
        ]);
        BoxCategory::create($request->all());
        return redirect()->back()->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(BoxCategory $boxCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BoxCategory $boxCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BoxCategory $boxCategory)
    {
        $request->validate([
            'name' => 'required|unique:box_categories,name,' . $boxCategory->id,
        ]);
        $boxCategory->update($request->all());
        return redirect()->back()->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BoxCategory $boxCategory)
    {
        $boxCategory->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
