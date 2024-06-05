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

class RegisteredLetterController extends Controller
{
    public function index()
    {
        $results = DB::table('total_all_mails')->select('rlt')->get();
        $branches = Branch::all();
        return view('admin.register.registeredletter', compact('branches','results'));
    }
    public function registerrl($id){
        $inboxings = Inboxing::where('location',decrypt($id))->where('instatus','0')->where('mailtype','rl')->get() ;
        $boxes = Box::all();
        $branches = Branch::all();
        $bras = Branch::where('id',decrypt($id))->get();
        return view('admin.register.registeredletterformreg',compact('branches','boxes','id','inboxings','bras'));

    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'intracking' => '',
            'inname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'orgcountry' => 'required',
            'phone' => '',
            'pob' => '',
            'location' => 'required',
            'comment' => 'required',
            'pob_bid' => 'numeric',
        ]);
        $pob = (int) $request->pob;
        $box = Box::where('pob',$pob)->where('branch_id',$request->pob_bid)->first();
        $pobnum = ($box) ? $box->customer_id : null ;

        $formField['customer_id'] =  $pobnum;
        $formField['mailtype'] = 'rl';
        $formField['amount'] = '0';
        $formField['weight'] = '0';
        $formField['userid'] = auth()->user()->id;
        $formField['bid'] = auth()->user()->branch;
        $un=str_pad(Namming::where('type', 'rl')->count()+1,4,"0",STR_PAD_LEFT);
        $formField['innumber'] = 'RL-'. $un;
        if($request->intracking == 0){
           $totalomt = Branch::where('id',$request->location)->sum('rlt');
        if ($totalomt == 0) {
           return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
        } else {
            if($totalomt ==0){
            return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

           $inbox = Inboxing::create($formField);
        Namming::create(['type' => 'rl', 'number' => $inbox->innumber ]);
        Branch::where('id',$request->location)->decrement('rlt');
        }
    }
        $newtotal = Branch::where('id',$request->location)->sum('rlt');
        }
        else{
            $totalomt = Branch::where('id',$request->location)->sum('rlt');
            if($totalomt ==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{


           $inboxings = Inboxing::where('intracking',$request->intracking)->where('mailtype','rl')->count();
           if($inboxings == 0){
               $inbox = Inboxing::create($formField);
               Namming::create(['type' => 'rl', 'number' => $inbox->innumber ]);
               Branch::where('id',$request->location)->decrement('rlt');
               $newtotal = Branch::where('id',$request->location)->sum('rlt');

           }
           else{
               return back()->with('warning', 'Mail not Registered Becouse Tracking Number is already exists');
           }
        }
           $newtotal = Branch::where('id',$request->location)->sum('rlt');

        }

       return back()->with('success', 'Registered Letter Inserted successful and Quantity Remaining Are: .'. $newtotal);
    }
    public function update(Request $request,$id)
    {
        $formField = $request->validate([
            'intracking' => '',
            'inname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'orgcountry' => 'required',
            'phone' => '',
            'pob' => '',
            'comment' => 'required',
            'pob_bid' => 'numeric',
        ]);
        $box = Box::where('pob',$request->pob)->where('branch_id',$request->pob_bid)->first();
        $formField['customer_id'] = @$box->customer_id;
        Inboxing::findorfail($id)->update($formField);
        return back()->with('success', 'Registered Letter Updated Successfully');
    }
    public function destroy($id)
    {
        Inboxing::findorfail($id)->delete();
        back()->with('success', 'Deleted Successfully');
    }
}
