<?php

namespace App\Http\Controllers;

use Zepson\Dpo\Dpo;
use App\Models\UssdSession;
use Illuminate\Http\Request;
use App\Models\UssdMeterHistory;
use App\Models\UccdDpoTransanction;

class UssdController extends Controller
{
    public function ussd(Request $request)
    {
        $sessionId = $request->sessionId;
        $phoneNumber = $request->msisdn;
        $userinput = $request->text;
        $serviceCode = $request->serviceCode;
        $networkCode = $request->networkCode;
        $response = "";

        $dpo = new Dpo;

        $text = $this->check_session($sessionId, $phoneNumber, $userinput);
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
                    } elseif (count($inputArray) == 3 && $userinput == '1') {
                        $response = "Enter Your Meter Number \n";

                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 4 && $inputArray[2] == "1") {

                        if (is_numeric($userinput)) {
                            $output = (new EUCLUssdController())->check_meter($userinput);
                            $status = $output['status'];
                            if ($status == 1) {
                                $meter_name = $output['meter_name'];

                                UssdMeterHistory::where('phone', $phoneNumber)->where('meter_number', $userinput)->firstOrCreate([
                                    'phone' => $phoneNumber,
                                    'meter_number' => $userinput,
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

                        if (!$this->validateAmount($userinput, 20)) {
                            $response = "Invalid amount. Please try again.";
                            $this->ussd_stop($response);
                        } else {
                            $meter_number = $inputArray[3];

                            $data = [
                                'paymentAmount' => $userinput,
                                'paymentCurrency' => "RWF",
                                'customerFirstName' => $meter_number,
                                'customerLastName' => "",
                                'customerAddress' => "Kigali",
                                'customerCity' => "Kigali",
                                'customerPhone' => $phoneNumber,
                                'customerEmail' => "",
                                'companyRef' => "49FKEOA",
                            ];
                            $token = $dpo->createToken($data);
                            if ($token['result'] == 000 && $token['success']) {
                                $transToken = $token['transToken'];
                                $transRef = $token['transRef'];
                                $orderData = [
                                    'phoneNumber' => $phoneNumber,
                                    'transactionToken' => $transToken,
                                ];
                                $data = $dpo->chargeMobile($orderData);

                                $status = $data['status'];
                                $success = $data['success'];
                                if ($status == 130 && $success) {

                                    UccdDpoTransanction::create([
                                        'phone' => $phoneNumber,
                                        'trans_token' => $transToken,
                                        'trans_ref' => $transRef,
                                        'meter_number' => $meter_number,
                                        'amount' => $userinput,
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

                    } elseif (count($inputArray) == 3 && $userinput == '2') {
                        $response = "Select Meter\n";
                        $this->ussd_proceed($response);
                    } else {
                        $response .= "Invalid choice. Please try again. \n";
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
                    $response .= "Invalid choice. Please try again. \n";
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
    public function check_session($session, $phone, $text)
    {
        $check = UssdSession::where('phone', $phone)->where('session_id', $session)->first();
        if ($check) {
            $check->update(['user_input' => $check->user_input . '*' . $text]);
            return $check->user_input;
        } else {
            $new = UssdSession::create(['phone' => $phone,
                'session_id' => $session,
                'user_input' => $text,
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

    private function validateAmount($amount, $minimumAmount)
    {
        return is_numeric($amount) && $amount >= $minimumAmount;
    }

}
