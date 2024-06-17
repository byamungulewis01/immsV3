<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotificationController;
use App\Models\PobPay;
use App\Models\UccdDpoTransanction;
use Illuminate\Console\Command;
use Zepson\Dpo\Dpo;

class UssdCertPoboxPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ussd:cert-pobox-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'P.O Box Certificate payment';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $dpo = new Dpo();
        $fiveMinutesAgo = now()->subMinutes(5);

        $transactions = UccdDpoTransanction::where('service', 'cert')->where('status', 'new')->where('created_at', '>=', $fiveMinutesAgo)->get();
        if ($transactions->isEmpty()) {
            UccdDpoTransanction::where('service', 'cert')->where('status', 'new')->where('created_at', '<', $fiveMinutesAgo)->update(['status' => 'fail']);
        } else {
            foreach ($transactions as $transaction) {
                $transToken = $transaction->trans_token;

                $verify = $dpo->verifyToken($transToken);
                if ($verify == '000') {
                    PobPay::create([
                        'box_id' => $transaction->box_id,
                        'amount' => $transaction->amount,
                        'year' => now()->year,
                        'payment_type' => $transaction->service,
                        'payment_model' => 'momo',
                        'serviceType' => 'PBox',
                        'payment_ref' => $transToken,
                    ]);
                    UccdDpoTransanction::where('trans_token', $transToken)->update(['status' => 'success']);

                    $hashids = new \Hashids\Hashids(env('HASHIDS_SALT'), 8); // minimum length of 8 characters
                    $encode = $hashids->encode($transaction->box_id);

                    $message = "Payment of P.O box Certificate has been successfully";
                    $message .= "Download vie " . route('certificate', $encode);
                    $phone = substr($transaction->phone, 2);
                    (new NotificationController)->send_sms($phone, $message);
                }
            }
        }
        $this->info('Cert command run successfully');

    }
}
