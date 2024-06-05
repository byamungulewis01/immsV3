<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Box;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\NationalMailInvoice;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\NationalMailDispatchDetails;
use App\Http\Controllers\NotificationController;

class DispatchInvoiceController extends Controller
{
    //index
    public function index()
    {
        return view('admin.dispatchInvoice.index');
    }
    // api
    public function api()
    {
        $boxes = Box::where('serviceType', 'PBox')->where('EMSNationalContract', 'yes')->with('branch')
            ->orderBy('pob', 'asc')->get();
        return response()->json([
            'data' => $boxes,
            'status' => 200,
        ]);
    }
    // show
    public function show($id)
    {
        $customer = Box::findorfail($id)->customer_id;
        $invoices = NationalMailInvoice::where('customer', $customer)->orderBy('id', 'desc')->get();

        return view('admin.dispatchInvoice.show', compact('customer', 'invoices'));
    }
    // store
    public function store(Request $request)
    {

        // ibm_attachment
        if ($request->hasFile('ibm_attachment')) {
            $ibm_attachment = $request->file('ibm_attachment');
            $filename = time() . '.' . $ibm_attachment->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/ibm_attachment');
            $ibm_attachment->move($destinationPath, $filename);
        }

        $checkinvoice = NationalMailDispatchDetails::where('customer_id', $request->customer_id)
            ->where('status', 1)->whereMonth('dateReceived', $request->month)->get();

        if ($checkinvoice->isEmpty()) {
            return back()->with('error', 'No Invoice Found');
        } else {
            $total_amount = NationalMailDispatchDetails::where('customer_id', $request->customer_id)
                ->where('status', 1)->whereMonth('dateReceived', $request->month)->sum('price');
            $index = NationalMailInvoice::count();
            $index = $index + 1;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $invoice_number = 'NMI' . $index;

    //   check invoice month and year already exist
            $checkinvoice = NationalMailInvoice::where('customer', $request->customer_id)
                ->where('invoice_month', $request->month)->where('invoice_year', $request->year)->get();
            if (!$checkinvoice->isEmpty()) {
                return back()->with('error', 'Invoice Already Exist');
            }else{
            NationalMailInvoice::create(
                [
                    'invoice_number' => $invoice_number,
                    'invoice_month' => $request->month,
                    'invoice_year' => $request->year,
                    'invoice_status' => 'pending',
                    'invoice_total' => $total_amount,
                    'invoice_ibm_attachment' => $filename,
                    'invoice_payment_status' => 'pending',
                    'customer' => $request->customer_id,
                ]
            );
        }
        }
        return redirect()->back()->with('success', 'Invoice Created Successfully');

    }
    // showInvoice
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
        $pdf = Pdf::loadView('admin.dispatchInvoice.invoice', compact('mails', 'invoice'))
        ->setPaper('a4', 'portrait');
         return $pdf->stream('invoice.pdf');

        // return view('admin.dispatchInvoice.invoices', compact('mails', 'invoice'));
    }

    // notificationStore
    public function notificationStore(Request $request,$id)
    {
        $formField = $request->validate([
            'subject' => 'required',
            'message' => 'required|min:10',
            'sent' => 'required',
            'attachment' => 'max:10240', // Maximum file size of 10 MB
        ]);

        $attachment = $request->file('attachment');
        if ($attachment) {
            $attachmentPath = $attachment->store('attachment');
        }
        $invoice = NationalMailInvoice::findorfail($id);
        $customer = Customer::findorfail($invoice->customer);
         $sent = implode(',', $request->sent);
            if ($sent == 'EMAIL') {
             (new NotificationController)->nationalMailInvoice($customer->email,$request->subject,$request->message,$attachmentPath);
            }elseif ($sent == 'SMS') {
             (new NotificationController)->notify_sms($request->message,$customer->phone);
            } else{
                (new NotificationController)->nationalMailInvoice($customer->email,$request->subject,$request->message,$attachmentPath);
                (new NotificationController)->notify_sms($request->message,$customer->phone);

          }
     return back()->with('success', 'Notified Successfully');
    // paymentStore

    }
    public function download($id)
    {
        $invoice = NationalMailInvoice::findorfail($id);
        $file = public_path(). "/uploads/ibm_attachment/".$invoice->invoice_payment_attachment;
        $headers = array(  'Content-Type: application/pdf',);
        return response()->download($file, $invoice->invoice_payment_attachment, $headers);
    }


}
