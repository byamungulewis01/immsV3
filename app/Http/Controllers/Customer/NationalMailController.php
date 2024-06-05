<?php

namespace App\Http\Controllers\Customer;

use App\Models\Box;
use Illuminate\Http\Request;
use App\Models\Customer\MyContacts;
use App\Models\NationalMailInvoice;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDispatch;
use App\Models\NationalMailDispatchDetails;
use App\Models\Customer\CustomerDispatchDetails;

class NationalMailController extends Controller
{
    //
    public function index()
    {
        $favorites = MyContacts::orderby('name')->where('customer_id',auth()->guard('customer')->user()->id)->get();
        $myMails = CustomerDispatch::where('customer_id',auth()->guard('customer')->user()->id)->orderby('id','desc')->get();
        return view('customer.nationalMail.createMail',compact('favorites','myMails'));
    }

    public function details($id)
    {
        $favorites = MyContacts::orderby('name')->where('customer_id',auth()->guard('customer')->user()->id)->get();
        $dispatches = CustomerDispatchDetails::where('dispatch_id',decrypt($id))->get();
        $dispatche = CustomerDispatch::findorfail(decrypt($id));

        return view('customer.nationalMail.mailDetails',compact('dispatches','dispatche','favorites'));
    }

    // store
    public function store(Request $request)
    {
        // validations
        $formField = $request->validate(['recepient' => 'required',]);

//   select my last NationalMail
    $lastMail = CustomerDispatch::where('customer_id',auth()->guard('customer')->user()->id)->latest()->first();
    if($lastMail){
        $indexDb = explode('-',$lastMail->dispatchNumber);
        $index = 'DSP-'.str_pad($indexDb[1]+1, 3, '0', STR_PAD_LEFT);
    }else{
        $index = 'DSP-001';
    }
    $status = ($request->status == 'on') ? 1 : 0;
    $send = Box::where('customer_id',auth()->guard('customer')->user()->id)
    ->where('EMSNationalContract','yes')->latest()->first();
     if(!$send){
        return back()->with('error','You do not have EMS National Contract');
     }else{
        $dispatch = CustomerDispatch::create([
            'dispatchNumber' => $index,
            'senderName' => $send->name,
            'senderPhone' => $send->phone,
            'senderPOBox' => $send->pob,
            'customer_id' => auth()->guard('customer')->user()->id,
            'status' => $status,
        ]);
    }

    foreach ($request->recepient as $value) {

        CustomerDispatchDetails::create([
        'dispatchNumber' => $dispatch->dispatchNumber,
        'dispatch_id' => $dispatch->id,
        'destination_id' => $value,
        'status' => $status,
        'pob' => MyContacts::findorfail($value)->owner_id == null ? null : MyContacts::findorfail($value)->box->pob,
        'customer_id' => MyContacts::findorfail($value)->owner_id == null ? null : MyContacts::findorfail($value)->box->customer_id,
       ]);
    }
  return to_route('customer.mails.index')->with('success','Registration done');

    }
    // sendMail
    public function sendMail(Request $request,$id)
    {
        $dispatche = CustomerDispatch::findorfail($id)->update(['status' => 1,'sentDate' => now()]);
        return to_route('customer.mails.index')->with('success','Mail sent');
    }
    // destroy
    public function destroy($id)
    {
        CustomerDispatchDetails::where('dispatch_id',$id)->delete();
        CustomerDispatch::findorfail($id)->delete();
        return to_route('customer.mails.index')->with('success','Mail deleted');
    }
    // remove
    public function remove(Request $request)
    {
      foreach ($request->checkAll as $value) {
        CustomerDispatchDetails::findorfail($value)->delete();
      }

     return back()->with('success','Mail deleted');

    }

    // add
    public function add(Request $request,$id)
    {
        $formField = $request->validate([
            'recepient' => 'required',]);
            foreach ($request->recepient as $value) {
                CustomerDispatchDetails::create([
                'dispatchNumber' => $request->dispatchNumber,
                'dispatch_id' => $id,
                'pob' => MyContacts::findorfail($value)->owner_id == null ? null : MyContacts::findorfail($value)->box->pob,
                'customer_id' => MyContacts::findorfail($value)->owner_id == null ? null : MyContacts::findorfail($value)->box->customer_id,
                'destination_id' => $value,
               ]);
            }
          return back()->with('success','Registration done');
    }
    // verify
    public function verify(Request $request,$id)
    {
        $combined = $request->digit1.$request->digit2.$request->digit3.$request->digit4.$request->digit5;
        $dispatcher = CustomerDispatch::findorfail($id);
        if($dispatcher->securityCode == $combined){
            $dispatcher->update(['status' => 3,'deliveryDate' => now()]);
            CustomerDispatchDetails::where('dispatch_id',$id)->update(['status' => 1,'pickUpDate' => now()]);
            return to_route('customer.mails.index')->with('success','Mail verified');
        }else{
            return back()->with('error','Invalid security code');
        }
    }

    // invoice
    public function invoice()
    {
        $invoices = NationalMailInvoice::where('customer', auth()->guard('customer')->user()->id)->get();
        return view('customer.nationalMail.invoice',compact('invoices'));
    }
    // payInvoice
    public function payInvoice(Request $request,$id)
    {
        $invoice = NationalMailInvoice::findorfail($id);
        if ($request->hasFile('attachment')) {
            $ibm_attachment = $request->file('attachment');
            $filename = time() . '.' . $ibm_attachment->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/ibm_attachment');
            $ibm_attachment->move($destinationPath, $filename);
        }

        $invoice->update([
            'invoice_payment_status' => 'paid',
            'invoice_payment_attachment' => $filename,
            'invoice_payment_date' => now(),
        ]);

        return back()->with('success','Invoice Uploaded');
    }
    // download ibm attachment
    public function download($id)
    {
        $invoice = NationalMailInvoice::findorfail($id);
        $file = public_path(). "/uploads/ibm_attachment/".$invoice->invoice_ibm_attachment;
        $headers = array(
                  'Content-Type: application/pdf',
                );
        return response()->download($file, $invoice->invoice_ibm_attachment, $headers);
    }
    public function showInvoice($id)
    {
        $invoice = NationalMailInvoice::findorfail($id);
        $customer = $invoice->customer;
        $month = $invoice->invoice_month;
        $year = $invoice->invoice_year;

        $mails = NationalMailDispatchDetails::where('customer_id', $customer)
            ->where('status', 1)->whereMonth('dateReceived', $month)->whereYear('dateReceived', $year)->get();

        // $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.dispatchInvoice.showInvoice', compact('mails', 'invoice_number'))
        // ->setPaper('a4', 'portrait');
        // return $pdf->stream(time() . '.pdf');

        return view('customer.nationalMail.invoiceDetails', compact('mails', 'invoice'));
    }

}
