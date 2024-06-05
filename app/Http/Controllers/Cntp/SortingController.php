<?php

namespace App\Http\Controllers\Cntp;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Eric\AirportDispach;
use App\Models\Eric\BranchDispach;
use Illuminate\Http\Request;

class SortingController extends Controller
{
    public function index1()
    {
        $inboxings = AirportDispach::wherein('status', [2, 3])->where('dispachetype', 'EMS')->whereNotnull('mailnumber')->orderBy('updated_at', 'desc')->get();

        return view('admin.cntp.sortingems', compact('inboxings'));
    }
    public function index2()
    {
        $inboxings = AirportDispach::wherein('status', [2, 3])->where('dispachetype', 'PERCEL')->whereNotnull('mailnumber')->orderBy('updated_at', 'desc')->get();
        return view('admin.cntp.sortingpercel', compact('inboxings'));
    }
    public function index3()
    {
        $inboxings = AirportDispach::wherein('status', [2, 3])->where('dispachetype', 'Mails')->where('regstatus', '2')->whereNotnull('mailnumberreg')->orderBy('updated_at', 'desc')->get();
        return view('admin.cntp.sortingregistered', compact('inboxings'));
    }
    public function index4()
    {
        $inboxings = AirportDispach::wherein('status', [2, 3])->where('dispachetype', 'Mails')->whereNull('regstatus')->orderBy('id', 'desc')->get();
        return view('admin.cntp.sortingallmails', compact('inboxings'));
    }
    public function viewemssort($id)
    {
        return view('admin.cntp.sortingviewems', compact('id'));
    }
    public function viewpercelsort($id)
    {

        return view('admin.cntp.sortingviewpercel', compact('id'));
    }
    public function viewregisteredsort($id)
    {
        $mail = AirportDispach::find(decrypt($id));
        $mailNumbers = explode(',', $mail->mailnumberreg);

        return view('admin.cntp.sortingviewregistered', compact('id','mailNumbers'));
    }
    public function viewallmailssort($id)
    {
        $mails = AirportDispach::find(decrypt($id));
        $mailNumbers = explode(',', $mails->mailnumber);
      
        return view('admin.cntp.sortingviewallmails', compact('id','mailNumbers'));
    }
    public function storeemssort(Request $request)
    {
        $itemsSize = count($request->item_id);
        $dispatchId = $request->dispatchId;

        // retrieve a mails number and validate ....
        $mails = AirportDispach::find($dispatchId);

        $totalQuantity = 0;
        for ($i = 0; $i < $itemsSize; $i++) {
            $totalQuantity += $request->quantity[$i];
            //validation ....
            if ($mails->mailnumber >= $totalQuantity) {
                $branch = Branch::find($request->item_id[$i]);
                $branch->emst += $request->quantity[$i];
                $branch->save();
                BranchDispach::create(['dispacher_id'=> $dispatchId, 'branch_id'=>$request->item_id[$i],'weights' => $request->weight[$i]]);
            } else {
                return back()->with('warning', 'Total Mail Number In Dispatch is '. $mails->mailnumber .' Does Not equal Number Of Dispatch You Entered');
            }
        }

        AirportDispach::findorfail($request->dispatchId)->update(['status' => 3, 'sorted_by' => auth()->user()->id, 'sorting_date' => now()]);
        return to_route('admin.cntpsort.CntpEmssorting')->with('success', 'EMS Sorting Is Completed Successfully');

    }
    public function storepercelsort(Request $request)
    {
        $itemsSize = count($request->item_id);
        $dispatchId = $request->dispatchId;

        // retrieve a mails number and validate ....
        $mails = AirportDispach::find($dispatchId);

        $totalQuantity = 0;
        for ($i = 0; $i < $itemsSize; $i++) {
            $totalQuantity += $request->quantity[$i];
            //validation ....
            if ($mails->mailnumber >= $totalQuantity) {
                $branch = Branch::find($request->item_id[$i]);
                $branch->pmt += $request->quantity[$i];
                $branch->save();
                BranchDispach::create(['dispacher_id'=> $dispatchId, 'branch_id'=>$request->item_id[$i],'weights' => $request->weight[$i]]);

            } else {
                return back()->with('warning', 'Total Mail Number In Dispatch is '. $mails->mailnumber .' Does Not equal Number Of Dispatch You Entered');

            }
        }
        AirportDispach::findorfail($request->dispatchId)->update(['status' => 3, 'sorted_by' => auth()->user()->id, 'sorting_date' => now()]);
        return to_route('admin.cntpsort.Cntppercelsorting')->with('success', 'Percel Mail Sorting Is Completed Successfully');
    }

    public function storeregisteredsort(Request $request)
    {

        $itemsSize = count($request->item_id);
        $dispatchId = $request->dispatchId;

        // Retrieve dispatch information and validate ...
        $mails = AirportDispach::find($dispatchId);
        $mailNumbers = explode(',', $mails->mailnumberreg);
        $rmt = $mailNumbers[0];
        $letter = $mailNumbers[1];

        $rmtTotal = 0;
        $letterTotal = 0;

        for ($i = 0; $i < $itemsSize; $i++) {
            $rmtTotal += $request->quantityone[$i];
            $letterTotal += $request->quantitytwo[$i];

            if ($rmt >= $rmtTotal && $letter >= $letterTotal) {
                $branch = Branch::find($request->item_id[$i]);
                $branch->rmt += $request->quantityone[$i];
                $branch->rlt += $request->quantitytwo[$i];
                $branch->save();
                BranchDispach::create(['dispacher_id'=> $dispatchId, 'branch_id'=>$request->item_id[$i],'weights' => $request->weight[$i]]);

            } else {
                return back()->with('error', 'The Total Mail Number In Dispatch Does Not Equal Number Of Dispatch You Entered');

            }
        }

        // Update dispatch status
        AirportDispach::findOrFail($request->dispatchId)->update(['status' => 3, 'sorted_by' => auth()->user()->id, 'sorting_date' => now()]);

        return redirect()->route('admin.cntpsort.Cntpregisteredsorting')->with('success', 'Parcel Mail Sorting Is Completed Successfully');
    }

    public function storeallmails(Request $request)
    {
        $itemsSize = count($request->item_id);
        $dispatchId = $request->dispatchId;

        // Retrieve dispatch information and validate ...
        $mails = AirportDispach::find($dispatchId);
        $mailNumbers = explode(',', $mails->mailnumber);
        $omt = $mailNumbers[0];
        $olt = $mailNumbers[1];
        $prmt = $mailNumbers[2];
        $jrt = $mailNumbers[3];
        $gadt = $mailNumbers[4];
        $podt = $mailNumbers[5];

        $omtTotal = 0;
        $oltTotal = 0;
        $prmtTotal = 0;
        $jrtTotal = 0;
        $gadtTotal = 0;
        $podtTotal = 0;

        for ($i = 0; $i < $itemsSize; $i++) {
            $omtTotal += $request->quantityone[$i];
            $oltTotal += $request->quantitytwo[$i];
            $prmtTotal += $request->quantitythree[$i];
            $jrtTotal += $request->quantityfour[$i];
            $gadtTotal += $request->quantityfive[$i];
            $podtTotal += $request->quantitysix[$i];

            if ($omt >= $omtTotal && $olt >= $oltTotal && $prmt >= $prmtTotal
                && $jrt >= $jrtTotal && $gadt >= $gadtTotal && $podt >= $podtTotal) {
                $branch = Branch::find($request->item_id[$i]);
                $branch->omt += $request->quantityone[$i];
                $branch->olt += $request->quantitytwo[$i];
                $branch->prmt += $request->quantitythree[$i];
                $branch->jrt += $request->quantityfour[$i];
                $branch->gadt += $request->quantityfive[$i];
                $branch->podt += $request->quantitysix[$i];
                $branch->save();
                BranchDispach::create(['dispacher_id'=> $dispatchId, 'branch_id'=>$request->item_id[$i],'weights' => $request->weight[$i]]);

            } else {

                return back()->with('error', 'The Total Mail Number In Dispatch Does Not Equal Number Of Dispatch You Entered');
            }
        }

        // Update dispatch status
        AirportDispach::findOrFail($request->dispatchId)->update(['status' => 3, 'sorted_by' => auth()->user()->id, 'sorting_date' => now()]);

        return redirect()->route('admin.cntpsort.Cntpallmailssorting')->with('success', 'Parcel Mail Sorting Is Completed Successfully');
    }

}
