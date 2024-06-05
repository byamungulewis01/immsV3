<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Expense_types;
use App\Models\Income_types;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $branches = Branch::orderBy('name', 'asc')->get();
        $items = Item::where('category', '!=', '3')->get();
        $incometypes = Income_types::all();
        return view('admin.reporting.index', compact('branches', 'items', 'incometypes'));
    }
    public function daily()
    {
        $collection = DB::table('daily_transactions')
            ->select(DB::raw('SUM(total_amount) as total_amount'), 'pdate')
            ->groupBy('pdate')->orderByDesc('pdate')->get();

        return view('admin.reporting.daily', compact('collection'));
    }
    public function daily_details()
    {
        $date = request('date');

        $inboxing = DB::table('branches')
            ->leftJoin('courierpays', function ($join) use ($date) {
                $join->on('branches.id', '=', 'courierpays.bid')
                    ->whereDate('courierpays.pdate', $date);
            })
            ->select(
                'branches.name as branch',
                DB::raw("
                CASE
                    WHEN courierpays.extra = 'r' THEN 'Inboxing - Registered'
                    WHEN courierpays.extra = 'o' THEN 'Inboxing - Ordinary'
                    WHEN courierpays.extra = 'p' THEN 'Inboxing - Parcel'
                    ELSE 'Inboxing - EMS'
                END as name"),
                DB::raw('COALESCE(SUM(courierpays.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name', 'name');

        $outboxing = DB::table('branches')
            ->leftJoin('outboxing_mails', function ($join) use ($date) {
                $join->on('branches.id', '=', 'outboxing_mails.branch_id')
                    ->whereDate('outboxing_mails.created_at', $date);
            })
            ->select(
                'branches.name as branch',
                DB::raw("
                CASE
                    WHEN type = 'r' THEN 'Outboxing - Registered'
                    WHEN type = 'p' THEN 'Outboxing - Parcel'
                    ELSE 'Outboxing - EMS'
                END as name"),
                DB::raw('COALESCE(SUM(outboxing_mails.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name', 'name');

        $outboxing_products = DB::table('branches')
            ->leftJoin('outboxing_mail_products', function ($join) use ($date) {
                $join->on('branches.id', '=', 'outboxing_mail_products.branch_id')
                    ->whereDate('outboxing_mail_products.created_at', $date);
            })->join('items', 'outboxing_mail_products.item_id', '=', 'items.item_id')
            ->select(
                'branches.name as branch', 'items.name',
                DB::raw('COALESCE(SUM(outboxing_mail_products.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name', 'name');

        $pob_pays = DB::table('branches')
            ->leftJoin('pob_pays', function ($join) use ($date) {
                $join->on('branches.id', '=', 'pob_pays.bid')
                    ->whereDate('pob_pays.created_at', $date);
            })->select(
            'branches.name as branch', DB::raw("
                CASE
                    WHEN payment_type = 'rent' THEN 'POBOX - RENT'
                    WHEN payment_type = 'cert' THEN 'POBOX - CERTIFICATE'
                    WHEN payment_type = 'key' THEN 'POBOX - KEY'
                    WHEN payment_type = 'cotion' THEN 'POBOX - COTION'
                    ELSE 'POBOX - INGUFURI'
                END as name"),
            DB::raw('COALESCE(SUM(pob_pays.amount), 0) as total_amount')
        )
            ->groupBy('branches.id', 'branches.name', 'name');

        $incomes = DB::table('branches')
            ->leftJoin('income', function ($join) use ($date) {
                $join->on('branches.id', '=', 'income.branch_id')
                    ->whereDate('income.created_at', $date);
            })->select(
            'branches.name as branch', 'income.name',
            DB::raw('COALESCE(SUM(income.e_amount), 0) as total_amount')
        )
            ->groupBy('branches.id', 'branches.name', 'name');

        $home_deliveries = DB::table('branches')
            ->leftJoin('home_deliveries', function ($join) use ($date) {
                $join->on('branches.id', '=', 'home_deliveries.branch_id')
                    ->whereDate('home_deliveries.created_at', $date);
            })->select(
            'branches.name as branch', 'home_deliveries.name',
            DB::raw('COALESCE(SUM(home_deliveries.amount), 0) as total_amount')
        )->groupBy('branches.id', 'branches.name', 'name');

        $results = $inboxing->unionAll($outboxing)
            ->unionAll($outboxing_products)->unionAll($pob_pays)
            ->unionAll($incomes)->unionAll($home_deliveries)
            ->get();

        // return response()->json($results);

        return view('admin.reporting.daily_detailed', compact('results'));
    }
    public function monthly()
    {
        $collection = DB::table('monthly_transactions')
            ->select(DB::raw('SUM(total_amount) as total_amount'), 'month', 'pdate')
            ->groupBy('month')->orderByDesc('pdate')->get();

        return view('admin.reporting.monthly', compact('collection'));
    }
    public function monthly_details()
    {
        $date = request('date');

        $inboxing = DB::table('branches')
            ->leftJoin('courierpays', function ($join) use ($date) {
                $join->on('branches.id', '=', 'courierpays.bid')
                    ->whereMonth('courierpays.pdate', $date);
            })
            ->select(
                'branches.name as branch',
                DB::raw("
                CASE
                    WHEN courierpays.extra = 'r' THEN 'Inboxing - Registered'
                    WHEN courierpays.extra = 'o' THEN 'Inboxing - Ordinary'
                    WHEN courierpays.extra = 'p' THEN 'Inboxing - Parcel'
                    ELSE 'Inboxing - EMS'
                END as name"),
                DB::raw('COALESCE(SUM(courierpays.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name', 'name');

        $outboxing = DB::table('branches')
            ->leftJoin('outboxing_mails', function ($join) use ($date) {
                $join->on('branches.id', '=', 'outboxing_mails.branch_id')
                    ->whereMonth('outboxing_mails.created_at', $date);
            })
            ->select(
                'branches.name as branch',
                DB::raw("
                CASE
                    WHEN type = 'r' THEN 'Outboxing - Registered'
                    WHEN type = 'p' THEN 'Outboxing - Parcel'
                    ELSE 'Outboxing - EMS'
                END as name"),
                DB::raw('COALESCE(SUM(outboxing_mails.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name', 'name');

        $outboxing_products = DB::table('branches')
            ->leftJoin('outboxing_mail_products', function ($join) use ($date) {
                $join->on('branches.id', '=', 'outboxing_mail_products.branch_id')
                    ->whereMonth('outboxing_mail_products.created_at', $date);
            })->join('items', 'outboxing_mail_products.item_id', '=', 'items.item_id')
            ->select(
                'branches.name as branch', 'items.name',
                DB::raw('COALESCE(SUM(outboxing_mail_products.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name', 'name');

        $pob_pays = DB::table('branches')
            ->leftJoin('pob_pays', function ($join) use ($date) {
                $join->on('branches.id', '=', 'pob_pays.bid')
                    ->whereMonth('pob_pays.created_at', $date);
            })->select(
            'branches.name as branch', DB::raw("
                CASE
                    WHEN payment_type = 'rent' THEN 'POBOX - RENT'
                    WHEN payment_type = 'cert' THEN 'POBOX - CERTIFICATE'
                    WHEN payment_type = 'key' THEN 'POBOX - KEY'
                    WHEN payment_type = 'cotion' THEN 'POBOX - COTION'
                    ELSE 'POBOX - INGUFURI'
                END as name"),
            DB::raw('COALESCE(SUM(pob_pays.amount), 0) as total_amount')
        )
            ->groupBy('branches.id', 'branches.name', 'name');

        $incomes = DB::table('branches')
            ->leftJoin('income', function ($join) use ($date) {
                $join->on('branches.id', '=', 'income.branch_id')
                    ->whereMonth('income.created_at', $date);
            })->select(
            'branches.name as branch', 'income.name',
            DB::raw('COALESCE(SUM(income.e_amount), 0) as total_amount')
        )
            ->groupBy('branches.id', 'branches.name', 'name');

        $home_deliveries = DB::table('branches')
            ->leftJoin('home_deliveries', function ($join) use ($date) {
                $join->on('branches.id', '=', 'home_deliveries.branch_id')
                    ->whereMonth('home_deliveries.created_at', $date);
            })->select(
            'branches.name as branch', 'home_deliveries.name',
            DB::raw('COALESCE(SUM(home_deliveries.amount), 0) as total_amount')
        )->groupBy('branches.id', 'branches.name', 'name');

        $results = $inboxing->unionAll($outboxing)
            ->unionAll($outboxing_products)->unionAll($pob_pays)
            ->unionAll($incomes)->unionAll($home_deliveries)
            ->get();

        // return response()->json($results);

        return view('admin.reporting.daily_detailed', compact('results'));
    }
    public function profit()
    {
        //
        $branches = Branch::orderBy('name', 'asc')->get();
        $items = Item::all();
        $incometypes = Income_types::all();
        return view('admin.reporting.profit', compact('branches', 'items', 'incometypes'));
    }

    public function expenses()
    {
        //
        $branches = Branch::orderBy('name', 'asc')->get();
        // $items = Item::all();
        $expensetypes = Expense_types::all();
        return view('admin.reporting.expenses', compact('branches', 'expensetypes'));
    }

    public function ems()
    {
        return view('admin.reporting.ems');
    }
    public function inboxing_ems()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'EMS';

        $collection = DB::table('branches')
            ->leftJoin('courierpays', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'courierpays.bid')
                    ->where('courierpays.extra', '=', 'ems')
                    ->whereBetween('courierpays.pdate', [$startDate, $endDate]);
            })
            ->leftJoin('inboxings', 'courierpays.cid', '=', 'inboxings.id')
            ->select(
                'branches.name as branch',
                DB::raw('COALESCE(SUM(inboxings.weight), 0) as total_weight'),
                DB::raw('COALESCE(SUM(courierpays.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.inboxing', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function inboxing_ordinary()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'Ordinary';

        $collection = DB::table('branches')
            ->leftJoin('courierpays', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'courierpays.bid')
                    ->where('courierpays.extra', '=', 'o')
                    ->whereBetween('courierpays.pdate', [$startDate, $endDate]);
            })
            ->leftJoin('inboxings', 'courierpays.cid', '=', 'inboxings.id')
            ->select(
                'branches.name as branch',
                DB::raw('COALESCE(SUM(inboxings.weight), 0) as total_weight'),
                DB::raw('COALESCE(SUM(courierpays.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.inboxing', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function inboxing_registered()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'Registered';

        $collection = DB::table('branches')
            ->leftJoin('courierpays', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'courierpays.bid')
                    ->where('courierpays.extra', '=', 'r')
                    ->whereBetween('courierpays.pdate', [$startDate, $endDate]);
            })
            ->leftJoin('inboxings', 'courierpays.cid', '=', 'inboxings.id')
            ->select(
                'branches.name as branch',
                DB::raw('COALESCE(SUM(inboxings.weight), 0) as total_weight'),
                DB::raw('COALESCE(SUM(courierpays.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.inboxing', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function inboxing_percel()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'Parcel';

        $collection = DB::table('branches')
            ->leftJoin('courierpays', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'courierpays.bid')
                    ->where('courierpays.extra', '=', 'p')
                    ->whereBetween('courierpays.pdate', [$startDate, $endDate]);
            })
            ->leftJoin('inboxings', 'courierpays.cid', '=', 'inboxings.id')
            ->select(
                'branches.name as branch',
                DB::raw('COALESCE(SUM(inboxings.weight), 0) as total_weight'),
                DB::raw('COALESCE(SUM(courierpays.amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.inboxing', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function outboxing_ems()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'EMS';

        $collection = DB::table('branches')
            ->leftJoin('outboxing_mails', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'outboxing_mails.branch_id')
                    ->where('outboxing_mails.type', '=', 'ems')
                    ->whereBetween('outboxing_mails.created_at', [$startDate, $endDate]);
            })
            ->select(
                'branches.name as branch',
                DB::raw('COALESCE(SUM(outboxing_mails.weight), 0) as total_weight'),
                DB::raw('COALESCE(SUM(outboxing_mails.amount), 0) as total_amount'),
                DB::raw('COALESCE(SUM(outboxing_mails.postage), 0) as total_postage'),
                DB::raw('COALESCE(SUM(outboxing_mails.amount + outboxing_mails.postage), 0) as total'),
            )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.outboxing', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function outboxing_registered()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'Registered';

        $collection = DB::table('branches')
            ->leftJoin('outboxing_mails', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'outboxing_mails.branch_id')
                    ->where('outboxing_mails.type', '=', 'r')
                    ->whereBetween(DB::raw('DATE(outboxing_mails.created_at)'), [$startDate, $endDate]);
            })
            ->select(
                'branches.name as branch',
                DB::raw('COALESCE(SUM(outboxing_mails.weight), 0) as total_weight'),
                DB::raw('COALESCE(SUM(outboxing_mails.amount), 0) as total_amount'),
                DB::raw('COALESCE(SUM(outboxing_mails.postage), 0) as total_postage'),
                DB::raw('COALESCE(SUM(outboxing_mails.amount + outboxing_mails.postage), 0) as total'),
            )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.outboxing', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function outboxing_percel()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'Parcel';

        $collection = DB::table('branches')
            ->leftJoin('outboxing_mails', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'outboxing_mails.branch_id')
                    ->where('outboxing_mails.type', '=', 'p')
                    ->whereBetween('outboxing_mails.created_at', [$startDate, $endDate]);
            })
            ->select(
                'branches.name as branch',
                DB::raw('COALESCE(SUM(outboxing_mails.weight), 0) as total_weight'),
                DB::raw('COALESCE(SUM(outboxing_mails.amount), 0) as total_amount'),
                DB::raw('COALESCE(SUM(outboxing_mails.postage), 0) as total_postage'),
                DB::raw('COALESCE(SUM(outboxing_mails.amount + outboxing_mails.postage), 0) as total'),
            )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.outboxing', compact('collection', 'label', 'startDate', 'endDate'));
    }

    public function outboxing_stamps()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'P';

        $courierPays = DB::table('pob_pays')
            ->select(DB::raw('SUM(amount) as cash'), 'pdate')
            ->where('bid', auth()->user()->branch)
            ->where('serviceType', 'PBox')
            ->groupBy('pdate')
            ->orderBy('pdate', 'DESC')
            ->limit(1000)
            ->get();

        $collection = DB::table('branches')
            ->leftJoin('outboxing_mails', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'outboxing_mails.branch_id')
                    ->where('outboxing_mails.type', '=', 'stamps')
                    ->whereBetween('outboxing_mails.created_at', [$startDate, $endDate]);
            })
            ->select(
                'branches.name as branch',
                DB::raw('COALESCE(SUM(outboxing_mails.weight), 0) as total_weight'),
                DB::raw('COALESCE(SUM(outboxing_mails.postage), 0) as total_postage'),
            )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.outboxing-stamps', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function physical_pobox()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'PHYSICAL P.O.BOX';

        $collection = DB::table('branches')
            ->leftJoin('pob_pays', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'pob_pays.bid')
                    ->where('pob_pays.serviceType', '=', 'PBox')
                    ->whereBetween('pob_pays.pdate', [$startDate, $endDate]);
            })->select(
            'branches.name as branch',
            DB::raw('COALESCE(SUM(pob_pays.amount), 0) as total_amount'),
        )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.pobox', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function virtual_pobox()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $label = 'VIRTUAL P.O.BOX';

        $collection = DB::table('branches')
            ->leftJoin('pob_pays', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'pob_pays.bid')
                    ->where('pob_pays.serviceType', '=', 'PBox')
                    ->whereBetween('pob_pays.pdate', [$startDate, $endDate]);
            })->select(
            'branches.name as branch',
            DB::raw('COALESCE(SUM(pob_pays.amount), 0) as total_amount'),
        )
            ->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.pobox', compact('collection', 'label', 'startDate', 'endDate'));
    }
    public function other_revenue()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $collection = DB::table('branches')
            ->leftJoin('income', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'income.branch_id')
                    ->whereBetween('income.pdate', [$startDate, $endDate]);
            })->select(
            'branches.name as branch',
            DB::raw('COALESCE(SUM(income.e_amount), 0) as total_amount'),
        )->groupBy('branches.id', 'branches.name')->get();

        return view('admin.reporting.other_revenue', compact('collection', 'startDate', 'endDate'));
    }
    public function home_delivery()
    {
        $startDate = request('from'); // Replace with your start date
        $endDate = request('to'); // Replace with your end date

        $collection = DB::table('branches')
            ->leftJoin('home_deliveries', function ($join) use ($startDate, $endDate) {
                $join->on('branches.id', '=', 'home_deliveries.branch_id')
                    ->whereBetween('home_deliveries.pdate', [$startDate, $endDate]);
            })->select(
            'branches.name as branch',
            DB::raw('COALESCE(SUM(home_deliveries.amount), 0) as total_amount'),
        )->groupBy('branches.id', 'branches.name')
            ->get();

        return view('admin.reporting.home_delivery', compact('collection', 'startDate', 'endDate'));
    }
    public function registered()
    {
        return view('admin.reporting.registered');
    }
    public function percel()
    {
        return view('admin.reporting.percel');
    }
    public function temble()
    {
        return view('admin.reporting.temble');
    }
    public function postel()
    {
        return view('admin.reporting.postel');
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

    public function daily_expense()
    {
        $collection = DB::table('expenses')->where('e_status', 1)
            ->select(DB::raw('SUM(e_amount) as total_amount'), DB::raw('DATE(created_at) as date'))
            ->groupBy('date')->orderByDesc('date')->get();
        return view('admin.reporting.daily-expenses', compact('collection'));
    }
    public function daily_expense_details()
    {
        $date = request('date');

        $results = DB::table('branches')
            ->leftJoin('expenses', function ($join) use ($date) {
                $join->on('branches.id', '=', 'expenses.branch_id')
                    ->where('expenses.e_status', 1)
                    ->whereDate('expenses.created_at', $date);
            })
            ->select(
                'branches.name as branch',
                'expenses.e_name as name',
                DB::raw('COALESCE(SUM(expenses.e_amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name', 'name')->get();

        return view('admin.reporting.expenses_daily_detailed', compact('results'));
    }

    public function monthly_expense()
    {
        $collection = DB::table('expenses')->where('e_status',1)
        ->select(DB::raw('SUM(e_amount) as total_amount'),DB::raw('MONTH(created_at) as month'),'created_at')
        ->groupBy('month')->orderByDesc('month')->get();
        return view('admin.reporting.monthly-expenses', compact('collection'));
    }
    public function monthly_expense_details()
    {
        $date = request('date');

        $results = DB::table('branches')
            ->leftJoin('expenses', function ($join) use ($date) {
                $join->on('branches.id', '=', 'expenses.branch_id')
                    ->where('expenses.e_status', 1)
                    ->whereMonth('expenses.created_at', $date);
            })
            ->select(
                'branches.name as branch',
                'expenses.e_name as name',
                DB::raw('COALESCE(SUM(expenses.e_amount), 0) as total_amount')
            )
            ->groupBy('branches.id', 'branches.name', 'name')->get();

        return view('admin.reporting.expenses_daily_detailed', compact('results'));
    }


}
