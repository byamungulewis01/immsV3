<?php

namespace App\Http\Controllers\Eric;

use App\Models\Box;
use App\Models\Branch;
use App\Models\Eric\Namming;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\TotalAllMails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MailRegistrationController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('admin.register.mailregistration', compact('branches'));
    }
    public function registero($id){
        $inboxings = Inboxing::where('location',decrypt($id))->where('instatus','0')->where('mailtype','o')
        ->orderBy('id', 'desc')->get();
        $boxes = Box::all();
        $branches = Branch::all();
        $bras = Branch::where('id',decrypt($id))->get();
        return view('admin.register.ordinaryformreg',compact('branches','boxes','id','inboxings','bras'));

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
        $formField['mailtype'] = 'o';
        $formField['amount'] = '500';
        $formField['userid'] = auth()->user()->id;
        $formField['bid'] = auth()->user()->branch;
        $un=str_pad(Namming::where('type', 'o')->count()+1,4,"0",STR_PAD_LEFT);
        $formField['innumber'] = 'O-'. $un;
        if($request->intracking == 0){
           $totalomt = Branch::where('id',$request->location)->sum('omt');
        if ($totalomt == 0) {
           return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
        } else {
            if($totalomt==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

           $inbox = Inboxing::create($formField);
            Namming::create(['type' => 'o', 'number' => $inbox->innumber ]);
            Branch::where('id',$request->location)->decrement('omt');
             }
         }
        $newtotal = Branch::where('id',$request->location)->sum('omt');
        }
        else{
            $totalomt = Branch::where('id',$request->location)->sum('omt');
            if($totalomt ==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

           $inboxings = Inboxing::where('intracking',$request->intracking)->where('mailtype','o')->count();
           if($inboxings == 0){
               $inbox = Inboxing::create($formField);
               Namming::create(['type' => 'o', 'number' => $inbox->innumber ]);
               Branch::where('id',$request->location)->decrement('omt');
               $newtotal = Branch::where('id',$request->location)->sum('omt');
           }
           else{
               return back()->with('warning', 'Mail not Registered Becouse Tracking Number is already exists');
           }
        }
           $newtotal = Branch::where('id',$request->location)->sum('omt');

        }


        return back()->with('success', 'Ordinary Mail Registed successful and Quantity Remaining Are: .'. $newtotal);
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
        return back()->with('success', 'Ordinary Mail Updated Successfully');
    }

    public function destroy($id)
    {
        Inboxing::findorfail($id)->delete();
        back()->with('success', 'Deleted Successfully');
    }


}
