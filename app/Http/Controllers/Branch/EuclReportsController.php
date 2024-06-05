<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EuclReportsController extends Controller
{

    public function daily_activities()
    {
        $collection = DB::table('transactions')->where('branch_id', auth()->user()->branch)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_amount'))
            ->orderByDesc('id')
            ->groupBy('date')
            ->get();
        return view('branch.eucl.daily.activities', compact('collection'));
    }
    public function print_daily_activities()
    {
        $date = request('date');
        $collection = DB::table('transactions')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_amount'), 'branch_id', DB::raw('(SELECT name FROM branches WHERE id = branch_id) AS branch_name'))
            ->whereDate('created_at', $date)
            ->orderByDesc('id')
            ->groupBy('branch_id')
            ->get();
        $pdf = Pdf::loadView('eucl.daily.print-pdf', compact('collection', 'date'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('emsReport.pdf');

    }
    public function daily_transactions()
    {
        $date = request('date');
        $collection = Transaction::whereDate('created_at', $date)->where('branch_id', auth()->user()->branch)
            ->orderByDesc('id')->get();
        return view('branch.eucl.daily.transactions', compact('collection'));
    }

    public function monthly_activities()
    {
        $collection = DB::table('transactions')->where('branch_id', auth()->user()->branch)
            ->select(DB::raw('MONTH(created_at) as date'), DB::raw('SUM(amount) as total_amount'),'created_at') // Assuming 'created_at' is the date field
            ->orderByDesc('id')
            ->groupBy('date')
            ->get();

        return view('branch.eucl.monthly.activities', compact('collection'));
    }

    public function monthly_transactions()
    {
        $date = request('date');
        $collection = Transaction::whereMonth('created_at', $date)->where('branch_id', auth()->user()->branch)
            ->orderByDesc('id')->get();

        return view('branch.eucl.monthly.transactions', compact('collection'));
    }
    public function monthly_all_transactions()
    {
        $date = request('date');
        $collection = Transaction::whereMonth('created_at', $date)
            ->orderByDesc('id')->get();
        return view('branch.eucl.monthly.transactions', compact('collection'));
    }
}
