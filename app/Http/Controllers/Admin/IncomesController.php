<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Incomes;
use App\Models\Income_types;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blanch = Auth::user()->branch;
        if (auth()->user()->level == "branchManager") {
            $incomes = Incomes::where('branch_id', $blanch)->orderByDesc('created_at')->get();
        } else {
            $incomes = Incomes::orderByDesc('created_at')->get();
        }
        $income_types = Income_types::all();

        return view('admin.incomes.index',compact('incomes','income_types'));
    }
    public function history()
    {
        $income_types = Income_types::all();
        $branches = Branch::all();
        $courierPays = [];
        return view('admin.incomes.report', compact('branches', 'courierPays', 'income_types'));
    }
    public function pending()
    {
        $income_types = Income_types::all();
        $branches = Branch::all();
        return view('admin.incomes.pending', compact('branches', 'income_types'));
    }
    public function rejected()
    {
        $income_types = Income_types::all();
        $branches = Branch::all();
        return view('admin.incomes.rejected', compact('branches', 'income_types'));
    }
    public function approved()
    {
        $income_types = Income_types::all();
        $branches = Branch::all();
        return view('admin.incomes.approved', compact('branches', 'income_types'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //validate data and files

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //get current user blanch id
        $blanch = auth()->user()->branch;
        //validate data and file uploaded
        $request->validate([
            'et_id' => 'required',
            'e_amount' => 'required',

        ]);
        //validate amount as integer or double


        $f = false;
        //create new object of the model and make mapping to the data
        $incomes = new Incomes();
        $incomes->et_id = $request->et_id;
        $incomes->e_amount = $request->e_amount;
        $incomes->branch_id = $blanch;
        $incomes->user_id = auth()->id();
        if ($request->e_amount < 20000) {
            $incomes->e_status = 1;
        }else{
            $incomes->e_status = 2;
        }
        //save data
        $incomes->save();
        //redirect to index
        return redirect()->route('admin.income.index')->with('success','Income Created Successfully');
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
        //get current user blanch id
        $blanch = auth()->user()->branch;
        //validate data and file uploaded
        $request->validate([
            'et_id' => 'required',
            'e_amount' => 'required',

        ]);
        //validate amount as integer or double


        $f = false;

        // dd($f);
        //create new object of the model and make mapping to the data
        $incomes = Incomes::findorfail($id);
        $incomes->et_id = $request->et_id;
        $incomes->e_amount = $request->e_amount;
        $incomes->branch_id = $blanch;

        //save data
        $incomes->save();
        //redirect to index
        return redirect()->route('admin.income.index')->with('success','Other Service Income Updated Successfully');
    }

    public function approve(Request $request,string $id)
    {
        //validate amount
        $request->validate([
            'e_amount' => 'required',
        ]);
        $incomes = Incomes::findorfail($id);
        $incomes->e_amount = $request->e_amount;
        $incomes->e_status = 1;
        $incomes->save();
        return redirect()->route('admin.income.index')->with('success','Income Approved Successfully');
    }
    //reject without amount
    public function reject(string $id)
    {
        $incomes = Incomes::findorfail($id);
        $incomes->e_status = 3;
        $incomes->save();
        return redirect()->route('admin.income.index')->with('success','Income Rejected Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $incomes = Incomes::findorfail($id);
        $incomes->delete();
        return redirect()->route('admin.income.index')->with('success','Income Deleted Successfully');
    }
    public function report()
    {
        $courierPays = DB::table('income')
        ->select(DB::raw('SUM(e_amount) as cash'), 'pdate')
        ->where('branch_id', auth()->user()->branch)
        ->groupBy('pdate')
        ->orderBy('pdate', 'DESC')
        ->limit(1000)
        ->get();

         return view('admin.incomes.report', compact('courierPays'));

    }
    public function transactionotheri($pdate)
    {
        $inboxings = DB::table('income')
        ->join('income_types', 'income_types.et_id', '=', 'income.et_id')
        ->select('income.*','income_types.*')
        ->where('income.pdate',$pdate)
        ->where('income.branch_id',auth()->user()->branch)
        ->get();

        $pdf = Pdf::loadView('admin.incomes.otherincometransaction', compact('pdate','inboxings'))
        ->setPaper('a4', 'portrait');
        return $pdf->stream('transactionoutboxingems.pdf');
    }
    public function homereport()
    {
        $courierPays = DB::table('home_deliveries')
        ->select(DB::raw('SUM(amount) as cash'), 'pdate')
        ->groupBy('pdate')
        ->orderBy('pdate', 'DESC')
        ->limit(30)
        ->get();
        return view('customer.mails.report', compact('courierPays'));

    }
    public function transactionhomed($pdate)
    {
        $inboxings = DB::table('home_deliveries')
        ->join('customers', 'customers.id', '=', 'home_deliveries.customer')
        ->select('home_deliveries.*','customers.*')
        ->where('home_deliveries.pdate',$pdate)
        ->get();
        $pdf = Pdf::loadView('admin.incomes.otherincometransaction', compact('pdate','inboxings'))
        ->setPaper('a4', 'portrait');
        return $pdf->stream('transactionoutboxingems.pdf');
    }

}
