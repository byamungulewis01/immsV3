<?php

namespace App\Http\Controllers\Cntp;

use App\Models\Box;
use App\Models\Branch;
use App\Models\Eric\Namming;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GoogleadMailController extends Controller
{
    public function index()
    {
        $results = DB::table('total_all_mails')->select('omt')->get();
        $branches = Branch::all();
        return view('admin.register.googleadregistration', compact('branches','results'));
    }
    public function registerpri($id){
        $inboxings = Inboxing::where('location',decrypt($id))->where('instatus','0')->where('mailtype','GAD')
        ->orderBy('id', 'desc')->get();
        $boxes = Box::all();
        $branches = Branch::all();
        $bras = Branch::where('id',decrypt($id))->get();
        return view('admin.register.googleadmailformreg',compact('branches','boxes','id','inboxings','bras'));

    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'intracking' => '',
            'inname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'orgcountry' => 'required',
            'phone' => '',
            'pob' => '',
            'location' => 'required|numeric',
            'weight' => 'required|numeric',
            'comment' => 'required',
            'pob_bid' => 'numeric',
        ]);
        $pob = (int) $request->pob;
        $box = Box::where('pob',$pob)->where('branch_id',$request->pob_bid)->first();
        $pobnum = ($box) ? $box->customer_id : null ;

        $formField['customer_id'] =  $pobnum;
        $formField['mailtype'] = 'GAD';
        $formField['amount'] = '1000';
        $formField['userid'] = auth()->user()->id;
        $formField['bid'] = auth()->user()->branch;
        $un=str_pad(Namming::where('type', 'GAD')->count()+1,4,"0",STR_PAD_LEFT);
        $formField['innumber'] = 'GAD-'. $un;
        if($request->intracking == 0){
           $totalomt = Branch::where('id',$request->location)->sum('gadt');
        if ($totalomt == 0) {
           return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
        } else {
            if($totalomt==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

           $inbox = Inboxing::create($formField);
        Namming::create(['type' => 'GAD', 'number' => $inbox->innumber ]);
        Branch::where('id',$request->location)->decrement('gadt');
        }
    }
        $newtotal = Branch::where('id',$request->location)->sum('gadt');
        }
        else{
            $totalomt = Branch::where('id',$request->location)->sum('gadt');
            if($totalomt ==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

           $inboxings = Inboxing::where('intracking',$request->intracking)->where('mailtype','GAD')->count();
           if($inboxings == 0){
               $inbox = Inboxing::create($formField);
               Namming::create(['type' => 'GAD', 'number' => $inbox->innumber ]);
               Branch::where('id',$request->location)->decrement('gadt');
               $newtotal = Branch::where('id',$request->location)->sum('gadt');
           }
           else{
               return back()->with('warning', 'Mail not Registered Becouse Tracking Number is already exists');
           }
        }
           $newtotal = Branch::where('id',$request->location)->sum('gadt');

        }


        return back()->with('success', 'Printed Material Registration successful and Quantity Remaining Are: .'. $newtotal);
    }
    public function update(Request $request,$id)
    {
        $formField = $request->validate([
            'intracking' => '',
            'inname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'orgcountry' => 'required',
            'phone' => '',
            'pob' => '',
            'weight' => 'required|numeric',
            'comment' => 'required',
            'pob_bid' => 'numeric',
        ]);
        $box = Box::where('pob',$request->pob)->where('branch_id',$request->pob_bid)->first();
        $formField['customer_id'] = @$box->customer_id;
        Inboxing::findorfail($id)->update($formField);
        return back()->with('success', 'GADnal Mail Updated Successfully');
    }
}
