<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Box;
use App\Models\PobApplication;
use App\Models\PobBackup;
use App\Models\PobPay;
use App\Models\PreFormaBill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhysicalPobController extends Controller
{
    public function index()
    {
        return view('admin.physicalPob.index');
    }
    // api for pob
    public function pobApi($id)
    {
        $available = request('available');
        $boxes = Box::where('serviceType', 'PBox')
            ->where('branch_id', $id)
            ->when(!is_null($available), function ($query) use ($available) {
                if ($available == 0) {
                    $query->where('year', '>=', now()->year);
                } else {
                    $query->where('year', '<', now()->year);
                }
            })
            ->orderBy('pob', 'asc')
            ->get();

        return response()->json([
            'data' => $boxes,
            'status' => 200,
        ]);
    }

    #details
    public function details($id)
    {
        $box = Box::find($id);
        $years = Box::selectRaw('year')->groupBy('year')->get();
        $paidYear = $box->year + 1;
        $currentYear = now()->year + 5;
        $yearsNotpaid = [];
        for ($i = $paidYear; $i <= $currentYear; $i++) {
            $yearsNotpaid[] = $i;
        }
        $payments = PobPay::where('box_id', $id)->orderBy('year', 'desc')->limit(10)->get();
        return view('admin.physicalPob.detail', compact('box', 'years', 'yearsNotpaid', 'payments'));
    }
    public function approved()
    {
        $boxes = Box::where('aprooved', true)->where('serviceType', 'PBox')->where('branch_id', auth()->user()->branch_id)->orderBy('name')->limit(100)->get();
        return view('admin.physicalPob.approved', compact('boxes'));
    }
    #details
    public function waitingList()
    {
        //   $boxes = Box::where('branch_id', auth()->user()->branch_id)->get();
        $boxes = PobApplication::where('aprooved', false)->where('branch_id', auth()->user()->branch_id)->orderBy('name')
            ->get();
        return view('admin.physicalPob.waitingList', compact('boxes'));
    }
    public function update(Request $request, $id)
    {
        #validate
        $field = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|min:10',
            'year' => 'required',
            'pob_category' => 'required',
            'size' => 'required',
            'cotion' => 'required',
            'available' => 'required',
            'EMSNationalContract' => 'required',
        ]);
        #update
        $box = Box::find($id);
        $box->update($field);

        return redirect()->back()->with('success', 'Pob Updated Successfully');
    }

    # downloadAttachment
    public function download($id)
    {
        $file = public_path('attachments/' . $id);
        return response()->download($file);
    }

    #approve
    public function approve($id)
    {
        $box = PobApplication::find($id);
        $box->update(['aprooved' => true]);
        #box update where pob = $box->pob
        if ($box->is_new_customer == 'yes') {
            $existyPob = Box::where('pob', $box->pob)->first();
            // add in backup table
            PobBackup::create([
                'pob' => $existyPob->pob,
                'branch_id' => $existyPob->branch_id,
                'status' => $existyPob->status,
                'name' => $existyPob->name,
                'email' => $existyPob->email,
                'phone' => $existyPob->phone,
                'date' => $existyPob->date,
                'size' => $existyPob->size,
                'pob_category' => $existyPob->pob_category,
                'serviceType' => 'PBox',
                'pob_type' => $existyPob->pob_type,
                'amount' => $existyPob->amount,
                'year' => $existyPob->year,
                'attachment' => $existyPob->attachment,
                'available' => $existyPob->available,
                'cotion' => $existyPob->cotion,
                'customer_id' => $existyPob->customer_id,
                'profile' => $existyPob->profile,
                'visible' => $existyPob->visible,
                'homeAddress' => $existyPob->homeAddress,
                'homePhone' => $existyPob->homePhone,
                'homeLocation' => $existyPob->homeLocation,
                'officeAddress' => $existyPob->officeAddress,
                'officePhone' => $existyPob->officePhone,
                'officeLocation' => $existyPob->officeLocation,
            ]);

            Box::where('pob', $box->pob)->update([
                'aprooved' => true,
                'branch_id' => $box->branch_id,
                'status' => $box->status,
                'name' => $box->name,
                'email' => $box->email,
                'phone' => $box->phone,
                'date' => $box->created_at,
                'pob_category' => $box->pob_category,
                'pob_type' => $box->pob_type,
                'amount' => $box->amount,
                'year' => $box->year,
                'attachment' => $box->attachment,
                'available' => false,
                'booked' => true,
                'customer_id' => $box->customer_id,
            ]);
        } else {
            Box::where('pob', $box->pob)->update([
                'aprooved' => true,
                'branch_id' => $box->branch_id,
                'name' => $box->name,
                'email' => $box->email,
                'phone' => $box->phone,
                'pob_category' => $box->pob_category,
                'pob_type' => $box->pob_type,
                'attachment' => $box->attachment,
                'available' => false,
                'booked' => true,
                'customer_id' => $box->customer_id,
            ]);
        }
        return redirect()->back()->with('success', 'Pob Approved Successfully');
    }
    #reject
    public function reject($id)
    {
        $box = PobApplication::find($id);
        if ($box->is_new_customer == 'yes') {
            # code...
            $box->update(['aprooved' => 3]);
            #update box where pob = $box->pob
            Box::where('pob', $box->pob)->update(['aprooved' => false, 'available' => true, 'booked' => false]);
        } else {
            # code...
            $box->update(['aprooved' => 3]);
            #update box where pob = $box->pob
            Box::where('pob', $box->pob)->update(['aprooved' => false, 'booked' => false]);
        }
        return redirect()->back()->with('success', 'Pob Rejected Successfully');
    }
    #transfer
    public function transfer(Request $request, $id)
    {
        #update
        $box = Box::find($id);
        PobBackup::create(
            [
                'pob' => $box->pob,
                'branch_id' => $box->branch_id,
                'size' => $box->size,
                'status' => $box->status,
                'name' => $box->name,
                'email' => $box->email,
                'phone' => $box->phone,
                'available' => $box->available,
                'date' => $box->date,
                'pob_category' => $box->pob_category,
                'pob_type' => $box->pob_type,
                'amount' => $box->amount,
                'year' => $box->year,
                'attachment' => $box->attachment,
            ]
        );

        $box->update(['available' => true, 'booked' => false]);

        return redirect()->back()->with('success', 'Pob Transfered Successfully');
    }
    #paymentStore
    public function paymentStore(Request $request)
    {
        $field = $request->validate([
            'payment_type' => 'required',
            'payment_model' => 'required',
            'payment_ref' => 'required',
            'payment_year' => request()->has('payment_year') ? 'required' : '',
        ]);
        $box = Box::find($request->pob_id);

        $field['box_id'] = $request->pob_id;
        $field['amount'] = $request->allAmount;
        $field['serviceType'] = 'PBox';
        $field['bid'] = auth()->user()->branch;
        $field['user_id'] = auth()->user()->id;

        if ($request->payment_year == 'all') {
            // if allAmount is 0
            if ($request->allAmount == 0) {
                return redirect()->back()->with('alert', 'no debt to pay');
            }
            $field['year'] = now()->year;
            PobPay::create($field);
            $box->update(['year' => now()->year, 'status' => 'payee', 'date' => now()]);
        } else {
            if ($request->payment_year == '') {
                $field['year'] = now()->year;
                PobPay::create($field);
            } elseif ($request->payment_year == $box->year + 1) {
                $field['year'] = $request->payment_year;
                PobPay::create($field);
                $box->update(['year' => $request->payment_year, 'status' => 'payee', 'date' => now()]);
            } else {
                return redirect()->back()->with('alert', 'You next payment is ' . $box->year + 1);
            }
        }
        return redirect()->back()->with('success', 'Pob Updated Successfully');
    }
    #pobSelling
    public function pobSelling()
    {
        $boxes = Box::where('serviceType', 'PBox')->where('available', true)->where('branch_id', auth()->user()->branch)->orderBy('pob')->get();
        return view('admin.physicalPob.selling', compact('boxes'));
    }

    #pobSellingStore
    public function pobSellingPut(Request $request, $id)
    {
        $pob_type = ($request->category == 'Individual') ? 'Individual' : 'Company';
        $box = Box::find($id);
        $box->update([
            'status' => 'payee',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'available' => false,
            'date' => now(),
            'pob_category' => $request->category,
            'pob_type' => $pob_type,
            'year' => now()->year,
            'attachment' => null,
            'customer_id' => null,
            'aprooved' => true,
            'booked' => true,
            'profile' => null,
            'homeAddress' => null,
            'homePhone' => null,
            'homeEmail' => null,
            'homeVisible' => null,
            'homeLocation' => null,
            'officeAddress' => null,
            'officePhone' => null,
            'officeLocation' => null,
            'officeEmail' => null,
            'officeVisible' => null,
        ]);

        PobPay::create([
            'box_id' => $id,
            'amount' => $box->amount,
            'year' => now()->year,
            'payment_type' => 'rent',
            'payment_model' => '',
            'payment_ref' => '',
            'bid' => auth()->user()->branch,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Pob Sold Successfully');
    }
    // invoice
    public function invoice($id)
    {
        $box = PobPay::find($id);
        $pdf = Pdf::loadView('admin.physicalPob.invoice', compact('box'))
            ->setPaper('a7', 'portrait');
        return $pdf->stream('invoice.pdf');
    }
    public function dailyIncome()
    {
        $from = request('from') ?? null;
        $to = request('to') ?? null;

        $courierPays = PobPay::where('bid', auth()->user()->branch)
            ->where('serviceType', 'PBox')->when($from && $to, function ($query) use ($from, $to) {
            $query->where('pdate', '>=', $from)->where('pdate', '<=', $to);
        })->orderBy('pdate', 'DESC')->limit(value: 1000)->get();
        // $courierPays = DB::table('pob_pays')
        //     ->select(DB::raw('SUM(amount) as cash'), 'pdate')
        //     ->where('bid', auth()->user()->branch)
        //     ->where('serviceType', 'PBox')
        //     ->when($from && $to, function ($query) use ($from, $to) {
        //         $query->where('pdate', '>=', $from)->where('pdate', '<=', $to);
        //     })
        //     ->groupBy('pdate')
        //     ->orderBy('pdate', 'DESC')
        //     ->limit(1000)
        //     ->get();

        return view('admin.physicalPob.dailyIncome', compact('courierPays', 'from', 'to'));
    }

    public function monthlyIncome()
    {
        $boxes = PobPay::where('serviceType', 'PBox')->where('branch_id', auth()->user()->branch)
            ->select(DB::raw('SUM(amount) as cash'), DB::raw('MONTH(created_at) as created_month'), DB::raw('YEAR(created_at) as created_year'))
            ->groupBy('created_month', 'created_year')->orderBy('created_year', 'DESC')->orderBy('created_month')->limit(20)->get();
        return view('admin.physicalPob.monthlyIncome', compact('boxes'));
    }
    // preformaStore
    public function preformaStore($id)
    {
        $box = Box::find($id);
        $paidYear = $box->year + 1;
        $currentYear = now()->year;
        $yearsNotpaid = [];
        for ($i = $paidYear; $i <= $currentYear; $i++) {
            $yearsNotpaid[] = $i;
        }

        PreFormaBill::create([
            'bill_number' => str_pad(PreFormaBill::count() + 1, 4, '0', STR_PAD_LEFT) . '/AGK/' . now()->year,
            'non_pay_years' => implode(',', $yearsNotpaid),
            'rental_amount' => $box->amount,
            'total_amount' => ($box->amount + $box->amount * 0.25) * count($yearsNotpaid),
            'box' => $box->id,
        ]);
        return redirect()->back()->with('success', 'Preforma Created Successfully');
    }
    // preforma
    public function preforma($id)
    {

        $item = PreFormaBill::where('box', $id)->latest()->first();

        $pdf = Pdf::loadView('admin.physicalpob.preforma', compact('item'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('invoice.pdf');
    }
    public function preformNotify(Request $request, $id)
    {
        $box = Box::findOrFail($id);
        $hashids = new \Hashids\Hashids(env('HASHIDS_SALT'), 8); // minimum length of 8 characters
        $encode = $hashids->encode($id);

        $message = "Dear " . $box->name;
        $message .= "by clicking on the following link " . route('preforma', $encode) . " you can download your P.O.Box " . $box->pob . " Preform Reciept";
        $message .= "Thank you";

        (new NotificationController)->send_sms($request->mobile_number, $message);
        return back()->with('message', 'Preform Reciept sent successfully');

    }
    // preforma
    public function certificate($id)
    {
        $box = Box::findorfail($id);

        $pdf = Pdf::loadView('admin.physicalpob.certificate', compact('box'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('certificate.pdf');
    }
    // pobCategory
    public function pobCategory()
    {
        $currentYear = now()->year;
        $boxes = Box::where('serviceType', 'PBox')->where('branch_id',auth()->user()->branch)->select(
            'pob_category',
            DB::raw('count(*) as total'),
            DB::raw("count(CASE WHEN year >= {$currentYear} THEN 1 ELSE NULL END) as totalrenew"),
            DB::raw("count(CASE WHEN year < {$currentYear} THEN 1 ELSE NULL END) as totalavailable")
        )->groupBy('pob_category')->get();
        return view('admin.physicalPob.pobCategory', compact('boxes'));
    }
    public function transactionpbox($pdate)
    {
        $inboxings = PobPay::where('pdate', decrypt($pdate))
            ->where('serviceType', 'PBox')
            ->where('bid', auth()->user()->branch)
            ->get();

        $pdf = Pdf::loadView('admin.backoffice.transactionphyisical', compact('pdate', 'inboxings'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('phyisicalpoboxtransaction.pdf');
    }
}
