<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\EuclPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class TestEUCLController extends Controller
{
    //
    public $password;
    public function __construct()
    {
        $this->password = EuclPassword::latest()->first()->password;
        // $this->password = 'y05b0p';
    }
    public function testTestCheckMete(Request $request)
    {

        $uuid = Str::orderedUuid();
        $todayDate = Carbon::now()->format('YmdHim');
        $uuid = Str::orderedUuid();
        $data = [
            "request" => ["header" => ["h0" => "Vendor-WS",
                "h1" => "1.0.2",
                "h2" => "CC04",
                "h3" => $uuid,
                "h4" => "iposita",
                "h5" => "y05b0p",
                "h6" => "RW8400010001000100150903",
                "h7" => "Laptop",
                "h8" => "DB4N0Q1",
                "h9" => "14:fe:b5:ae:6e:2c",
                "h10" => "10.10.82.118",
                "h11" => $todayDate,
                "h12" => "IPOSITA Vending System",
                "h13" => "1.0.0",
                "h14" => "rw"],
                "body" => [["p0" => $request->meter]]],
        ];

        // echo json_encode($data);
        // die();
        $response2 = Http::withoutVerifying()->post('https://10.20.120.129:443/test/vendor.ws', $data);
            return \response($response2);
        // if ($response2->ok()) {
        //     $json_data = json_decode($response2);
        //     if ($json_data->response->body) {
        //         return \response()->json([
        //             'message' => $json_data->response->body[0]->p2,
        //         ], );
        //     } else {
        //         return \response()->json([
        //             'message' => "notFound",
        //         ]);
        //     }
        // } else {
        //     return \response()->json([
        //         'meter_number' => $request->meter,
        //         'message' => "server not reachable ",
        //     ]);
        // }

    }
    public function testTestBuy(Request $request)
    {

        $uuid = Str::orderedUuid();
        $todayDate = Carbon::now()->format('YmdHim');
        $data = [
            "request" => ["header" => ["h0" => "Vendor-WS",
                "h1" => "1.0.2",
                "h2" => "PC05",
                "h3" => $uuid,
                "h4" => "iposita",
                "h5" => "y05b0p",
                "h6" => "RW8400010001000100150903",
                "h7" => "Laptop",
                "h8" => "DB4N0Q1",
                "h9" => "14:fe:b5:ae:6e:2c",
                "h10" => "10.10.82.118",
                "h11" => $todayDate,
                "h12" => "IPOSITA Vending System",
                "h13" => "1.0.0",
                "h14" => "rw"],
                "body" => [["p0" => $request->meter,
                    "p1" => $request->amount,

                ]]],
        ];

        $response2 = Http::withoutVerifying()->post('https://10.20.120.129:443/test/vendor.ws', $data);
        if ($response2->ok()) {
            $json_data = json_decode($response2);
            if ($json_data->response->body) {
                return \response()->json($json_data->response->body[0], 200);
            } else {
                return \response()->json("notFound", 200);
            }
        }
    }
}
