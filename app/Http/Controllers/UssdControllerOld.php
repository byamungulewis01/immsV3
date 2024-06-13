<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Zepson\Dpo\Dpo;
use App\Traits\UssdMenu;
use App\Models\UssdSession;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\UccdPoboxClient;
use App\Models\UssdMeterHistory;
use Illuminate\Support\Facades\DB;
use App\Models\UccdDpoTransanction;

class UssdController extends Controller
{
    use UssdMenu;
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
            return $this->home_menu();
        } else {
            $inputArray = explode("*", $text);
            switch ($inputArray[1]) {
                case "1":
                    // Buy Electricity
                    if (count($inputArray) == 2) {
                        $this->electricity_menu();
                    } elseif (count($inputArray) == 3 && $this->userinput == '0') {
                        $this->goBack();
                        $this->home_menu();
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
                                $response .= "Enter amount (min. 100 RWF):  " . "\n";
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
                            $response = "$meter Name on meter $name \n";
                            $response .= "Enter amount (min. 100 RWF):  " . "\n";
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

                            $this->pay_electricity($meter);
                            // $response = $meter;
                            // $this->ussd_stop($response);

                        } else {
                            $response = "Invalid choice. Please try again Hereeee. \n";
                            $this->ussd_stop($response);
                        }

                    } elseif (count($inputArray) == 4 && $this->userinput == '0') {
                        $this->goBack();
                        $this->electricity_menu();
                    } else {
                        $response = "Invalid choice. Please try again. \n";
                        $this->ussd_stop($response);
                    }

                    break;

                case "2":
                    // Buy Airtime
                    $response = "Buying Aitime\n";
                    $response .= "\n 1)Buy for your self";
                    $response .= "\n 2)Buy for  Another";

                    $this->ussd_proceed($response);
                    break;

                case "3":
                    // P.O Box Services
                    if (count($inputArray) == 2) {
                        $this->pobox_menu();
                    }
                    // RENT-  P.O Box
                    // Save P.O Box
                    elseif (count($inputArray) == 3 && $this->userinput == '1') {
                        $response = "Select one from list \n";
                        $response .= "1) My registered P.O Box \n";
                        $response .= "2) Another  P.O Box \n";
                        $response .= "0) Go Back \n";
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 4 && $inputArray[2] == '1' && $this->userinput == '1') {
                        $this->my_pobox_menu();
                    } elseif (count($inputArray) == 5 && $inputArray[2] == '1' && $inputArray[3] == '1') {
                        $box = $this->my_pobox_selected($this->userinput);
                        $rentYearNumber = now()->year - $box->year;
                        $totalRent = $box->amount * $rentYearNumber;
                        if (now()->month == 1 && now()->day <= 31):
                            if ($box->year == now()->year):
                                $pernaty = 0;
                            else:
                                $pernaty = now()->year - $box->year - 1;
                            endif;
                        else:
                            $pernaty = now()->year - $box->year;
                        endif;
                        $total = $totalRent + $box->amount * 0.25 * $pernaty;

                        $response = "P.O Box RENT \n";
                        $response .= "1) Total Amount : $total FRW \n";

                        $this->ussd_proceed($response);

                    } elseif (count($inputArray) == 6 && $inputArray[2] == '1' && $inputArray[3] == '1' && $this->userinput == '1') {
                        $response = "Call API to pay Rent In saved PATH (RENT)";
                        $this->ussd_proceed($response);
                    }
                    // End Save P.O Box
                    // When Uses unsaved P.O Box
                    elseif (count($inputArray) == 4 && $inputArray[2] == '1' && $this->userinput == '2') {
                        $response = "Provide P.O Box number \n";
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 5 && $inputArray[2] == '1' && $inputArray[3] == '2') {
                        $response = "Choose P.O Box Branch \n";

                        $branches = DB::table('branches')->select('id', 'name')->get();
                        foreach ($branches as $key => $branch) {
                            $response .= $key + 1 . ") " . $branch->name . "\n";
                        }
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 6 && $inputArray[2] == '1' && $inputArray[3] == '2') {
                        // search pobox
                        $pob = $inputArray[4];
                        $data = $this->searchPobox($pob);
                        if ($data['status'] == 1) {
                            $response = "P.O Box of " . $data['name'] . "\n";
                            $response .= "Certifacate is 5000 FRW \n";
                            $response .= "1) To pay certificate \n";
                            $this->ussd_proceed($response);
                        } elseif ($data['status'] == 2) {
                            $branch_name = $data['branch'];
                            $response = "P.O Box $pob not found in $branch_name Branch";
                            $this->ussd_stop($response);
                        } else {
                            $response = "Invalid choice. Please try again. \n";
                            $this->ussd_stop($response);
                        }

                    } elseif (count($inputArray) == 7 && $inputArray[2] == '1' && $inputArray[3] == '2' && $this->userinput == '1') {
                        // search pobox
                        $response = "Call API to pay In Unsaved PATH (RENT)";
                        $this->ussd_proceed($response);
                    }
                    // When Uses unsaved P.O Box

                    // END RENT-  P.O Box
                    //  ================================================================
                    // CERTIFICATE - P.O Box
                    // Save P.O Box
                    elseif (count($inputArray) == 3 && $this->userinput == '2') {
                        $response = "Select one from list \n";
                        $response .= "1) My registered P.O Box \n";
                        $response .= "2) Another  P.O Box \n";
                        $response .= "0) Go Back \n";

                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 4 && $inputArray[2] == '2' && $this->userinput == '1') {
                        $this->my_pobox_menu();
                    } elseif (count($inputArray) == 5 && $inputArray[2] == '2' && $inputArray[3] == '1') {
                        $response = "P.O Box Certifaction is 5000 FRW \n";
                        $response .= "1) To pay certificate \n";

                        $this->ussd_proceed($response);

                    } elseif (count($inputArray) == 6 && $inputArray[2] == '2' && $inputArray[3] == '1' && $this->userinput == '1') {
                        $response = "Call API to pay certificate In saved PATH (Certificate)";
                        $this->ussd_proceed($response);
                    }
                    // End Save P.O Box
                    // When Uses unsaved P.O Box
                    elseif (count($inputArray) == 4 && $inputArray[2] == '2' && $this->userinput == '2') {
                        $response = "Provide P.O Box number \n";
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 5 && $inputArray[2] == '2' && $inputArray[3] == '2') {
                        $response = "Choose P.O Box Branch \n";

                        $branches = DB::table('branches')->select('id', 'name')->get();
                        foreach ($branches as $key => $branch) {
                            $response .= $key + 1 . ") " . $branch->name . "\n";
                        }
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 6 && $inputArray[2] == '2' && $inputArray[3] == '2') {
                        // search pobox
                        $pob = $inputArray[4];
                        $data = $this->searchPobox($pob);
                        if ($data['status'] == 1) {
                            $response = "P.O Box of " . $data['name'] . "\n";
                            $response .= "Certifacate is 5000 FRW \n";
                            $response .= "1) To pay certificate \n";
                            $this->ussd_proceed($response);
                        } elseif ($data['status'] == 2) {
                            $branch_name = $data['branch'];
                            $response = "P.O Box $pob not found in $branch_name Branch";
                            $this->ussd_stop($response);
                        } else {
                            $response = "Invalid choice. Please try again. \n";
                            $this->ussd_stop($response);
                        }

                    } elseif (count($inputArray) == 7 && $inputArray[2] == '2' && $inputArray[3] == '2' && $this->userinput == '1') {
                        // search pobox
                        $response = "Call API to pay In Unsaved PATH (Certificate)";
                        $this->ussd_proceed($response);
                    }
                    // When Uses unsaved P.O Box
                    // End of CERTFICATE - P.O Box
                    // ======================================================================

                    elseif (count($inputArray) == 3 && $this->userinput == '3') {
                        $this->my_pobox_menu();
                    } elseif (count($inputArray) == 4 && $inputArray[2] == '3') {
                        $fetch = $this->savedPobox($this->userinput);
                        if ($fetch['success']) {
                            $pobox = $fetch['pobox'];
                            $inboxing = Inboxing::where('pob', $pobox)->where('instatus', '4')->latest()->first();
                            if ($inboxing) {
                                $response = "You have mail shortly you will get SMS for more details";
                                $message = "IPOSITA informs you that you have an item to pick at Guichet:8 code:$inboxing->innumber If you need home delivery service,please call this number 0789499177";
                                (new NotificationController)->intouchsms($this->phoneNumber, $message);
                            } else {
                                $response = "Seems like you don't have any mail";
                            }
                        } else {
                            $response = "Invalid choice. Please try again. \n";
                        }

                        $this->ussd_stop($response);
                    } elseif (count($inputArray) == 3 && $this->userinput == '4') {
                        $response = "Provide P.O Box number \n";
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 4 && $this->userinput != '0') {
                        $response = "Choose P.O Box Branch \n";

                        $branches = DB::table('branches')->select('id', 'name')->get();
                        foreach ($branches as $key => $branch) {
                            $response .= $key + 1 . ") " . $branch->name . "\n";
                        }

                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 5 && $this->userinput != '0') {
                        $pob = $inputArray[3];
                        $this->searchPoboxAndSave($pob);

                    } elseif (in_array(count($inputArray), [3, 4, 5]) && $this->userinput == '0') {
                        $this->goBack();
                        $this->pobox_menu();
                    } else {
                        $response = "Invalid choice. Please try again. \n";
                        $this->ussd_stop($response);
                    }

                    break;

                default:
                    $response = "Invalid choice. Please try again. \n";
                    $this->ussd_stop($response);
                    break;
            }

        }

    }

    // public function home_menu()
    // {
    //     $response = "";
    //     $response .= "Welcome to Iposita online Services \n";
    //     $response .= "1) Buy Electricity \n";
    //     $response .= "2) Buy Airtime \n";
    //     $response .= "3) P.O Box Services \n";
    //     $this->ussd_proceed($response);
    // }
    public function pobox_menu()
    {
        $response = "";
        $response .= "1) Rent P.O Box \n";
        $response .= "2) P.O Box Certificate \n";
        $response .= "3) Chech P.O Box \n";
        $response .= "4) P.O Box Registration \n";
        $response .= "0) Go Back \n";
        $this->ussd_proceed($response);
    }
    public function my_pobox_menu()
    {
        $my_poboxes = UccdPoboxClient::where('phone', $this->phoneNumber)->get();
        if ($my_poboxes->isEmpty()) {
            $response = "You don't have any registed P.O Box\n";

        } else {
            $response = "Select P.O Box\n";
            foreach ($my_poboxes as $key => $value) {
                $response .= $key + 1 . ") B.P " . $value->box->pob . " " . $value->box->branch->name . "\n";
            }
        }

        $response .= "0) Go Back \n";

        $this->ussd_proceed($response);
    }
    public function my_pobox_selected($choice)
    {
        $my_poboxes = UccdPoboxClient::where('phone', $this->phoneNumber)->get();
        foreach ($my_poboxes as $key => $value) {
            if ($key == $choice - 1) {
                $pobox = $value->box;
            }
        }
        return $pobox;
    }
    public function electricity_menu()
    {
        $response = "Please choose:\n";
        $response .= "1) Enter meter number\n";
        $response .= "2) Select a saved meter\n";
        $response .= "0) Go Back \n";
        $this->ussd_proceed($response);
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
    private function selectedBranch($choice)
    {
        $branches = DB::table('branches')->select('id', 'name')->get();
        if ($choice >= 1 && $choice <= $branches->count()) {

            foreach ($branches as $key => $branch) {
                if ($key == $choice - 1) {
                    $branch_id = $branch->id;
                    $branch_name = $branch->name;
                }
            }
            return ['success' => true, 'branch_id' => $branch_id, 'branch_name' => $branch_name];
        } else {
            return ['success' => false];
        }
    }
    private function savedPobox($choice)
    {
        $my_poboxes = UccdPoboxClient::where('phone', $this->phoneNumber)->get();

        if ($choice >= 1 && $choice <= $my_poboxes->count()) {
            foreach ($my_poboxes as $key => $value) {
                if ($key == $choice - 1) {
                    $pobox = $value->box->pob;
                }
            }
            return ['success' => true, 'pobox' => $pobox];
        } else {
            return ['success' => false];
        }
    }
    private function searchPobox($pob)
    {
        $fetch = $this->selectedBranch($this->userinput);
        if ($fetch['success']) {
            $branch_id = $fetch['branch_id'];
            $branch_name = $fetch['branch_name'];

            $box = Box::where('branch_id', $branch_id)->where('pob', $pob)->first();

            if ($box) {
                return ['status' => 1, 'name' => $box->name];
            } else {
                return ['status' => 2, 'branch' => $branch_name];
            }
        } else {
            return ['status' => 3];
        }
    }
    private function searchPoboxAndSave($pob)
    {
        $phoneWithoutCode = substr($this->phoneNumber, 2);

        $fetch = $this->selectedBranch($this->userinput);
        if ($fetch['success']) {
            $branch_id = $fetch['branch_id'];
            $branch_name = $fetch['branch_name'];

            $box = Box::where(function ($query) use ($phoneWithoutCode) {
                $query->where('phone', $this->phoneNumber)->orWhere('phone', $phoneWithoutCode);
            })->where('branch_id', $branch_id)->where('pob', $pob)->first();

            if ($box) {
                UccdPoboxClient::where('phone', $this->phoneNumber)->where('box_id', $box->id)
                    ->firstOrCreate(['phone' => $this->phoneNumber, 'box_id' => $box->id]);
                $response = "P.O Box registered successfully";
                $this->ussd_proceed($response);
            } else {
                $response = "There is no P.O Box in $branch_name registered to your phone number";
                $this->ussd_stop($response);
            }
        } else {
            $response = "Invalid choice. Please try again. \n";
            $this->ussd_stop($response);
        }
    }

}
