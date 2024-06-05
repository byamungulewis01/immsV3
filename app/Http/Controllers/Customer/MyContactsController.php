<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Customer\MyContacts;
use App\Http\Controllers\Controller;
use App\Models\Box;

class MyContactsController extends Controller
{
    //

    public function index()
    {
        $addresses = Box::where('hasAddress',true)->get();
        $contacts = MyContacts::orderby('name')->where('customer_id',auth()->guard('customer')->user()->id)->get();
        return view('customer.nationalMail.my-contacts',compact('contacts','addresses'));
    }
    public function show($id)
    {
        $customer = Box::findorfail(decrypt($id));
        $addresses = Box::where('hasAddress',true)->get();
        $contacts = MyContacts::orderby('name')->where('customer_id',auth()->guard('customer')->user()->id)->get();
        return view('customer.nationalMail.my-contacts',compact('customer','contacts','addresses'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:10',
            'address' => 'required'
        ]);
        $formField['customer_id'] = auth()->guard('customer')->user()->id;
        MyContacts::create($formField);
        return redirect()->back()->with('success', 'created successfully');
    }
    public function update(Request $request,$id)
    {
        $formField = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:10',
            'address' => 'required'
        ]);
        MyContacts::findorfail($id)->update($formField);
        return redirect()->back()->with('success', 'updated successfully');
    }
    public function destroy($id)
    {
        MyContacts::findorfail($id)->delete();
        return redirect()->back()->with('success', 'deleted successfully');
    }
    public function addOffice(Request $request,$id)
    {
        $member = Box::findorfail($id);
        MyContacts::create([
            'name' => $member->name,
            'email' => $member->email,
            'phone' => $member->phone,
            'address' => $member->officeAddress,
            'customer_id' => auth()->guard('customer')->user()->id,
            'owner_id' => $member->id,
            'address_type' => $request->type
        ]);
        return to_route('customer.my-contacts.index')->with('success', 'added successfully');
    }
    public function addHome(Request $request,$id)
    {
        $member = Box::findorfail($id);
        MyContacts::create([
            'name' => $member->name,
            'email' => $member->email,
            'phone' => $member->phone,
            'address' => $member->homeAddress,
            'customer_id' => auth()->guard('customer')->user()->id,
            'owner_id' => $member->id,
            'address_type' => $request->type
        ]);
        return to_route('customer.my-contacts.index')->with('success', 'added successfully');
    }

}
