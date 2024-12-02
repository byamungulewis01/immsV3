<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Setting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class SettingController extends Controller
{
    //
    public function index()
    {
        $activities = Activity::orderBy('name')->get();
        $settings = Setting::all();

        return view('admin.settings', compact('activities', 'settings'));
    }
    public function activityStore(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required|unique:activities,name',
        ]);
        Activity::create($formField);
        return to_route('admin.setting.index')->with('success', 'Activity Added Successfully');
    }
    public function activityUpdate(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => 'required|unique:activities,name,' . $id,
        ]);
        Activity::findorfail($id)->update($formField);
        return to_route('admin.setting.index')->with('success', 'Activity Updated Successfully');
    }
    public function othersUpdate(Request $request, $id)
    {
        $request->validate([
            'value' => 'required',
        ]);
        Setting::findorfail($id)->update(['value' => $request->value]);
        return to_route('admin.setting.index')->with('success', 'Setting Updated Successfully');
    }
    public function activityDestroy($id)
    {
        $activity = Activity::findorfail($id);
        Permission::where('activity_id', $activity->id)->delete();
        $activity->delete();
        return to_route('admin.setting.index')->with('success', 'Activity Deleted Successfully');
    }
}
