<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Eric\Inboxing;
use App\Models\EuclPassword;
use App\Models\UccdElectricityTransanction;
use App\Models\UssdMeterHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EUCLUssdController extends Controller
{
    //
    // public function check_meter($meter)
    // {
    //    return 'BYAMUNGU Lewis';
    // }
    public $password;
    public function __construct()
    {
        $this->password = EuclPassword::latest()->first()->password;
        // $this->password = 'y05b0p';
    }
    public function check_meter($meter_number)
    {
        $uuid = Str::orderedUuid();
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
                "h11" => now()->format('YmdHim'),
                "h12" => "IPOSITA Vending System",
                "h13" => "1.0.0",
                "h14" => "rw"],
                "body" => [["p0" => $meter_number]]],
        ];

        $url = config('services.IPOSITA_EUCL_URL') . "/vendor.ws";

        $response2 = Http::withoutVerifying()->post($url, $data);

        if ($response2->ok()) {
            $json_data = json_decode($response2);
            if ($json_data->response->body) {
                return [
                    'status' => 1,
                    'message' => 'success',
                    'meter_name' => $json_data->response->body[0]->p2,
                ];
            } else {
                return [
                    'status' => 2,
                    'message' => 'Meter number not found',
                ];
            }
        } else {
            return [
                'status' => 3,
                'message' => 'server not reachable ',
            ];
        }

    }
    public function buy_electrity($meter, $amount)
    {
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
                "h11" => now()->format('YmdHim'),
                "h12" => "IPOSITA Vending System",
                "h13" => "1.0.0",
                "h14" => "rw"],
                "body" => [["p0" => $meter,
                    "p1" => $amount,]]
                ],
        ];

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

                $customer = UssdMeterHistory::where('meter_number', $meter)->first();

                $transaction = new UccdElectricityTransanction();
                $transaction->customer_name = $customer->meter_name;
                $transaction->customer_phone = $customer->phone;
                $transaction->amount = $amount;
                $transaction->reference_number = $meter;
                $transaction->units = $units;
                $transaction->external_transaction_id = $external_transaction_id;
                $transaction->residential_rate = $residential_rate;
                $transaction->units_rate = $units_rate;
                $transaction->request_id = $request_id;
                $transaction->eucl_status = $eucl_status;

                $transaction->electricity = $electricity;
                $transaction->tva = $tva;
                $transaction->fees = $fees;
                $transaction->date_from_eucl = $date_from_eucl;
                $transaction->opening_balance = $opening_balance;
                $transaction->current_balance = $current_balance;
                $transaction->token = $formated_token;
                $transaction->token_p31 = $formated_token_p31;
                $transaction->token_p32 = $formated_token_p32;
                $transaction->save();

                return $transaction;

            } else {
                return false;
            }
        }

        //deduct the amount from the balance if it is external branch

    }
    public function virtual_pob(Request $request)
    {
        $request->validate([
            'pob' => 'required|string',
        ]);

        try {
            $box = Box::where('aprooved', true)->where('serviceType', 'VBox')->where('pob', $request->pob)->select(['pob', 'name', 'amount'])->first();
            if (!$box) {
                return response()->json(['data' => 'noPOB'], 404);
            }
            return response()->json(['data' => $box], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => 'An error occurred.'], 500);
        }
    }
    public function physical_pob(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        try {
            $box = Box::where('aprooved', true)->where('serviceType', 'PBox')->where('phone', $request->phone)->select(['pob', 'name', 'amount'])->first();
            if (!$box) {
                return response()->json(['data' => 'noPOB'], 404);
            }
            return response()->json(['data' => $box], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => 'An error occurred.'], 500);
        }
    }
    public function mail(Request $request)
    {
        $request->validate([
            'pob' => 'required|string',
        ]);

        try {
            $inboxing = Inboxing::where('pob', $request->pob)->where('instatus', '4')->latest()->first();
            if (!$inboxing) {
                return response()->json(['data' => 'noMail'], 404);
            }
            return response()->json(['data' => $inboxing], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => 'An error occurred.'], 500);
        }
    }

    // return (new EUCLUssdController())->buy_electrity();

}
