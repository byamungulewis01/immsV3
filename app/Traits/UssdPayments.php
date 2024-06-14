<?php
namespace App\Traits;

use App\Models\UccdDpoTransanction;
use Zepson\Dpo\Dpo;

trait UssdPayments
{
    private function pay_electricity($meter_number)
    {
        $dpo = new Dpo;
        if (!$this->validateAmount($this->userInput, 500)) {
            if ($this->language == 'english') {
                $response = "Invalid amount. Please try again.";
            } else {
                $response = "Wanditse Amafaranga nabi! ongera";
            }
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

                    if ($this->language == 'english') {
                        $response = "If you didn't receive a push prompt please enter *182*7*1# then MoMo PIN to continue";
                    } else {
                        $response = "Kanda *182*7*1# hanyuma umubare wawe wibanga kugirango ubashe kwishyura.";
                    }

                    $this->ussd_stop($response);
                } elseif ($status == 130 && !$success) {
                    if ($this->language == 'english') {
                        $response = "Not charged. Please try again  \n";
                    } else {
                        $response = "Ntago bikunze, ongera ugerageze";
                    }
                    $this->ussd_stop($response);
                } else {
                    if ($this->language == 'english') {
                        $response = "server not reachable . Please try again. \n";
                    } else {
                        $response = "Ntago bikunze, ongera nanone";
                    }
                    $this->ussd_stop($response);
                }

            } else {
                if ($this->language == 'english') {
                    $response = "Ooops not work. Please try again. \n";
                } else {
                    $response = "Ntago bikunze, ongera nanone";
                }
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
                    'amount' => $rent->amount,
                ]);

                if ($this->language == 'english') {
                    $response = "If you didn't receive a push prompt please enter *182*7*1# then MoMo PIN to continue";
                } else {
                    $response = "Kanda *182*7*1# hanyuma umubare wawe wibanga kugirango ubashe kwishyura.";
                }
                $this->ussd_stop($response);
            } elseif ($status == 130 && !$success) {
                if ($this->language == 'english') {
                    $response = "Not charged. Please try again  \n";
                } else {
                    $response = "Ntago bikunze, ongera ugerageze";
                }
                $this->ussd_stop($response);
            } else {
                if ($this->language == 'english') {
                    $response = "server not reachable . Please try again. \n";
                } else {
                    $response = "Ntago bikunze, ongera nanone";
                }
                $this->ussd_stop($response);
            }

        } else {
            if ($this->language == 'english') {
                $response = "Ooops not work. Please try again. \n";
            } else {
                $response = "Ntago bikunze, ongera nanone";
            }
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

                if ($this->language == 'english') {
                    $response = "If you didn't receive a push prompt please enter *182*7*1# then MoMo PIN to continue";
                } else {
                    $response = "Kanda *182*7*1# hanyuma umubare wawe wibanga kugirango ubashe kwishyura.";
                }
                $this->ussd_stop($response);
            } elseif ($status == 130 && !$success) {
                if ($this->language == 'english') {
                    $response = "Not charged. Please try again  \n";
                } else {
                    $response = "Ntago bikunze, ongera ugerageze";
                }
                $this->ussd_stop($response);
            } else {
                if ($this->language == 'english') {
                    $response = "server not reachable . Please try again. \n";
                } else {
                    $response = "Ntago bikunze, ongera nanone";
                }
                $this->ussd_stop($response);
            }

        } else {
            if ($this->language == 'english') {
                $response = "Ooops not work. Please try again. \n";
            } else {
                $response = "Ntago bikunze, ongera nanone";
            }
            $this->ussd_stop($response);
        }

    }

    private function validateAmount($amount, $minimumAmount)
    {
        return is_numeric($amount) && $amount >= $minimumAmount;
    }

}
