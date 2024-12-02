<?php

namespace App\Jobs;

use App\Models\Box;
use App\Models\PobNotification;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPobRentReminderSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Box $box, public $year)
    {
        $this->box = $box;
        $this->year = $year;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $message = Setting::where('type', 'pobox_pay_rent_sms')->first()->value;
        $personalMessage = str_replace('{name}', $this->box->name, $message);
        $data = [
            'rent_year' => $this->year,
            'type' => 'rent',
            'pob' => $this->box->pob,
            'name' => $this->box->name,
            'phone' => $this->box->phone,
        ];
        if ($this->isValidPhoneNumber($this->box->phone)) {
            $data['status'] = 'sent';
        } else {
            $data['status'] = 'not-sent';
        }
        $notify = PobNotification::create($data);

    }
    private function isValidPhoneNumber($phone)
    {
        return preg_match('/^(07\d{8}|2507\d{8})$/', $phone);
    }
}
