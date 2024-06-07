<?php

namespace App\Http\Controllers\Eric\Backoffice;

use App\Models\InboxingReport;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\Courierpay;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MailDeliveryController extends Controller
{
    public function index()
    {
        $pays = Courierpay::orderByDesc('id')->limit(1000)->get();
        // dd($pays);
        return view('admin.backoffice.maildelevery', compact('pays'));
    }
    public function reports()
    {
        $emsReports = InboxingReport::where('branch', auth()->user()->branch)->where('mailtype', 'ems')->orderByDesc('id')->get();
        $percelReports = InboxingReport::where('branch', auth()->user()->branch)->where('mailtype', 'p')->orderByDesc('id')->get();
        $ordinaryReports = InboxingReport::where('branch', auth()->user()->branch)->where('mailtype', 'o')->orderByDesc('id')->get();
        $registeredReports = InboxingReport::where('branch', auth()->user()->branch)->where('mailtype', 'r')->orderByDesc('id')->get();
        $googleReports = InboxingReport::where('branch', auth()->user()->branch)->where('mailtype', 'GAD')->orderByDesc('id')->get();

        return view('admin.backoffice.reports', compact('emsReports', 'percelReports', 'ordinaryReports', 'registeredReports', 'googleReports'));
    }
    public function invoice($cid)
    {
        $pay = Courierpay::find($cid);
        $pdf = Pdf::loadView('admin.backoffice.pickupinvoice', compact('pay'))
            ->setPaper('a7', 'portrait');
        return $pdf->stream('invoice.pdf');
    }

    public function emsReports()
    {
        $emsReports = InboxingReport::where('branch', auth()->user()->branch)->where('mailtype', 'ems')->orderByDesc('id')->get();

        $pdf = Pdf::loadView('admin.backoffice.pdf.ems', compact('emsReports'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('emsReport.pdf');
    }


}
