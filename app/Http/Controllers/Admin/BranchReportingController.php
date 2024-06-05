<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Expense_types;
use App\Models\Income_types;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $branches = Branch::where('id', auth()->user()->branch)->orderBy('name', 'asc')->get();
        $items = Item::where('category', '!=', '3')->get();
        $incometypes = Income_types::all();
        return view('admin.branchreporting.index', compact('branches', 'items', 'incometypes'));
    }
    public function daily()
    {

        $collection = DB::table('daily_transactions')->where('branch',auth()->user()->branch)
        ->select(DB::raw('SUM(total_amount) as total_amount'),'pdate')
        ->groupBy('pdate')->orderByDesc('pdate')->get();
        return view('admin.branchreporting.daily', compact('collection'));
    }
    public function daily_details()
    {
        $date = request('date');
        $inboxing = DB::table('courierpays')->where('bid',auth()->user()->branch)->whereDate('pdate', $date)
        ->select(DB::raw("
        CASE
            WHEN extra = 'r' THEN 'Inboxing - Registered'
            WHEN extra = 'o' THEN 'Inboxing - Ordinary'
            WHEN extra = 'p' THEN 'Inboxing - Parcel'
            ELSE 'Inboxing - EMS'
        END as name"),
        DB::raw('SUM(amount) as total_amount'),)->groupBy('name');


        $outboxing = DB::table('outboxing_mails')->whereNot('type','stamps')
        ->where('branch_id',auth()->user()->branch)->select(DB::raw("
        CASE
            WHEN type = 'r' THEN 'Outboxing - Registered'
            WHEN type = 'p' THEN 'Outboxing - Parcel'
            ELSE 'Outboxing - EMS'
        END as name"),
        DB::raw('SUM(amount) as total_amount'),)
        ->whereDate('created_at', $date)
        ->groupBy('name');


        $outboxing_products =  DB::table('outboxing_mail_products')
        ->join('items', 'outboxing_mail_products.item_id', '=', 'items.item_id')
        ->select('items.name', DB::raw('SUM(outboxing_mail_products.amount) as total_amount'))
        ->where('outboxing_mail_products.branch_id', auth()->user()->branch)
        ->whereDate('outboxing_mail_products.created_at', $date)
        ->groupBy('items.name');



        $pob_pays = DB::table('pob_pays')
        ->select(DB::raw("
        CASE
            WHEN payment_type = 'rent' THEN 'POBOX - RENT'
            WHEN payment_type = 'cert' THEN 'POBOX - CERTIFICATE'
            WHEN payment_type = 'key' THEN 'POBOX - KEY'
            WHEN payment_type = 'cotion' THEN 'POBOX - COTION'
            ELSE 'POBOX - INGUFURI'
        END as name"), DB::raw('SUM(amount) as total_amount'),)
        ->where('bid',auth()->user()->branch)->whereDate('created_at', $date)
        ->groupBy('name');



        $incomes = DB::table('income')
        ->where('branch_id',auth()->user()->branch)->whereDate('pdate', $date)
        ->select('name', DB::raw('SUM(e_amount) as total_amount'))
        ->groupBy('name');

        $home_deliveries = DB::table('home_deliveries')
        ->select('name', DB::raw('SUM(amount) as total_amount'),)
        ->where('branch_id',auth()->user()->branch)->whereDate('pdate', $date)
        ->groupBy('name');

        $collection = $inboxing->unionAll($outboxing)
        ->unionAll($outboxing_products)
        ->unionAll($pob_pays)
        ->unionAll($incomes)
        ->unionAll($home_deliveries)
        ->get();

        return view('admin.branchreporting.daily-details', compact('collection'));
    }

    public function monthly()
    {
        $collection = DB::table('monthly_transactions')->where('branch',auth()->user()->branch)
        ->select(DB::raw('SUM(total_amount) as total_amount'),'month','pdate')
        ->groupBy('month')->orderByDesc('pdate')->get();

        return view('admin.branchreporting.monthly', compact('collection'));
    }
    public function monthly_details()
    {
        $date = request('date');

        $inboxing = DB::table('courierpays')->where('bid',auth()->user()->branch)
        ->select(DB::raw("
        CASE
            WHEN extra = 'r' THEN 'Inboxing - Registered'
            WHEN extra = 'o' THEN 'Inboxing - Ordinary'
            WHEN extra = 'p' THEN 'Inboxing - Parcel'
            ELSE 'Inboxing EMS'
        END as name"),
        DB::raw('SUM(amount) as total_amount'),)
        ->whereMonth('pdate', $date)
        ->groupBy('name');

        $outboxing = DB::table('outboxing_mails')->whereNot('type','stamps')
        ->where('branch_id',auth()->user()->branch)->select(DB::raw("
        CASE
            WHEN type = 'r' THEN 'Outboxing - Registered'
            WHEN type = 'p' THEN 'Outboxing - Parcel'
            ELSE 'Outboxing - EMS'
        END as name"),
        DB::raw('SUM(amount) as total_amount'),)
        ->whereMonth('created_at', $date)
        ->groupBy('name');

        $outboxing_products =  DB::table('outboxing_mail_products')
        ->join('items', 'outboxing_mail_products.item_id', '=', 'items.item_id')
        ->select('items.name', DB::raw('SUM(outboxing_mail_products.amount) as total_amount'))
        ->where('outboxing_mail_products.branch_id', auth()->user()->branch)
        ->whereMonth('outboxing_mail_products.created_at', $date)
        ->groupBy('items.name');


        $pob_pays = DB::table('pob_pays')
        ->select(DB::raw("
        CASE
            WHEN payment_type = 'rent' THEN 'POBOX - RENT'
            WHEN payment_type = 'cert' THEN 'POBOX - CERTIFICATE'
            WHEN payment_type = 'key' THEN 'POBOX - KEY'
            WHEN payment_type = 'cotion' THEN 'POBOX - COTION'
            ELSE 'POBOX - INGUFURI'
        END as name"), DB::raw('SUM(amount) as total_amount'),)
        ->where('bid',auth()->user()->branch)->whereMonth('created_at', $date)
        ->groupBy('name');

        $incomes = DB::table('income')
        ->select('name', DB::raw('SUM(e_amount) as total_amount'),)
        ->where('branch_id',auth()->user()->branch)->whereMonth('pdate', $date)
        ->groupBy('name');

        $home_deliveries = DB::table('home_deliveries')
        ->select('name', DB::raw('SUM(amount) as total_amount'),)
        ->where('branch_id',auth()->user()->branch)->whereMonth('pdate', $date)
        ->groupBy('name');

        $collection = $inboxing->unionAll($outboxing)
        ->unionAll($outboxing_products)
        ->unionAll($pob_pays)
        ->unionAll($incomes)
        ->unionAll($home_deliveries)
        ->get();

        return view('admin.branchreporting.monthly-details', compact('collection'));
    }
    public function profit()
    {
        //
        $branches = Branch::where('id', auth()->user()->branch)->orderBy('name', 'asc')->get();
        $items = Item::all();
        $incometypes = Income_types::all();
        return view('admin.branchreporting.profit', compact('branches', 'items', 'incometypes'));
    }

    public function expenses()
    {
        //
        $branches = Branch::where('id', auth()->user()->branch)->orderBy('name', 'asc')->get();
        // $items = Item::all();
        $expensetypes = Expense_types::all();
        return view('admin.branchreporting.expenses', compact('branches', 'expensetypes'));
    }
    public function daily_expenses()
    {
        $collection = DB::table('expenses')->where('branch_id',auth()->user()->branch)
        ->where('e_status',1)
        ->select(DB::raw('SUM(e_amount) as total_amount'),DB::raw('DATE(created_at) as date'))
        ->groupBy('date')->orderByDesc('date')->get();
        return view('admin.branchreporting.daily-expenses', compact('collection'));
    }
    public function daily_expenses_details()
    {
        $date = request('date');

        $collection = DB::table('expenses')->whereDate('created_at',$date)
        ->where('e_status',1)->where('branch_id',auth()->user()->branch)
        ->orderByDesc('created_at')->get();
        return view('admin.branchreporting.expenses-daily-details', compact('collection'));
    }
    public function monthly_expenses()
    {
        $collection = DB::table('expenses')->where('branch_id',auth()->user()->branch)
        ->where('e_status',1)
        ->select(DB::raw('SUM(e_amount) as total_amount'),DB::raw('MONTH(created_at) as month'),'created_at')
        ->groupBy('month')->orderByDesc('month')->get();

        return view('admin.branchreporting.monthly-expenses', compact('collection'));
    }
    public function monthly_expenses_details()
    {
        $date = request('date');

        $collection = DB::table('expenses')->whereMonth('created_at',$date)
        ->where('e_status',1)->where('branch_id',auth()->user()->branch)
        ->orderByDesc('created_at')->get();
        return view('admin.branchreporting.expenses-daily-details', compact('collection'));
    }


    public function ems()
    {
        return view('admin.branchreporting.ems');
    }
    public function registered()
    {
        return view('admin.branchreporting.registered');
    }
    public function percel()
    {
        return view('admin.branchreporting.percel');
    }
    public function temble()
    {
        return view('admin.branchreporting.temble');
    }
    public function postel()
    {
        return view('admin.branchreporting.postel');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
