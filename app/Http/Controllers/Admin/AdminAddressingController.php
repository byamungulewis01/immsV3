<?php

namespace App\Http\Controllers\Admin;

use App\Models\Addressing;
use App\Models\MembersAddress;
use App\Http\Controllers\Controller;

class AdminAddressingController extends Controller
{
    //index
    public function individual()
    {
        $addresses = Addressing::where('customer_type', 'individual')->get();
        return view('admin.addressing.individual', compact('addresses'));
    }
    // company
    public function company()
    {
        $addresses = Addressing::where('customer_type', 'company')->get();
        return view('admin.addressing.company', compact('addresses'));
    }
    // companyShow
      public function members($id)
    {
        $addressings = MembersAddress::orderBy('name', 'asc')->where('addressing_id', $id)->get();
        return view('admin.addressing.members', compact('addressings', 'id'));
    }
    // map
    public function map()
    {
        return view('admin.addressing.map');
    }
}
