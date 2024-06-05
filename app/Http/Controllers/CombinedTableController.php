<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CombinedTableController extends Controller
{
    public function index(){
     return view('combined-table');
    }
    public function index1($rvdate)
    {
        $dataFromTable1 = DB::table('outboxing')
        ->join('transferdetailsouts', 'outboxing.out_id', '=', 'transferdetailsouts.out_id')
        ->join('transferouts', 'transferouts.id', '=', 'transferdetailsouts.trid')
        ->join('branches', 'outboxing.blanch', '=', 'branches.id') // Changed the table alias here
        ->select('transferouts.*', 'transferdetailsouts.*', 'outboxing.*', 'branches.*') // Make sure to update the column references accordingly
        ->where('mailtype', 'ems')
        ->where('outboxing.recdate', decrypt($rvdate))
        ->whereNotNull('outboxing.recdate')
        ->get();

        $dataFromTable2 = DB::table('registoutboxing')
        ->join('transferdetailsouts','registoutboxing.out_id', '=', 'transferdetailsouts.out_id')
        ->join('transferouts', 'transferouts.id', '=', 'transferdetailsouts.trid')
        ->join('branches', 'registoutboxing.blanch', '=', 'branches.id') // Changed the table alias here
        ->select('transferouts.*','transferdetailsouts.*','registoutboxing.*','branches.*')
        ->whereNotNull('registoutboxing.recdate')
        ->where('registoutboxing.recdate', decrypt($rvdate))
        ->where('mailtype','p')

        ->get();
        $dataFromTable3 = DB::table('poutboxing')
        ->join('transferdetailsouts', 'poutboxing.out_id', '=', 'transferdetailsouts.out_id')
        ->join('transferouts', 'transferouts.id', '=', 'transferdetailsouts.trid')
        ->join('branches', 'poutboxing.blanch', '=', 'branches.id') // Changed the table alias here
        ->select('transferouts.*','transferdetailsouts.*','poutboxing.*','branches.*')
        ->whereNotNull('poutboxing.recdate')
        ->where('mailtype','r')
        ->where('poutboxing.recdate', decrypt($rvdate))
        ->get();
        $dataFromTable4 = DB::table('tembleoutboxing')
        ->join('transferdetailsouts', 'tembleoutboxing.out_id', '=', 'transferdetailsouts.out_id')
        ->join('transferouts', 'transferouts.id', '=', 'transferdetailsouts.trid')
        ->join('branches', 'tembleoutboxing.blanch', '=', 'branches.id') // Changed the table alias here
        ->select('transferouts.*','transferdetailsouts.*','tembleoutboxing.*','branches.*')
        ->whereNotNull('tembleoutboxing.recdate')
        ->where('tembleoutboxing.recdate', decrypt($rvdate))
        ->where('mailtype','t')
        ->get();

        // Combine the data into one array
        $combinedData = array_merge($dataFromTable1->toArray(), $dataFromTable2->toArray(), $dataFromTable3->toArray(),$dataFromTable4->toArray());
        $pdf = \PDF::loadView('combinedreport', ['data' => $combinedData])
        ->setPaper('a3', 'portrait');

        return $pdf->stream('packinglist.pdf');
    }
}
