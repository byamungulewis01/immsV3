<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::orderBy('activity_id')->get();
        $activities = Activity::orderBy('name')->get();
        return view('admin.permissions', compact('permissions', 'activities'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required|unique:permissions,name',
            'activity_id' => 'required',
        ]);
        $formField['guard_name'] = 'web';
        Permission::create($formField);
        return to_route('admin.permissions.index')->with('success', 'Permission Added Successfully');
    }
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'activity_id' => 'required',
        ]);
        Permission::findorfail($id)->update($formField);
        return to_route('admin.permissions.index')->with('success', 'Permission Updated Successfully');
    }
    // destroy
    public function destroy($id)
    {
        Permission::findorfail($id)->delete();
        return to_route('admin.permissions.index')->with('success', 'Permission Deleted Successfully');
    }
}
