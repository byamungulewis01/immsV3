<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Expenses;
use App\Models\Expense_types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blanch = Auth::user()->branch;
        if (auth()->user()->level == "branchManager") {
            $expenses = Expenses::where('branch_id', $blanch)->orderByDesc('created_at')->get();
        } else {
            $expenses = Expenses::orderByDesc('created_at')->get();
        }
        $expense_types = Expense_types::all();

        return view('admin.expenses.index', compact('expenses', 'expense_types'));
    }
    public function history()
    {
        $expense_types = Expense_types::all();
        return view('admin.expenses.report', compact('expense_types'));
    }
    public function pending()
    {
        $expense_types = Expense_types::all();
        $branches = Branch::all();
        return view('admin.expenses.pending', compact('branches', 'expense_types'));
    }
    public function rejected()
    {
        $blanch = Auth::user()->branch;
        if (auth()->user()->level == "branchManager") {
            $expenses = Expenses::where('branch_id', $blanch)
                ->where('e_status', 3)
                ->orderByDesc('created_at')->get();
        } else {
            $expenses = Expenses::where('e_status', 3)->orderByDesc('created_at')->get();
        }
        $expense_types = Expense_types::all();
        return view('admin.expenses.rejected', compact('expenses','expense_types'));
    }
    public function approved()
    {
        //
        $blanch = Auth::user()->branch;
        if (auth()->user()->level == "branchManager") {
            $expenses = Expenses::where('branch_id', $blanch)
                ->where('e_status', 1)
                ->orderByDesc('created_at')->get();
        } else {
            $expenses = Expenses::where('e_status', 1)->orderByDesc('created_at')->get();
        }
        $expense_types = Expense_types::all();
        return view('admin.expenses.approved', compact('expenses','expense_types'));

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
            'e_name' => "required",
            'e_description' => 'required',
            'e_amount' => 'required',
            'e_file' => 'required',
        ]);
        //validate amount as integer or double
        $request->validate([
            'e_amount' => 'integer',
        ]);

        // e_file validate to contain png,jpg and pdf only files
        $file = $request->file('e_file');
        $file_extension = $file->getClientOriginalExtension();
        //only allow png,pdf,jpg files
        $allowed_files = ['png', 'pdf', 'jpg'];
        if (!in_array($file_extension, $allowed_files)) {
            return redirect()->back()->with('error', 'File Type Not Allowed');
        }
        $file_name = time() . '.' . $file_extension;
        $path = public_path('/expenses_files');
        $file->move($path, $file_name);
        //create new object of the model and make mapping to the data
        $expenses = new Expenses();
        $expenses->et_id = $request->et_id;
        $expenses->e_name = $request->e_name;
        $expenses->e_description = $request->e_description;
        $expenses->e_amount = $request->e_amount;
        $expenses->branch_id = $blanch;
        $expenses->user_id = auth()->id();
        $expenses->e_file = $file_name;

        if ($request->e_amount > 20000) {
            $expenses->e_status = 2;
        } else {
            $expenses->e_status = 1;
        }
        //save data
        $expenses->save();
        //redirect to index
        return redirect()->route('admin.expenses.index')->with('success', 'Expense Created Successfully');
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
            'e_name' => "required",
            'e_description' => 'required',
            'e_amount' => 'required',
            'e_file' => 'nullabe',
        ]);
        //validate amount as integer or double
        $request->validate([
            'e_amount' => 'integer',
        ]);

        $f = false;
        if (request()->hasFile('e_file')) {
            // e_file validate to contain png,jpg and pdf only files
            $file = $request->file('e_file');
            $file_extension = $file->getClientOriginalExtension();
            //only allow png,pdf,jpg files
            $allowed_files = ['png', 'pdf', 'jpg'];
            if (!in_array($file_extension, $allowed_files)) {
                return redirect()->back()->with('error', 'File Type Not Allowed');
            }
            $file_name = time() . '.' . $file_extension;
            $path = public_path('/expenses_files');
            $file->move($path, $file_name);
            $f = true;
        }
        // dd($f);
        //create new object of the model and make mapping to the data
        $expenses = Expenses::findorfail($id);
        $expenses->et_id = $request->et_id;
        $expenses->e_name = $request->e_name;
        $expenses->e_description = $request->e_description;
        $expenses->e_amount = $request->e_amount;
        $expenses->branch_id = $blanch;
        if ($f) {
            $expenses->e_file = $file_name;
        }
        //save data
        $expenses->save();
        //redirect to index
        return redirect()->route('admin.expenses.index')->with('success', 'Expense Updated Successfully');
    }
    public function approve(Request $request, string $id)
    {
        //validate amount
        $request->validate([
            'e_amount' => 'required',
        ]);
        $expenses = Expenses::findorfail($id);
        $expenses->e_amount = $request->e_amount;
        $expenses->e_status = 1;
        $expenses->save();
        return redirect()->route('admin.expenses.index')->with('success', 'Income Approved Successfully');
    }

    //reject without amount
    public function reject(string $id)
    {
        $expenses = Expenses::findorfail($id);
        $expenses->e_status = 3;
        $expenses->save();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense Rejected Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $expenses = Expenses::findorfail($id);
        $expenses->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense Deleted Successfully');
    }
}
