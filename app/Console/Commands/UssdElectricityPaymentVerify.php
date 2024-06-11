<?php

namespace App\Console\Commands;

use Zepson\Dpo\Dpo;
use Illuminate\Console\Command;
use App\Models\UssdMeterHistory;
use App\Models\UccdDpoTransanction;
use App\Models\UccdElectricityTransanction;
use App\Http\Controllers\EUCLUssdController;
use App\Http\Controllers\NotificationController;

class UssdElectricityPaymentVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ussd:electricity-payment-verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Electricity payment verification';

    /**
     * Execute the console command.
     */
    public $meter;
    public $amount;
    public function handle(): void
    {

        //
        $dpo = new Dpo();
        $fiveMinutesAgo = now()->subMinutes(5);

        $transactions = UccdDpoTransanction::where('service','electricity')->where('status', 'new')->where('created_at', '>=', $fiveMinutesAgo)->get();
        if ($transactions->isEmpty()) {
            UccdDpoTransanction::where('service','electricity')->where('status', 'new')->where('created_at', '<', $fiveMinutesAgo)->update(['status' => 'fail']);
        } else {
            foreach ($transactions as $transaction) {
                $transToken = $transaction->trans_token;
                $this->amount = $transaction->amount;
                $this->meter = $transaction->meter_number;

                $verify = $dpo->verifyToken($transToken);
                if ($verify == '000') {
                    UccdDpoTransanction::where('trans_token', $transToken)->update(['status' => 'success']);
                    $data = (new EUCLUssdController)->buy_electrity($this->meter, $this->amount);
                    if ($data->status == 1) {
                        $this->storeTransaction($data->response);
                    }
                }
            }
        }

        // $this->info('notify client');

    }

    protected function storeTransaction($response)
    {
        $tokenn = $response->p30;

        if ($response->p31) {
            $token_p31 = $response->p31;
            // Token p31
            $data_p31 = str_split($token_p31, 4);
            $formated_token_p31 = $data_p31[0] . '-' . $data_p31[1] . '-' . $data_p31[2] . '-' . $data_p31[3] . '-' . $data_p31[4];
        } else {
            // Set $token_p31 to null if p31 is not available
            $token_p31 = null;
            $formated_token_p31 = null;
        }
        if ($response->p32) {
            $token_p32 = $response->p32;
            // Token p32
            $data_p32 = str_split($token_p32, 4);
            $formated_token_p32 = $data_p32[0] . '-' . $data_p32[1] . '-' . $data_p32[2] . '-' . $data_p32[3] . '-' . $data_p32[4];
        } else {
            // Set $token_p31 to null if p31 is not available
            $token_p32 = null;
            $formated_token_p32 = null;
        }

        $units = $response->p25;
        $external_transaction_id = $response->p14;
        $residential_rate = $response->p65;
        $units_rate = $response->p66;
        $request_id = $response->p6;
        $eucl_status = $response->p20;

        $electricity = $response->p26;
        $tva = $response->p27;
        $fees = $response->p90;
        $date_from_eucl = $response->p12;
        $opening_balance = $response->p21;
        $current_balance = $response->p22;
        // Token p30
        $dataa = str_split($tokenn, 4);
        $formated_token = $dataa[0] . '-' . $dataa[1] . '-' . $dataa[2] . '-' . $dataa[3] . '-' . $dataa[4];

        $customer = UssdMeterHistory::where('meter_number', $this->meter)->first();

        $transaction = new UccdElectricityTransanction();
        $transaction->customer_name = $customer->meter_name;
        $transaction->customer_phone = $customer->phone;
        $transaction->amount = $this->amount;
        $transaction->reference_number = $this->meter;
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

        if ($transaction) {
            $this->sendSms($transaction);
        }
    }
    protected function sendSms(UccdElectricityTransanction $transaction)
    {
        $message = "Dear " . $transaction->customer_name . ", \r\nYour Cash Power account is  " . $transaction->reference_number;
        if ($transaction->token_p31 != null) {
            $message .= " Your Token 1# :" . $transaction->token . " Your Token 2# :" . $transaction->token_p31 . " And Token 3# :" . $transaction->token_p32;
        } else {
            $message .= " Your Voucher# :" . $transaction->token;
        }

        $message .= " Amount: RWF" . number_format($transaction->amount) . " Units#: " . number_format($transaction->units, 2) . " kWh \r\nThank you for using our service.";
        $phone = substr($transaction->customer_phone, 2);
        (new NotificationController)->send_sms($phone, $message);
    }
}
