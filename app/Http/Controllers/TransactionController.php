<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\ReceiptMail;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\EuclPassword;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    //
    public $password;
    public function __construct()
    {
        $this->password = EuclPassword::latest()->first()->password;
        // $this->password = 'y05b0p';
    }
    public function index()
    {
        return view('transactions.index');
    }
    public function api()
    {
        $transactions = Transaction::orderByDesc('id')->get();
        return response()->json([
            'success' => true,
            'data' => TransactionResource::collection($transactions),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            "customer_phone" => 'required',
            "customer_email" => 'nullable|email',
            "reference_number" => 'required',
            "amount" => 'required|numeric',
        ]);

        $user = auth()->user();

        $todayDate = Carbon::now()->format('YmdHim');

        $topup_amount = $request->amount;

        $uuid = Str::orderedUuid();

        $data = [
            "request" => ["header" => ["h0" => "Vendor-WS",
                "h1" => "1.0.2",
                "h2" => "PC05",
                "h3" => $uuid,
                "h4" => "iposita",
                "h5" => $this->password,
                "h6" => "RW8400010001000100150903",
                "h7" => "Laptop",
                "h8" => "DB4N0Q1",
                "h9" => "14:fe:b5:ae:6e:2c",
                "h10" => "10.10.82.119",
                "h11" => $todayDate,
                "h12" => "IPOSITA Vending System",
                "h13" => "1.0.0",
                "h14" => "rw"],
                "body" => [["p0" => $request->reference_number,
                    "p1" => $topup_amount,

                ]]],
        ];

        $lastrecord = Transaction::where('reference_number', $request->reference_number)->latest()->first();

        // dd($lastrecord,now());

        if ($lastrecord && Carbon::now()->diffInMinutes($lastrecord->created_at) < 5) {
            return redirect()->back()->with("warning", "Cannot create a new Transaction  within 5 minutes");
        }

        $url = config('services.IPOSITA_EUCL_URL') . "/vendor.ws";

        $response2 = Http::withoutVerifying()->post($url, $data);

        if ($response2->ok()) {

            $json_data = json_decode($response2);
            if ($json_data->response->body) {
                $tokenn = $json_data->response->body[0]->p30;



                if ($json_data->response->body[0]->p31) {
                    $token_p31 = $json_data->response->body[0]->p31;
                    // Token p31
                    $data_p31 = str_split($token_p31, 4);
                    $formated_token_p31 = $data_p31[0] . '-' . $data_p31[1] . '-' . $data_p31[2] . '-' . $data_p31[3] . '-' . $data_p31[4];
                } else {
                    // Set $token_p31 to null if p31 is not available
                    $token_p31 = null;
                    $formated_token_p31 = null;
                }
                if ($json_data->response->body[0]->p32) {
                    $token_p32 = $json_data->response->body[0]->p32;
                    // Token p32
                    $data_p32 = str_split($token_p32, 4);
                    $formated_token_p32 = $data_p32[0] . '-' . $data_p32[1] . '-' . $data_p32[2] . '-' . $data_p32[3] . '-' . $data_p32[4];
                } else {
                    // Set $token_p31 to null if p31 is not available
                    $token_p32 = null;
                    $formated_token_p32 = null;
                }

                $units = $json_data->response->body[0]->p25;
                $internal_transaction_id = $uuid;
                $external_transaction_id = $json_data->response->body[0]->p14;
                $residential_rate = $json_data->response->body[0]->p65;
                $units_rate = $json_data->response->body[0]->p66;
                $request_id = $json_data->response->body[0]->p6;
                $eucl_status = $json_data->response->body[0]->p20;

                $electricity = $json_data->response->body[0]->p26;
                $tva = $json_data->response->body[0]->p27;
                $fees = $json_data->response->body[0]->p90;
                $date_from_eucl = $json_data->response->body[0]->p12;
                $opening_balance = $json_data->response->body[0]->p21;
                $current_balance = $json_data->response->body[0]->p22;
                // Token p30
                $dataa = str_split($tokenn, 4);
                $formated_token = $dataa[0] . '-' . $dataa[1] . '-' . $dataa[2] . '-' . $dataa[3] . '-' . $dataa[4];
                $transaction = new Transaction();
                $transaction->customer_name = $request->customer_name;
                $transaction->customer_phone = $request->customer_phone;
                $transaction->customer_email = $request->customer_email;
                $transaction->amount = $request->amount;
                $transaction->reference_number = $request->reference_number;
                // $transaction->charges = $serviceCharges->charges;
                // $transaction->charges_type = $serviceCharges->charges_type;
                // $transaction->total_charges = $totalCharges;
                $transaction->units = $units;
                $transaction->internal_transaction_id = $internal_transaction_id;
                $transaction->external_transaction_id = $external_transaction_id;
                $transaction->residential_rate = $residential_rate;
                $transaction->units_rate = $units_rate;
                $transaction->branch_id = $user->branch;
                $transaction->request_id = $request_id;
                $transaction->eucl_status = $eucl_status;

                $transaction->electricity = $electricity;
                $transaction->tva = $tva;
                $transaction->fees = $fees;
                $transaction->date_from_eucl = $date_from_eucl;
                $transaction->opening_balance = $opening_balance;
                $transaction->current_balance = $current_balance;

                //        if is external branch calculate the commission
                // $branch = $user->branch;
                // if ($branch && $branch->branch_type == "External") {
                //     $transaction->external_branch_commission = $totalCharges * $branch->percentage / 100;
                // }
                $transaction->user_id = $user->id;
                $transaction->status = "Success";
                $transaction->token = $formated_token;
                $transaction->token_p31 = $formated_token_p31;
                $transaction->token_p32 = $formated_token_p32;
                // $transaction->is_exclusive = $request->is_exclusive;
                $transaction->save();

                //notify the customer
                if ($request->customer_email) {
                    $this->sendEmail($transaction);
                } elseif ($request->has('customer_phone')) {
                    $this->sendSMS($transaction);
                }
                return redirect()->back()->with("success", "Transaction is created Successfully");
            } else {
                return redirect()->back()->with("warning", "Transaction not created external Api issues");
            }
        }

        //deduct the amount from the balance if it is external branch

    }
    public function fetchMeterFromEUCL()
    {
        $meter_number = request('meter_number');
        $uuid = Str::orderedUuid();

        $todayDate = Carbon::now()->format('YmdHim');
        $data = [
            "request" => ["header" => ["h0" => "Vendor-WS",
                "h1" => "1.0.2",
                "h2" => "CC04",
                "h3" => $uuid,
                "h4" => "iposita",
                "h5" => $this->password,
                "h6" => "RW8400010001000100150903",
                "h7" => "Laptop",
                "h8" => "DB4N0Q1",
                "h9" => "14:fe:b5:ae:6e:2c",
                "h10" => "10.10.82.119",
                "h11" => $todayDate,
                "h12" => "IPOSITA Vending System",
                "h13" => "1.0.0",
                "h14" => "rw"],
                "body" => [["p0" => $meter_number,

                ]]],
        ];

        $url = config('services.IPOSITA_EUCL_URL') . "/vendor.ws";

        $response2 = Http::withoutVerifying()->post($url, $data);
        // $response2 = Http::withoutVerifying()->post('https://10.20.120.129:443/test/vendor.ws', $data);

        if ($response2->ok()) {
            $json_data = json_decode($response2);
            if ($json_data->response->body) {
                return \response()->json([
                    'meter_number' => $meter_number,
                    'meter_name' => $json_data->response->body[0]->p2,
                ], 200);
            } else {
                return \response()->json([
                    'meter_number' => $meter_number,
                    'messagess' => "Meter number not found",
                ], 200);
            }
        } else {
            return \response()->json([
                'meter_number' => $meter_number,
                'messagess' => "server not reachable ",
            ], 200);
        }

    }

    public function printReceipt($id)
    {
        $transaction = Transaction::findOrFail($id);
        if (\request()->type == "sms") {
            $this->sendSms($transaction);
            return redirect()->back()->with("success", "SMS is sent Successfully");
        } elseif (\request()->type == "email") {
            $this->sendEmail($transaction);
            return redirect()->back()->with("success", "Email is sent Successfully");

        } else {
            $pdf = PDF::loadView('transactions.receipt', compact('transaction'));
            return $pdf->stream('receipt.pdf');
            // return view('admin.transactions.receiptTest', compact('transaction'));
        }
    }
    protected function sendSms(Transaction $transaction)
    {
        $message = "Dear " . $transaction->customer_name . ", \r\nYour Cash Power account is  " . $transaction->reference_number;
        if ($transaction->token_p31 != null) {
            $message .= " Your Token 1# :" . $transaction->token . " Your Token 2# :" . $transaction->token_p31 . " And Token 3# :" . $transaction->token_p32;
        } else {
            $message .= " Your Voucher# :" . $transaction->token;
        }

        $message .= " Amount: RWF" . number_format($transaction->amount) . " Units#: " . number_format($transaction->units, 2) . " kWh \r\nThank you for using our service.";

        (new NotificationController)->send_sms($transaction->customer_phone, $message);
    }

    private function sendEmail(Transaction $transaction)
    {
        Mail::to($transaction->customer_email)->send(new ReceiptMail($transaction));
    }

    public function reports()
    {
        return view('transactions.trans_reports');
    }
    public function reportsApi()
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)->orderByDesc('id')->get();
        return response()->json([
            'success' => true,
            'data' => TransactionResource::collection($transactions),
        ]);
    }

}
