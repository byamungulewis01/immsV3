<?php

namespace App\Http\Controllers\Eric\Register;

use App\Models\Box;
use App\Models\Branch;
use App\Models\Eric\Namming;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\TotalAllMails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrdinaryLetterController extends Controller
{
    public function index()
    {
        $results = DB::table('total_all_mails')->select('olt')->get();
        $branches = Branch::all();
        return view('admin.register.ordinaryletter', compact('branches','results'));
    }
    public function registerol($id){
        $inboxings = Inboxing::where('location',decrypt($id))->where('instatus','0')->where('mailtype','ol')
        ->orderBy('id', 'desc')->get();
        $boxes = Box::all();
        $branches = Branch::all();
        $bras = Branch::where('id',decrypt($id))->get();
        return view('admin.register.ordinarymailformreg',compact('branches','boxes','id','inboxings','bras'));

    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'inname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'orgcountry' => 'required',
            'phone' => 'numeric',
            'pob' => '',
            'location' => 'required',
            'pob_bid' => '',
        ]);
        $pob = (int) $request->pob;
        $box = Box::where('pob',$pob)->where('branch_id',$request->pob_bid)->first();
        $pobnum = ($box) ? $box->customer_id : null ;
        $formField['customer_id'] =  $pobnum;
        $formField['mailtype'] = 'ol';
        $formField['amount'] = '0';
        $formField['weight'] = '0';
        $formField['userid'] = auth()->user()->id;
        $formField['bid'] = auth()->user()->branch;
        $un=str_pad(Namming::where('type', 'ol')->count()+1,4,"0",STR_PAD_LEFT);
        $formField['innumber'] = 'OL-'. $un;
        if($request->intracking == 0){
           $totalomt = Branch::where('id',$request->location)->sum('olt');
        if ($totalomt == 0) {
           return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
        } else {
            if($totalomt ==0){
            return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

           $inbox = Inboxing::create($formField);
        Namming::create(['type' => 'ol', 'number' => $inbox->innumber ]);
        Branch::where('id',$request->location)->decrement('olt');
        }
    }
        $newtotal = Branch::where('id',$request->location)->sum('olt');
        }
        else{
            $totalomt = Branch::where('id',$request->location)->sum('olt');
            if($totalomt ==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{


           $inboxings = Inboxing::where('intracking',$request->intracking)->where('mailtype','ol')->count();
           if($inboxings == 0){
               $inbox = Inboxing::create($formField);
               Namming::create(['type' => 'ol', 'number' => $inbox->innumber ]);
               Branch::where('id',$request->location)->decrement('olt');
               $newtotal = Branch::where('id',$request->location)->sum('olt');

           }
           else{
               return back()->with('warning', 'Mail not Registered Becouse Tracking Number is already exists');
           }
        }
           $newtotal = Branch::where('id',$request->location)->sum('olt');

        }

       return back()->with('success', 'Ordinary Letter Inserted successful and Quantity Remaining Are: .'. $newtotal);
    }
    public function update(Request $request,$id)
    {
        $formField = $request->validate([
            'inname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'orgcountry' => 'required',
            'phone' => 'numeric',
            'pob' => '',
            'pob_bid' => '',
        ]);
        $box = Box::where('pob',$request->pob)->where('branch_id',$request->pob_bid)->first();
        $formField['customer_id'] = @$box->customer_id;
        Inboxing::findorfail($id)->update($formField);
        return back()->with('success', 'Ordinary Letter Updated Successfully');
    }
    public function destroy($id)
    {
        Inboxing::findorfail($id)->delete();
        back()->with('success', 'Deleted Successfully');
    }
}
