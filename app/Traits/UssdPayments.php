<?php
namespace App\Traits;

use Zepson\Dpo\Dpo;
use App\Models\UccdDpoTransanction;

trait UssdPayments
{
    private function pay_electricity($meter_number)
    {
        $dpo = new Dpo;
        if (!$this->validateAmount($this->userInput, 500)) {
            $response = "Invalid amount. Please try again.";
            $this->ussd_stop($response);
        } else {
            // $meter_number = $inputArray[3];

            $data = [
                'paymentAmount' => $this->userInput,
                'paymentCurrency' => "RWF",
                'customerFirstName' => $meter_number,
                'customerLastName' => "",
                'customerAddress' => "Kigali",
                'customerCity' => "Kigali",
                'customerPhone' => $this->phoneNumber,
                'customerEmail' => "",
                'companyRef' => "49FKEOA",
            ];
            $token = $dpo->createToken($data);
            if ($token['result'] == 000 && $token['success']) {
                $transToken = $token['transToken'];
                $transRef = $token['transRef'];
                $orderData = [
                    'phoneNumber' => $this->phoneNumber,
                    'transactionToken' => $transToken,
                ];
                $data = $dpo->chargeMobile($orderData);

                $status = $data['status'];
                $success = $data['success'];
                if ($status == 130 && $success) {

                    UccdDpoTransanction::create([
                        'service' => 'electricity',
                        'phone' => $this->phoneNumber,
                        'trans_token' => $transToken,
                        'trans_ref' => $transRef,
                        'meter_number' => $meter_number,
                        'amount' => $this->userInput,
                    ]);

                    $response = "If you didn't receive a push prompt please enter *182*7*1# then MoMo PIN to continue";
                    $this->ussd_stop($response);
                } elseif ($status == 130 && !$success) {
                    $response = "Not charged. Please try again  \n";
                    $this->ussd_stop($response);
                } else {
                    $response = "server not reachable . Please try again. \n";
                    $this->ussd_stop($response);
                }

            } else {
                $response = "Ooops not work. Please try again. \n";
                $this->ussd_stop($response);
            }

        }
    }
    private function pay_pobox_rent($rent, $pobox)
    {
        $dpo = new Dpo;
            $data = [
                'paymentAmount' => $rent->amount,
                'paymentCurrency' => "RWF",
                'customerFirstName' => $pobox->name,
                'customerLastName' => "",
                'customerAddress' => "Kigali",
                'customerCity' => "Kigali",
                'customerPhone' => $this->phoneNumber,
                'customerEmail' => "",
                'companyRef' => "49FKEOA",
            ];
            $token = $dpo->createToken($data);
            if ($token['result'] == 000 && $token['success']) {
                $transToken = $token['transToken'];
                $transRef = $token['transRef'];
                $orderData = [
                    'phoneNumber' => $this->phoneNumber,
                    'transactionToken' => $transToken,
                ];
                $data = $dpo->chargeMobile($orderData);

                $status = $data['status'];
                $success = $data['success'];
                if ($status == 130 && $success) {

                    UccdDpoTransanction::create([
                        'service' => 'rent',
                        'phone' => $this->phoneNumber,
                        'trans_token' => $transToken,
                        'trans_ref' => $transRef,
                        'box_id' => $pobox->id,
                        'pob_year' => $rent->year,
                        'amount' =>  $rent->amount,
                    ]);

                    $response = "If you didn't receive a push prompt please enter *182*7*1# then MoMo PIN to continue";
                    $this->ussd_stop($response);
                } elseif ($status == 130 && !$success) {
                    $response = "Not charged. Please try again  \n";
                    $this->ussd_stop($response);
                } else {
                    $response = "server not reachable . Please try again. \n";
                    $this->ussd_stop($response);
                }

            } else {
                $response = "Ooops not work. Please try again. \n";
                $this->ussd_stop($response);
            }

    }
    private function pay_pobox_cert($pobox)
    {
        $amount = 5000;
        $dpo = new Dpo;
            $data = [
                'paymentAmount' => $amount,
                'paymentCurrency' => "RWF",
                'customerFirstName' => $pobox->name,
                'customerLastName' => "",
                'customerAddress' => "Kigali",
                'customerCity' => "Kigali",
                'customerPhone' => $this->phoneNumber,
                'customerEmail' => "",
                'companyRef' => "49FKEOA",
            ];
            $token = $dpo->createToken($data);
            if ($token['result'] == 000 && $token['success']) {
                $transToken = $token['transToken'];
                $transRef = $token['transRef'];
                $orderData = [
                    'phoneNumber' => $this->phoneNumber,
                    'transactionToken' => $transToken,
                ];
                $data = $dpo->chargeMobile($orderData);

                $status = $data['status'];
                $success = $data['success'];
                if ($status == 130 && $success) {

                    UccdDpoTransanction::create([
                        'service' => 'cert',
                        'phone' => $this->phoneNumber,
                        'trans_token' => $transToken,
                        'trans_ref' => $transRef,
                        'box_id' => $pobox->id,
                        'amount' => $amount,
                    ]);

                    $response = "If you didn't receive a push prompt please enter *182*7*1# then MoMo PIN to continue";
                    $this->ussd_stop($response);
                } elseif ($status == 130 && !$success) {
                    $response = "Not charged. Please try again  \n";
                    $this->ussd_stop($response);
                } else {
                    $response = "server not reachable . Please try again. \n";
                    $this->ussd_stop($response);
                }

            } else {
                $response = "Ooops not work. Please try again. \n";
                $this->ussd_stop($response);
            }

    }

    private function validateAmount($amount, $minimumAmount)
    {
        return is_numeric($amount) && $amount >= $minimumAmount;
    }


}
