<?php

namespace App\Http\Controllers;

use App\Models\UccdDpoTransanction;
use App\Models\UssdMeterHistory;
use App\Models\UssdSession;
use Illuminate\Http\Request;
use Zepson\Dpo\Dpo;

class UssdController extends Controller
{
    private $sessionId;
    private $phoneNumber;
    private $userinput;
    public function ussd(Request $request)
    {
        $this->sessionId = $request->sessionId;
        $this->phoneNumber = $request->msisdn;
        $this->userinput = $request->text;
        $serviceCode = $request->serviceCode;
        $networkCode = $request->networkCode;

        $text = $this->check_session();
        if ($text == "192") {
            header('FreeFlow: FC');
            header('Content-type: text/plain');
            return $this->home_menu();
        } else {
            $inputArray = explode("*", $text);
            switch ($inputArray[1]) {
                case "1":
                    // Buy Electricity
                    if (count($inputArray) == 2) {
                        $response = "Please choose:\n";
                        $response .= "1) Enter meter number\n";
                        $response .= "2) Select a saved meter\n";

                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 3 && $this->userinput == '1') {
                        $response = "Enter Your Meter Number \n";

                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 4 && $inputArray[2] == "1") {

                        if (is_numeric($this->userinput)) {
                            $output = (new EUCLUssdController())->check_meter($this->userinput);
                            $status = $output['status'];
                            if ($status == 1) {
                                $meter_name = $output['meter_name'];

                                UssdMeterHistory::where('phone', $this->phoneNumber)->where('meter_number', $this->userinput)->firstOrCreate([
                                    'phone' => $this->phoneNumber,
                                    'meter_number' => $this->userinput,
                                    'meter_name' => $meter_name,
                                ]);

                                $response = "Name on meter : $meter_name" . "\n";
                                $response .= "Enter amount (min. 20 RWF):  " . "\n";
                                $this->ussd_proceed($response);
                            } elseif ($status == 2) {
                                $response = "Meter not found. Please check your meter number \n";
                                $this->ussd_stop($response);
                            } else {
                                $response = "server not reachable . Please try again. \n";
                                $this->ussd_stop($response);
                            }

                        } else {
                            $response = "Meter should be numeric. Please try again. \n";
                            $this->ussd_stop($response);
                        }

                    } elseif (count($inputArray) == 5 && $inputArray[2] == "1") {
                        $meter_number = $inputArray[3];
                        // if (!$this->validateAmount($this->userinput, 20)) {
                        //     $response = "Invalid amount. Please try again.";
                        //     $this->ussd_stop($response);
                        // } else {
                        //     $meter_number = $inputArray[3];

                        //     $data = [
                        //         'paymentAmount' => $this->userinput,
                        //         'paymentCurrency' => "RWF",
                        //         'customerFirstName' => $meter_number,
                        //         'customerLastName' => "",
                        //         'customerAddress' => "Kigali",
                        //         'customerCity' => "Kigali",
                        //         'customerPhone' => $this->phoneNumber,
                        //         'customerEmail' => "",
                        //         'companyRef' => "49FKEOA",
                        //     ];
                        //     $token = $dpo->createToken($data);
                        //     if ($token['result'] == 000 && $token['success']) {
                        //         $transToken = $token['transToken'];
                        //         $transRef = $token['transRef'];
                        //         $orderData = [
                        //             'phoneNumber' => $phoneNumber,
                        //             'transactionToken' => $transToken,
                        //         ];
                        //         // $data = $dpo->chargeMobile($orderData);

                        //         $status = $data['status'];
                        //         $success = $data['success'];
                        //         if ($status == 130 && $success) {

                        //             UccdDpoTransanction::create([
                        //                 'phone' => $phoneNumber,
                        //                 'trans_token' => $transToken,
                        //                 'trans_ref' => $transRef,
                        //                 'meter_number' => $meter_number,
                        //                 'amount' => $userinput,
                        //             ]);

                        //             $response = "If you didn't receive a push prompt please enter *182*7*1# then MoMo PIN to continue";
                        //             $this->ussd_stop($response);
                        //         } elseif ($status == 130 && !$success) {
                        //             $response = "Not charged. Please try again  \n";
                        //             $this->ussd_stop($response);
                        //         } else {
                        //             $response = "server not reachable . Please try again. \n";
                        //             $this->ussd_stop($response);
                        //         }

                        //     } else {
                        //         $response = "Ooops not work. Please try again. \n";
                        //         $this->ussd_stop($response);
                        //     }

                        // }

                        $this->pay_electricity($meter_number);

                    } elseif (count($inputArray) == 3 && $this->userinput == '2') {
                        $meters = UssdMeterHistory::where('phone', $this->phoneNumber)->limit(5)->orderByDesc('id')->get();
                        if ($meters->count() > 0) {
                            $response = "Select Meter\n";
                            foreach ($meters as $key => $value) {
                                $response .= $key + 1 . ")" . $value->meter_number . "\n";
                            }
                        } else {
                            $response = "no meter saved \n";
                            $response .= "0) Back";
                        }

                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 4) {
                        $fetch = $this->savedMeter($this->userinput);
                        if ($fetch['success']) {
                            $meter = $fetch['meter'];
                            $name = $fetch['name'];
                            $response = $meter . " Name on meter $name \n";
                            $response .= "Enter amount (min. 20 RWF):  " . "\n";
                            $this->ussd_proceed($response);
                        } else {
                            $response = "Invalid choice. Please try again. \n";
                            $this->ussd_stop($response);
                        }

                    } elseif (count($inputArray) == 5) {
                        $input = (int) $inputArray[3];

                        $fetch = $this->savedMeter($input);
                        if ($fetch['success']) {
                            $meter = $fetch['meter'];

                            $response = $meter;
                            $this->ussd_stop($response);
                            // $this->pay_electricity($meter);

                        } else {
                            $response = "Invalid choice. Please try again Hereeee. \n";
                            $this->ussd_stop($response);
                        }

                    } elseif (count($inputArray) == 4 && $this->userinput == '0') {
                        $this->goBack();
                        $response = "Please choose:\n";
                        $response .= "1) Enter meter number\n";
                        $response .= "2) Select a saved meter\n";
                        $this->ussd_proceed($response);
                    } else {
                        $response = "Invalid choice. Please try again. \n";
                        $this->ussd_stop($response);
                    }

                    break;

                case "2":
                    // Buy Airtime
                    $response = "Buying Aitime\n";
                    $response .= "\n 1)Buy for your self";
                    $response .= "\n 2)Buy for your others";
                    $response .= count($inputArray);

                    $this->ussd_proceed($response);
                    break;

                case "3":
                    // Rent P.O Box
                    $response = "Rent P.O Box\n";
                    $this->ussd_proceed($response);

                    break;
                case "4":
                    // P.O Box Certificate
                    $response = "P.O Box Certificate\n";
                    $this->ussd_proceed($response);

                    break;
                case "5":
                    // Chech P.O Box
                    $response = "Chech P.O Box\n";
                    $this->ussd_proceed($response);

                    break;

                default:
                    $response = "Invalid choice. Please try again. \n";
                    $this->ussd_stop($response);
                    break;
            }

        }

    }

    public function home_menu()
    {
        $response = "";
        $response .= "Welcome to Iposita online Services \n";
        $response .= "1) Buy Electricity \n";
        $response .= "2) Buy Airtime \n";
        $response .= "3) Rent P.O Box\n";
        $response .= "4) P.O Box Certificate\n";
        $response .= "5) Chech P.O Box\n";
        return $response;
    }
    public function check_session()
    {
        $check = UssdSession::where('phone', $this->phoneNumber)->where('session_id', $this->sessionId)->first();
        if ($check) {
            $check->update(['user_input' => $check->user_input . '*' . $this->userinput]);
            return $check->user_input;
        } else {
            $new = UssdSession::create(['phone' => $this->phoneNumber,
                'session_id' => $this->sessionId,
                'user_input' => $this->userinput,
            ]);
            return $new->user_input;
        }

    }
    private function ussd_proceed($response)
    {
        header('FreeFlow: FC');
        header('Content-type: text/plain');
        echo $response;
    }

    private function ussd_stop($response)
    {
        header('FreeFlow: FB');
        header('Content-type: text/plain');
        echo $response;
    }
    private function goBack()
    {
        $session = UssdSession::where('phone', $this->phoneNumber)->where('session_id', $this->sessionId)->first();
        $user_input = substr($session->user_input, 0, -4);
        $session->update(['user_input' => $user_input]);
        return true;
    }

    private function validateAmount($amount, $minimumAmount)
    {
        return is_numeric($amount) && $amount >= $minimumAmount;
    }

    private function pay_electricity($meter_number)
    {
        $dpo = new Dpo;
        if (!$this->validateAmount($this->userinput, 20)) {
            $response = "Invalid amount. Please try again.";
            $this->ussd_stop($response);
        } else {
            // $meter_number = $inputArray[3];

            $data = [
                'paymentAmount' => $this->userinput,
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
                // $data = $dpo->chargeMobile($orderData);

                $status = $data['status'];
                $success = $data['success'];
                if ($status == 130 && $success) {

                    UccdDpoTransanction::create([
                        'phone' => $this->phoneNumber,
                        'trans_token' => $transToken,
                        'trans_ref' => $transRef,
                        'meter_number' => $meter_number,
                        'amount' => $this->userinput,
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

    private function savedMeter($input)
    {
        $meters = UssdMeterHistory::where('phone', $this->phoneNumber)->limit(5)->orderByDesc('id')->get();
        if ($input >= 1 && $input <= $meters->count()) {
            foreach ($meters as $key => $value) {
                if ($key == $input - 1) {
                    $meter = $value->meter_number;
                    $name = $value->meter_name;
                }
            }
            return ['success' => true, 'meter' => $meter, 'name' => $name];
        } else {
            return ['success' => false];

        }
    }

}
