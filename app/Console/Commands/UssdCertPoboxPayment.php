<?php

namespace App\Console\Commands;

use Zepson\Dpo\Dpo;
use App\Models\PobPay;
use Illuminate\Console\Command;
use App\Models\UccdDpoTransanction;
use App\Http\Controllers\NotificationController;

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
                    $message = "Payment of P.O box Certificate has been successfully";
                    $phone = substr($transaction->phone, 2);
                    (new NotificationController)->send_sms($phone, $message);
                }
            }
        }
        $this->info('Cert command run successfully');

    }
}
