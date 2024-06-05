<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WalletContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $wallets = Wallet::where('user_id', auth()->user()->id)->get();
        return view('transactions.wallet',compact('wallets'));

    }
    public function reports()
    {
        //
        $wallets = Wallet::where('user_id', auth()->user()->id)->get();
        return view('transactions.wallet_reports',compact('wallets'));

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
            'amount' => 'required|numeric',
            'description' => 'required',
            'file' => 'required|mimes:png,jpg,jpeg,pdf|max:10000',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $attach = date('His') . '-' . $filename;
            $file->move(public_path('wallets'), $attach);
            $request->merge(['attachment' => $attach]);
        }

        $request->merge(['user_id' => auth()->user()->id]);
        Wallet::create($request->all());
        return back()->with('message', 'Wallet created successfully');
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
    public function update(Request $request, $id)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required',
            'file' => 'nullable|mimes:png,jpg,jpeg,pdf|max:10000',
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $attach = date('His') . '-' . $filename;
            $file->move(public_path('wallets'), $attach);
            $request->merge(['attachment' => $attach]);
        }

        Wallet::findOrFail($id)->update($request->all());
        return back()->with('message', 'Wallet updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Wallet::findOrFail($id)->delete();
        return back()->with('message', 'Wallet deleted successfully');
    }
    public function approval(string $id)
    {
        Wallet::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('message', 'Wallet Approve successfully');
    }
    public function reject(string $id)
    {
        Wallet::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('message', 'Wallet Rejected successfully');
    }
}
