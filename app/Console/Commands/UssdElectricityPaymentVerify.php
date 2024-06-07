<?php

namespace App\Console\Commands;

use App\Http\Controllers\EUCLUssdController;
use App\Http\Controllers\NotificationController;
use App\Models\UccdDpoTransanction;
use App\Models\UccdElectricityTransanction;
use Illuminate\Console\Command;
use Zepson\Dpo\Dpo;

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
    public function handle(): void
    {

        //
        $dpo = new Dpo();
        $fiveMinutesAgo = now()->subMinutes(5);

        $transactions = UccdDpoTransanction::where('status', 'new')->where('created_at', '>=', $fiveMinutesAgo)->get();
        if ($transactions->isEmpty()) {
            UccdDpoTransanction::where('status', 'new')->where('created_at', '<', $fiveMinutesAgo)->update(['status' => 'fail']);
        } else {
            foreach ($transactions as $transaction) {
                $transToken = $transaction->trans_token;
                $amount = $transaction->amount;
                $meter = $transaction->meter_number;

                $verify = $dpo->verifyToken($transToken);
                if ($verify == '000') {
                    UccdDpoTransanction::where('trans_token', $transToken)->update(['status' => 'success']);
                    $response = (new EUCLUssdController)->buy_electrity($meter, $amount);
                    if ($response) {
                        $this->sendSms($response);
                    }
                }
            }
        }

        $this->info('notify client');

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

        (new NotificationController)->intouchsms($transaction->customer_phone, $message);
    }
}
