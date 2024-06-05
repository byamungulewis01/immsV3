<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('admin.employee.index', compact('branches'));
    }
    public function active()
    {
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('admin.employee.active', compact('branches'));
    }
    public function inactive()
    {
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('admin.employee.inactive', compact('branches'));
    }
    public function deactivate()
    {
        return view('admin.employee.deactivated');
    }

    #store
    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone|min:10',
            'branch' => 'required',
            'level' => 'required',
            'cntpoffice' => 'nullable',
        ]);
        $formField['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        if ($request->level == 'register') {
            $request->validate(['office' => 'required',]);
            $formField['office'] = $request->office;
        }
        // if level is driver
        if ($request->level == 'driver') {
            $request->validate(['driverRole' => 'required', 'driving_category' => 'required', 'driving_licence' => 'required',]);
            $formField['driving_category'] = $request->driving_category;
            $formField['driverRole'] = $request->driverRole;
            // driving_licence upload
            if ($request->hasFile('driving_licence')) {
                $file = $request->file('driving_licence');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/driving_licence/', $filename);
                $formField['driving_license'] = $filename;
            }
        }

        User::create($formField);
        return back()->with('success', 'Employee Added Successfully');
    }
    #update
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|unique:users,phone,' . $id,
            'branch' => 'required',
            'level' => 'required',
            'status' => 'required',
            'cntpoffice' => 'nullable',
        ]);
        if ($request->level == 'register') {
            $request->validate(['office' => 'required',]);
            $formField['office'] = $request->office;
        }
        // if level is driver
        if ($request->level == 'driver') {
            $request->validate(['driverRole' => 'required', 'driving_category' => 'required', 'driving_licence' => 'required',]);
            $formField['driving_category'] = $request->driving_category;
            $formField['driverRole'] = $request->driverRole;
            // driving_licence upload
            if ($request->hasFile('driving_licence')) {
                $file = $request->file('driving_licence');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/driving_licence/', $filename);
                $formField['driving_license'] = $filename;
            }
        }
        User::findorfail($id)->update($formField);
        return back()->with('success', 'Employee Updated Successfully');
    }
    #destroy
    public function destroy($id)
    {
        User::findorfail($id)->delete();
        return back()->with('success', 'Employee Deleted Successfully');
    }
    // activate
    public function activate($id)
    {
        User::withTrashed()->findorfail($id)->restore();
        return back()->with('success', 'Employee Activated Successfully');
    }
    public function api()
    {
        $employees = User::with('branchname')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $employees
        ]);
    }
    public function activeApi()
    {
        $employees = User::with('branchname')->where('status', 'active')->orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => $employees
        ]);
    }
    public function inactiveApi()
    {
        $employees = User::with('branchname')->where('status', 'inactive')->orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => $employees
        ]);
    }
    // deactivateApi
    public function deactivateApi()
    {
        $employees = User::onlyTrashed()->with('branchname')->orderBy('deleted_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $employees
        ]);
    }
    #profile
    public function profile($id)
    {
        $user = User::findorfail($id);
        $roles = Role::pluck('name')->toArray();
        return view('admin.employee.profile', compact('user', 'roles'));
    }
    public function profileEdit()
    {
        $user = User::findorfail(auth()->user()->id);
        $roles = Role::pluck('name')->toArray();
        return view('admin.employee.profile', compact('user', 'roles'));
    }
    // profileUpdate
    public function profileUpdate(Request $request)
    {
        $formField = $request->validate([
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'phone' => 'required|numeric|unique:users,phone,' . auth()->user()->id,
        ]);
        User::findorfail(auth()->user()->id)->update($formField);
        return back()->with('success', 'Profile Updated Successfully');
    }
    // changePassword
    public function changePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user = User::findorfail(auth()->user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => Hash::make($request->password)]);
            return back()->with('success', 'Password Changed Successfully');
        } else {
            return back()->with('error', 'Old Password Not Matched');
        }
    }
    public function changePassword2(Request $request, $id)
    {
         $request->validate([
            'password' => 'required|confirmed',
        ]);
        $user = User::findorfail($id);

        $user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password Changed Successfully');
    }
}
