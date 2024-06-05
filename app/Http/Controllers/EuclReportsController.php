<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class EuclReportsController extends Controller
{
    //
    public function daily_balance()
    {
        $collection = DB::table('transactions')
            ->select(DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('(SELECT opening_balance FROM transactions WHERE DATE(created_at) = date ORDER BY id ASC LIMIT 1) as opening_balance'),
                DB::raw('(SELECT current_balance FROM transactions WHERE DATE(created_at) = date ORDER BY id DESC LIMIT 1) as current_balance'),
                'amount') // Assuming 'created_at' is the date field
            ->orderByDesc('id')
            ->groupBy('date')
            ->get();
        // dd($collection);
        return view('eucl.daily.balance', compact('collection'));
    }
    public function daily_activities()
    {
        $date = request('date');
        $collection = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as total_amount'), 'branch_id', DB::raw('(SELECT name FROM branches WHERE id = branch_id) AS branch_name'))
            ->whereDate('created_at', $date)
            ->orderByDesc('id')
            ->groupBy('branch_id')
            ->get();
        return view('eucl.daily.activities', compact('collection'));
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
    public function daily_transactions($branch)
    {
        $date = request('date');
        $collection = Transaction::whereDate('created_at', $date)->where('branch_id', $branch)
            ->orderByDesc('id')->get();
        return view('eucl.daily.transactions', compact('collection'));
    }
    public function daily_all_transactions()
    {
        $date = request('date');
        $collection = Transaction::whereDate('created_at', $date)
            ->orderByDesc('id')->get();
        return view('eucl.daily.transactions', compact('collection'));
    }
    public function monthly_activities()
    {
        $collection = DB::table('transactions')
            ->select(DB::raw('MONTH(created_at) as date'), DB::raw('SUM(amount) as total_amount'), 'created_at', DB::raw('(SELECT name FROM branches WHERE id = branch_id) AS branch_name')) // Assuming 'created_at' is the date field
            ->orderByDesc('id')
            ->groupBy('date')
            ->get();

        return view('eucl.monthly.activities', compact('collection'));
    }
    public function monthly_branches_activities()
    {
        $date = request('date');
        $collection = Transaction::selectRaw('branch_id, SUM(amount) as total_amount')
        ->whereMonth('created_at', $date)
        ->groupBy('branch_id')
        ->get();

        return view('eucl.monthly.branches', compact('collection'));
    }
    public function monthly_transactions($branch)
    {
        $date = request('date');
        $collection = Transaction::whereMonth('created_at', $date)->where('branch_id', $branch)
            ->orderByDesc('id')->get();

        return view('eucl.monthly.transactions', compact('collection'));
    }
    public function monthly_all_transactions()
    {
        $date = request('date');
        $collection = Transaction::whereMonth('created_at', $date)
            ->orderByDesc('id')->get();
        return view('eucl.monthly.transactions', compact('collection'));
    }
}
