<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Support\Str;
use App\Models\EuclPassword;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use Illuminate\Support\Facades\Http;

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
                "body" => [["p0" => $meter_number,]]],
        ];

        $url = config('services.IPOSITA_EUCL_URL') . "/vendor.ws";

        $response2 = Http::withoutVerifying()->post($url, $data);

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
