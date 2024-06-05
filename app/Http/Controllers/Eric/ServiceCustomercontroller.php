<?php

namespace App\Http\Controllers\Eric;

use App\Http\Controllers\Controller;
use App\Models\servicetype;
use App\Models\Token;
use Illuminate\Http\Request;

class ServiceCustomercontroller extends Controller
{
    public function index()
    {
        $customers = Token::orderBy('token_id','DESC')->get();
        return view('admin.tarifs.customerreg', compact('customers'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'namecompany' => 'required',
            'phone' => 'required|numeric|unique:token,phone|min:10',
            'tin' => 'required|numeric|unique:token',
        ]);

        $bytes = random_bytes(16); // 16 bytes = 128 bits
        $token = bin2hex($bytes); // Convert bytes to hexadecimal representation
        $token = substr($token, 0, 64); // Truncate to 32 characters (64 hex digits)
        $formField['tokennumber'] = $token;
        $inbox = Token::create($formField);
        return back()->with('success', 'Customer Registration Successfully');
    }
    public function update(Request $request, $token_id)
{
    $formField = $request->validate([
        'namecompany' => 'required',
        'phone' => 'required|numeric|',
        'tin' => 'required|numeric|',
    ]);
    Token::findOrFail($token_id)->update($formField);
    return back()->with('success', 'Customer Updated Successfully');
}

    public function destroy($token_id)
    {
        Token::findorfail($token_id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
