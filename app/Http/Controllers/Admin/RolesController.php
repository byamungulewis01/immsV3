<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    //
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        $activities = Activity::activityGroupby();
        $users  = User::orderBy('name', 'asc')->get();
        $userRoles = Role::pluck('name')->toArray();
        return view('admin.roles', compact('roles', 'activities', 'users', 'userRoles'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
            'express' => 'required'
        ]);

        $express = $request->express;
        $permission = array_keys($request->get('permission'));

        if (!$express) {
            $name = Role::where('name', $request->name)->first();
            if ($name) {
                return to_route('admin.roles.index')->with('error', 'Role Already Exist');
            }
            $role = Role::create(['name' => $request->get('name')]);
            $role->syncPermissions($permission);

            return to_route('admin.roles.index')->with('success', 'Role Added Successfully');
        } else {
            $role = Role::findorfail($express);
            $role->update($request->only('name'));
            $role->syncPermissions($permission);
            return to_route('admin.roles.index')->with('success', 'Role Updated Successfully');
        }
    }

    public function destroy($id)
    {
        $role = Role::findorfail($id);
        $role->delete();
        return to_route('admin.roles.index')->with('success', 'Role Deleted Successfully');
    }
    #assign role to user
    public function assignRole(Request $request, $id)
    {
        $this->validate($request, [
            'roles' => 'required',
        ]);
        $user = User::findorfail($id);
        $newRoles = [];
        foreach ($request->roles as $role) {
            array_push($newRoles, $role);
        }
        $user->syncRoles($newRoles);
        return back()->with('success', 'Role Assigned Successfully');
    }
}
