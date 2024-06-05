<?php

namespace App\Http\Controllers\Cntp;

use App\Models\Box;
use App\Models\Branch;
use App\Models\Eric\Namming;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class JurnalMailController extends Controller
{
    public function index()
    {
        $results = DB::table('total_all_mails')->select('omt')->get();
        $branches = Branch::all();
        return view('admin.register.jurnalregistration', compact('branches','results'));
    }
    public function registerpri($id){
        $inboxings = Inboxing::where('location',decrypt($id))->where('instatus','0')->where('mailtype','JUR')
        ->orderBy('id', 'desc')->get();
        $boxes = Box::all();
        $branches = Branch::all();
        $bras = Branch::where('id',decrypt($id))->get();
        return view('admin.register.jurnalformreg',compact('branches','boxes','id','inboxings','bras'));

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
        $formField['mailtype'] = 'JUR';
        $formField['amount'] = '0';
        $formField['userid'] = auth()->user()->id;
        $formField['bid'] = auth()->user()->branch;
        $un=str_pad(Namming::where('type', 'JUR')->count()+1,4,"0",STR_PAD_LEFT);
        $formField['innumber'] = 'JUR-'. $un;
        if($request->intracking == 0){
           $totalomt = Branch::where('id',$request->location)->sum('jrt');
        if ($totalomt == 0) {
           return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
        } else {
            if($totalomt==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

           $inbox = Inboxing::create($formField);
        Namming::create(['type' => 'JUR', 'number' => $inbox->innumber ]);
        Branch::where('id',$request->location)->decrement('jrt');
        }
    }
        $newtotal = Branch::where('id',$request->location)->sum('jrt');
        }
        else{
            $totalomt = Branch::where('id',$request->location)->sum('jrt');
            if($totalomt ==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

           $inboxings = Inboxing::where('intracking',$request->intracking)->where('mailtype','JUR')->count();
           if($inboxings == 0){
               $inbox = Inboxing::create($formField);
               Namming::create(['type' => 'JUR', 'number' => $inbox->innumber ]);
               Branch::where('id',$request->location)->decrement('jrt');
               $newtotal = Branch::where('id',$request->location)->sum('jrt');
           }
           else{
               return back()->with('warning', 'Mail not Registered Becouse Tracking Number is already exists');
           }
        }
           $newtotal = Branch::where('id',$request->location)->sum('jrt');

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
        return back()->with('success', 'Jurnal Mail Updated Successfully');
    }
}
