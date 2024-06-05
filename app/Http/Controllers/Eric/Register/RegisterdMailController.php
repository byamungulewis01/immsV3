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

class RegisterdMailController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('admin.register.mailregistered', compact('branches'));
    }
    public function registerre($id){
        $inboxings = Inboxing::where('location',decrypt($id))->where('instatus','0')->where('mailtype','r')
        ->orderBy('id', 'desc')->get();
        $boxes = Box::all();
        $branches = Branch::all();
        $bras = Branch::where('id',decrypt($id))->get();
        return view('admin.register.registeredmailformreg',compact('branches','boxes','id','inboxings','bras'));

    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'intracking' => 'required',
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
        $formField['mailtype'] = 'r';
         $formField['amount'] = '0';
         $formField['userid'] = auth()->user()->id;
         $formField['bid'] = auth()->user()->branch;
         $un=str_pad(Namming::where('type', 'r')->count()+1,4,"0",STR_PAD_LEFT);
         $formField['innumber'] = 'R-'. $un;
         if($request->intracking == 0){
            $totalomt = Branch::where('id',$request->location)->sum('rmt');
         if ($totalomt == 0) {
            return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
         } else {
            if($totalomt ==0){
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{


            $inbox = Inboxing::create($formField);
         Namming::create(['type' => 'r', 'number' => $inbox->innumber ]);
         Branch::where('id',$request->location)->decrement('rmt');
         }
        }
         $newtotal = Branch::where('id',$request->location)->sum('rmt');
         }
         else{
            $totalomt = Branch::where('id',$request->location)->sum('rmt');
            if($totalomt ==0)
            {
                return back()->with('warning', 'Mail not Registered Becouse Quantity Remaining is 0 .');
            }
            else{

            $inboxings = Inboxing::where('intracking',$request->intracking)->where('mailtype','r')->count();
            if($inboxings == 0){
                $inbox = Inboxing::create($formField);
                Namming::create(['type' => 'r', 'number' => $inbox->innumber ]);
                Branch::where('id',$request->location)->decrement('rmt');
                $newtotal = Branch::where('id',$request->location)->sum('rmt');

            }
            else{
                return back()->with('warning', 'Mail not Registered Becouse Tracking Number is already exists');
            }
        }
            $newtotal = Branch::where('id',$request->location)->sum('rmt');

         }

        return back()->with('success', 'Registerd Mail Inserted successful and Quantity Remaining Are: .'. $newtotal);
    }
    public function update(Request $request, $id)
{
    $formField = $request->validate([
        'intracking' => 'required',
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

    Inboxing::findOrFail($id)->update($formField);

    return back()->with('success', 'Registered Mail Updated Successfully');
}

    public function destroy($id)
    {
        Inboxing::findorfail(decrypt($id))->delete();
        return back()->with('success', 'Deleted Successfully');
    }

}
