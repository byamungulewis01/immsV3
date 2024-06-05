<?php

namespace App\Http\Controllers\Customer;

use App\Models\Box;
use App\Models\Addressing;
use Illuminate\Http\Request;
use App\Models\MembersAddress;
use App\Http\Controllers\Controller;

class AddressingController extends Controller
{
    //index
    public function index($id)
    {
        $box = Box::findorfail(decrypt($id));
        $members = MembersAddress::where('box_id', decrypt($id))->get();
        return view('customer.pobox.addresses', compact('box', 'members'));
    }
    // members
    public function members($id)
    {
        $addressings = MembersAddress::orderBy('name', 'asc')->where('addressing_id', $id)->get();
        return view('customer.addressing.members', compact('addressings', 'id'));
    }

    //membersStore

    public function changeOfficeAddress(Request $request,$id)
    {
        $formField = $request->validate([
            'officePhone' => 'required|numeric',
            'officeEmail' => 'required|email',
            'officeAddress' => 'required',
            'profile' => request()->hasFile('profile') ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : '',
        ]);

        $formField['officeVisible'] = $request->has('officeVisible') ? 'public' : 'private';
        $formField['officeLocation'] = $request->longitude . ',' . $request->latitude;

        // upload photo
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/addressing');
            $image->move($destinationPath, $name);
            $formField['profile'] = $name;
        }
        $formField['hasAddress'] = true;
        Box::findorfail($id)->update($formField);
        return redirect()->back()->with('success', 'Address changed successfully');

    }
    public function changeHomeAddress(Request $request,$id)
    {
        $formField = $request->validate([
            'homePhone' => 'required|numeric',
            'homeEmail' => 'required|email',
            'homeAddress' => 'required',
            'profile' => request()->hasFile('profile') ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : '',
        ]);

        $formField['homeVisible'] = $request->has('homeVisible') ? 'public' : 'private';
        $formField['homeLocation'] = $request->longitude . ',' . $request->latitude;

        // upload photo
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/addressing');
            $image->move($destinationPath, $name);
            $formField['profile'] = $name;
        }
        $formField['hasAddress'] = true;
        Box::findorfail($id)->update($formField);
        return redirect()->back()->with('success', 'Address changed successfully');

    }
    // update
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'customer_type' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:addressings,email,' . $id,
            'phone' => 'required|numeric|unique:addressings,phone,' . $id,
            'pob' => 'required',
            'address' => 'required',
            'photo' => request()->hasFile('photo') ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : '',
            'website' => request()->has('website') ? 'required' : '',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);
        //visible
        $formField['visible'] = $request->has('visible') ? 'public' : 'private';
        //description
        $formField['description'] = $request->description;
        $oldIndex = Addressing::findorfail($id)->index;
        $index0 = explode('-', $oldIndex);
        $index = 'P' . $request->pob . '-' . $index0[1];

        $formField['index'] = $index;
        $formField['customer_id'] = auth()->guard('customer')->user()->id;
        // upload photo
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/addressing');
            $image->move($destinationPath, $name);
            $formField['photo'] = $name;
        }
        Addressing::findorfail($id)->update($formField);
        $member = MembersAddress::where('addressing_id', $id)->get();
        foreach ($member as $m) {
            $oIndex = explode('/', $m->index);
            $m->update(['index' => $index . '/' . $oIndex[1]]);
        }
        return redirect()->back()->with('success', 'Addressing updated successfully');
    }
    // delete
    public function destroy($id)
    {
        Addressing::findorfail($id)->delete();

        MembersAddress::where('addressing_id', $id)->delete();

        return redirect()->back()->with('success', 'Addressing deleted successfully');
    }
    public function membersStore(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|unique:members_addresses,phone',
            'email' => 'required|email|unique:members_addresses,email',
            'photo' => request()->hasFile('photo') ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : '',
            'post' => 'required',
        ]);
        //visible
        $formField['visible'] = $request->has('visible') ? 'public' : 'private';
        //description

        $formField['description'] = $request->description;
        $formField['box_id'] = $id;

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/addressing');
            $image->move($destinationPath, $name);
            $formField['photo'] = $name;
        }
        //store
        MembersAddress::create($formField);
        return redirect()->back()->with('success', 'Member Added Successfully');
    }
    // members update
    public function membersUpdate(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|unique:members_addresses,phone,' . $id,
            'email' => 'required|email|unique:members_addresses,email,' . $id,
            'photo' => request()->hasFile('photo') ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : '',
            'post' => 'required',
        ]);
        //visible
        $formField['visible'] = $request->has('visible') ? 'public' : 'private';
        //description

        $formField['description'] = $request->description;
        //photo
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/addressing');
            $image->move($destinationPath, $name);
            $formField['photo'] = $name;
        }
        //store
        MembersAddress::findorfail($id)->update($formField);
        return redirect()->back()->with('success', 'Member Updated Successfully');
    }
    // members delete
    public function membersDestroy($id)
    {
        MembersAddress::findorfail($id)->delete();
        return redirect()->back()->with('success', 'Member Deleted Successfully');
    }

}
