<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Jobs\SendPobRentReminderSMS;
use App\Models\Box;
use App\Models\Branch;
use App\Models\PobApplication;
use App\Models\PobBackup;
use App\Models\PobNotification;
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
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|min:10',
            'year' => 'required',
            'pob_type' => 'required',
            'box_category_id' => 'required',
            'size' => 'required',
            'cotion' => 'required',
            'EMSNationalContract' => 'required',
        ]);
        $branch = Branch::findOrFail(auth()->user()->branch);
        $amount = ($request->pob_type == 'Company') ? $branch->company_fees : $branch->individual_fees;
        $request->merge(['amount' => $amount]);
        $box = Box::find($id);
        $box->update($request->all());

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
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'nullable|email',
            'phone' => 'required|numeric|digits:10',
            'pob_type' => 'required|in:Individual,Company|string',
            'box_category_id' => 'required',
        ]);

        $branch = Branch::findOrFail(auth()->user()->branch);
        $amount = ($request->pob_type == 'Company') ? $branch->company_fees : $branch->individual_fees;

        $box = Box::find($id);
        $box->update([
            'status' => 'payee',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'available' => false,
            'amount' => $amount,
            'date' => now(),
            'pob_type' => $request->pob_type,
            'box_category_id' => $request->box_category_id,
            'year' => now()->year,
            'aprooved' => true,
            'booked' => true,
        ]);

        PobPay::create([
            'box_id' => $id,
            'amount' => $amount,
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
        if (now()->month == 12) {
            $yearsNotpaid[] = $currentYear + 1;
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
        // return view('admin.physicalpob.preforma', compact('item'));
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
        $boxes = DB::table('boxes')
            ->join('box_categories', 'boxes.box_category_id', '=', 'box_categories.id')
            ->where([
                ['boxes.serviceType', '=', 'PBox'],
                ['boxes.branch_id', '=', auth()->user()->branch],
            ])
            ->select(
                'box_categories.name as pob_category',
                DB::raw('count(*) as total'),
                DB::raw("count(CASE WHEN year >= {$currentYear} THEN 1 ELSE NULL END) as total_renew"),
                DB::raw("count(CASE WHEN year < {$currentYear} THEN 1 ELSE NULL END) as total_available"),
                DB::raw("SUM(amount) as total_amount"),
                DB::raw("SUM(CASE WHEN year >= {$currentYear} THEN amount ELSE 0 END) as total_renew_amount"),
                DB::raw("SUM(CASE WHEN year < {$currentYear} THEN amount ELSE 0 END) as total_available_amount")
            )
            ->groupBy('boxes.box_category_id')
            ->get();

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
    public function notification()
    {

        $notifications = PobNotification::select(
            'rent_year',
            'created_at',
            DB::raw("SUM(CASE WHEN status = 'sent' THEN 1 ELSE 0 END) as sent_count"),
            DB::raw("SUM(CASE WHEN status = 'not-sent' THEN 1 ELSE 0 END) as not_sent_count")
        )
            ->groupBy('rent_year')->orderByDesc('rent_year')
            ->get();

        return view('admin.physicalPob.notification', compact('notifications'));
    }
    public function storeNotification(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:4',
        ]);


        $check = PobNotification::where([
            ['rent_year', $request->year],
            ['type', 'rent'],
        ])->first();
        if ($check) {
            return back()->with('warning', $request->year . ' year already notified');
        }


        $boxes = Box::where('branch_id', 3)->select('id', 'pob', 'name', 'phone');
        // $boxes = Box::where('branch_id', auth()->user()->branch)->select('id', 'pob', 'name', 'phone');
        $boxes->chunk(100, function ($boxes) use ($request) {
            foreach ($boxes as $box) {
                SendPobRentReminderSMS::dispatch($box, $request->year);
            }
        });

        return back()->with('success', 'Message sent successfully');
    }
}
