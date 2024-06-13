<?php

namespace App\Http\Controllers;

use App\Traits\UssdMenu;
use App\Traits\UssdPayments;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Traits\UssdFunctions;
use App\Models\UssdMeterHistory;
use App\Http\Controllers\NotificationController;

class UssdController extends Controller
{
    use UssdMenu, UssdFunctions, UssdPayments;
    public $sessionId;
    public $phoneNumber;
    public $userInput;
    public function ussd(Request $request)
    {
        $this->sessionId = $request->sessionId;
        $this->phoneNumber = $request->msisdn;
        $this->userInput = $request->text;
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
                        $latest_meter = $this->latest_meter();
                        if ($latest_meter) {
                            $response = "Choose a meter\n";
                            $response .= "1)$latest_meter->meter_number \n";
                            $response .= "Or write a new meter\n";
                        } else {
                            $response = "write meter number\n";
                        }
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 3) {
                        if ($this->userInput == 1) {
                            $latest_meter = $this->latest_meter();
                            $response = "Name on Meter : $latest_meter->meter_name \n";
                            $response .= "Enter amount (min. 500 RWF):  " . "\n";

                            $this->ussd_proceed($response);

                        } else {
                            if (is_numeric($this->userInput)) {
                                $output = (new EUCLUssdController())->check_meter($this->userInput);
                                $status = $output['status'];
                                if ($status == 1) {
                                    $meter_name = $output['meter_name'];

                                    UssdMeterHistory::where('phone', $this->phoneNumber)->where('meter_number', $this->userInput)->firstOrCreate([
                                        'phone' => $this->phoneNumber,
                                        'meter_number' => $this->userInput,
                                        'meter_name' => $meter_name,
                                    ]);

                                    $response = "Name on meter : $meter_name" . "\n";
                                    $response .= "Enter amount (min. 500 RWF):  " . "\n";
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
                        }
                    } elseif (count($inputArray) == 4) {

                        if ($inputArray[2] == 1) {
                            $meter_number = $this->latest_meter()->meter_number;
                        } else {
                            $meter_number = $inputArray[2];
                        }
                        $this->pay_electricity($meter_number);
                        // $this->ussd_proceed($meter_number);
                    }
                    break;

                case "2":
                    // Buy Airtime
                    $response = "Buying Aitime\n";
                    $response .= "\n 1)Buy for your self";
                    $response .= "\n 2)Buy for  Another";

                    $this->ussd_stop($response);
                    break;

                case "3":
                    if (count($inputArray) == 2) {
                        $this->rentPobOptionsMenu();
                    } elseif (count($inputArray) == 3) {
                        if ($this->my_pobox() && $this->userInput == 1) {
                            $box = $this->my_pobox();
                            $this->rentPobMenu($box);
                        } elseif ($this->my_pobox() && $this->userInput == 2) {
                            $response = "Enter P.O Box number\n";
                            $this->ussd_proceed($response);
                        } elseif ($this->my_pobox() && $this->userInput == 0) {
                            $this->goBack();
                            $this->home_menu();
                        } else {
                            $this->branches_menu();
                        }
                    } elseif (count($inputArray) == 4) {
                        if ($this->userInput == 0) {
                            $this->goBack();
                            $this->rentPobOptionsMenu();
                        } elseif ($this->my_pobox() && $inputArray[2] == 1) {

                            $box = $this->my_pobox();
                            $data = $this->pobox_amount($box);
                            if (!$data->status) {
                                $response = "Invalid choice. Please try again. \n";
                                $this->ussd_stop($response);
                            } else {
                                $this->pay_pobox_rent($data, $box);
                            }

                        } elseif ($this->my_pobox() && $inputArray[2] == 2) {
                            $this->branches_menu();
                        } else {
                            $pobox = $inputArray[2];
                            $this->selectedBranch($pobox);
                        }

                    } elseif (count($inputArray) == 5) {
                        if ($this->my_pobox()) {
                            $pobox = $inputArray[3];
                            $this->selectedBranch($pobox);
                        } else {
                            $pobox = $inputArray[2];
                            $branch = $inputArray[3];
                            $box = $this->search_pobox($pobox, $branch);
                            $data = $this->pobox_amount($box);

                            if (!$data->status) {
                                $response = "Invalid choice. Please try again. \n";
                                $this->ussd_stop($response);
                            } else {
                                $this->pay_pobox_rent($data, $box);
                            }
                        }
                    } elseif (count($inputArray) == 6) {
                        $pobox = $inputArray[3];
                        $branch = $inputArray[4];
                        $box = $this->search_pobox($pobox, $branch);
                        $data = $this->pobox_amount($box);
                        if (!$data->status) {
                            $response = "Invalid choice. Please try again. \n";
                            $this->ussd_stop($response);
                        } else {
                            $this->pay_pobox_rent($data, $box);
                        }
                    }
                    break;
                case "4":
                    if (count($inputArray) == 2) {
                        $this->rentPobOptionsMenu();
                    } elseif (count($inputArray) == 3) {
                        if ($this->my_pobox() && $this->userInput == 1) {
                            $this->certPobMenu();
                        } elseif ($this->my_pobox() && $this->userInput == 2) {
                            $response = "Enter P.O Box number\n";
                            $this->ussd_proceed($response);
                        } elseif ($this->my_pobox() && $this->userInput == 0) {
                            $this->goBack();
                            $this->home_menu();
                        } else {
                            $this->branches_menu();
                        }
                    } elseif (count($inputArray) == 4) {
                        if ($this->userInput == 0) {
                            $this->goBack();
                            $this->rentPobOptionsMenu();
                        } elseif ($this->my_pobox() && $inputArray[2] == 1) {
                            $box = $this->my_pobox();
                            $this->pay_pobox_cert($box);
                        } elseif ($this->my_pobox() && $inputArray[2] == 2) {
                            $this->branches_menu();
                        } else {
                            $this->certPobMenu();
                        }

                    } elseif (count($inputArray) == 5) {
                        if ($this->my_pobox()) {
                            $this->certPobMenu();
                        } else {
                            $pobox = $inputArray[2];
                            $branch = $inputArray[3];
                            $box = $this->search_pobox($pobox, $branch);
                            $this->pay_pobox_cert($box);
                        }
                    } elseif (count($inputArray) == 6) {
                        $pobox = $inputArray[3];
                        $branch = $inputArray[4];
                        $box = $this->search_pobox($pobox, $branch);
                        $this->pay_pobox_cert($box);
                    }
                    break;

                case '5':
                    if (count($inputArray) == 2) {
                        if (!$this->my_pobox()) {
                            $response = "You don't have any registed P.O Box\n";
                        } else {
                            $response = "Select P.O Box\n";
                            $response .= "1) B.P " . $this->my_pobox()->pob . " " . $this->my_pobox()->branch->name . "\n";
                        }
                        $response .= "0) Go Back \n";
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 3) {
                        if ($this->userInput == 0) {
                            $this->goBack();
                            $this->home_menu();
                        } elseif ($this->my_pobox() && $this->userInput == 1) {
                            $inboxing = Inboxing::where('pob', $this->my_pobox()->pob)->where('instatus', '4')->latest()->first();
                            if ($inboxing) {
                                $response = "You have mail shortly you will get SMS for more details";
                                $message = "IPOSITA informs you that you have an item to pick at Guichet:8 code:$inboxing->innumber If you need home delivery service,please call this number 0789499177";
                                $phone = substr($this->phoneNumber, 2);
                                (new NotificationController)->send_sms($phone, $message);
                            } else {
                                $response = "Seems like you don't have any mail";
                            }
                        } else {
                            $response = "Invalid choice. Please try again. \n";
                        }
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

}
