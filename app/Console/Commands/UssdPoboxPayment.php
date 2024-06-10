<?php

namespace App\Console\Commands;

use App\Models\PobPay;
use App\Models\UccdDpoTransanction;
use Illuminate\Console\Command;
use Zepson\Dpo\Dpo;

class UssdPoboxPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ussd:pobox-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pobox Rent & Certificate payment';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $dpo = new Dpo();
        $fiveMinutesAgo = now()->subMinutes(5);

        $transactions = UccdDpoTransanction::whereNot('service', 'electricity')->where('status', 'new')->where('created_at', '>=', $fiveMinutesAgo)->get();
        if ($transactions->isEmpty()) {
            UccdDpoTransanction::whereNot('service', 'electricity')->where('status', 'new')->where('created_at', '<', $fiveMinutesAgo)->update(['status' => 'fail']);
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
                }
            }
        }
    }
}
