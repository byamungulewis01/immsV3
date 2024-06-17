<?php

namespace App\Http\Controllers;

use App\Traits\UssdMenu;
use App\Models\UssdLanguege;
use App\Traits\UssdPayments;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Traits\UssdFunctions;
use App\Models\UssdMeterHistory;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\NotificationController;

class UssdController extends Controller
{
    use UssdMenu, UssdFunctions, UssdPayments;
    public $sessionId;
    public $phoneNumber;
    public $userInput;
    public $language;
    public function ussd(Request $request)
    {
        $this->sessionId = $request->sessionId;
        $this->phoneNumber = $request->msisdn;
        $this->userInput = $request->text;
        $serviceCode = $request->serviceCode;
        $networkCode = $request->networkCode;

        $lang = UssdLanguege::where('phone', $this->phoneNumber)->first();
        $this->language = $lang ? $lang->name : 'english';

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
                        if ($this->language == 'english') {
                            $choose = "Choose a meter\n";
                            $orWrite = "Or write a new meter\n";
                            $meterwr = "write meter number\n";
                        } else {
                            $choose = "Hitamo Cashpower yawe\n";
                            $orWrite = "Cywangwa andika Cashpower yawe\n";
                            $meterwr = "Andika Cashpower yawe\n";
                        }
                        if ($latest_meter) {
                            $response = $choose;
                            $response .= "1)$latest_meter->meter_number \n";
                            $response .= $orWrite;
                        } else {
                            $response = $meterwr;
                        }
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 3) {
                        if ($this->userInput == 1) {
                            $latest_meter = $this->latest_meter();
                            if ($this->language == 'english') {
                                $nameOf = "Name on Meter";
                                $amountEx = "Enter amount (min. 500 RWF)";
                            } else {
                                $nameOf = "Amazina :";
                                $amountEx = "Andika Amafaranga (amake ni 500 RWF)";
                            }

                            $response = "$nameOf : $latest_meter->meter_name \n";
                            $response .= "$amountEx : " . "\n";

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

                                    if ($this->language == 'english') {
                                        $nameOf = "Name on Meter";
                                        $amountEx = "Enter amount (min. 500 RWF)";
                                    } else {
                                        $nameOf = "Amazina";
                                        $amountEx = "Andika Amafaranga (amake ni 500 RWF)";
                                    }

                                    $response = "$nameOf : $meter_name" . "\n";
                                    $response .= "$amountEx :  " . "\n";
                                    $this->ussd_proceed($response);
                                } elseif ($status == 2) {
                                    if ($this->language == 'english') {
                                        $response = "Meter not found. Please check your meter number \n";
                                    } else {
                                        $response = "Numero ntibonetse, reba nimero yawe neza \n";
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
                                    $response = "Meter should be numeric. Please try again. \n";
                                } else {
                                    $response = "Numero igomba kuba imibare gusa, ongera ugerageze \n";
                                }
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
                    if ($this->language == 'english') {
                        $response = "Buying Aitime\n";
                        $response .= "\n 1)Buy for your self";
                        $response .= "\n 2)Buy for  Another";
                    } else {
                        $response = "Kugura Amainite \n";
                        $response .= "\n 1)Kwigurira";
                        $response .= "\n 2)Kugurira undi";
                    }

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
                            if ($this->language == 'english') {
                                $response = "Enter P.O Box number\n";
                            } else {
                                $response = "Andika numero yakabati\n";
                            }
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
                                if ($this->language == 'english') {
                                    $response = "Invalid choice. Please try again. \n";
                                } else {
                                    $response = "Uhisemo nabi! ongera nanone";
                                }
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
                                if ($this->language == 'english') {
                                    $response = "Invalid choice. Please try again. \n";
                                } else {
                                    $response = "Uhisemo nabi! ongera nanone";
                                }

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
                            if ($this->language == 'english') {
                                $response = "Invalid choice. Please try again. \n";
                            } else {
                                $response = "Uhisemo nabi! ongera nanone";
                            }
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
                            if ($this->language == 'english') {
                                $response = "Enter P.O Box number\n";
                            } else {
                                $response = "Andika numero yakabati\n";
                            }
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
                            if ($this->language == 'english') {
                                $response = "You don't have any registed P.O Box\n";
                            } else {
                                $response = "Nta P.O Box ikwanditseho\n";
                            }
                        } else {
                            if ($this->language == 'english') {
                                $response = "Select P.O Box\n";
                            } else {
                                $response = "Hitamo P.O Box\n";
                            }
                            $response .= "1) B.P " . $this->my_pobox()->pob . " " . $this->my_pobox()->branch->name . "\n";
                        }
                        if ($this->language == 'english') {
                            $response .= "0) Go Back \n";
                        } else {
                            $response .= "Subira inyuma\n";
                        }
                        $this->ussd_proceed($response);
                    } elseif (count($inputArray) == 3) {
                        if ($this->userInput == 0) {
                            $this->goBack();
                            $this->home_menu();
                        } elseif ($this->my_pobox() && $this->userInput == 1) {
                            $inboxings = Inboxing::where('pob', $this->my_pobox()->pob)->where('instatus', '4')->get();

                            if ($inboxings->count() > 0) {
                                if ($this->language == 'english') {
                                    $response = "You have mail shortly you will get SMS for more details";
                                } else {
                                    $response = "Ufite ubutumwa, urabona SMS ibugaragaza";
                                }
                                $message = "IPOSITA informs you that you have an item to pick at \n\n";
                                foreach ($inboxings as $value) {
                                    if ($value->mailtype == 'ems') {
                                        $guichet = "Guichet:8";
                                    } elseif ($value->mailtype == 'p') {
                                        $guichet = "Guichet:6";
                                    } else {
                                        $guichet = "Guichet:4";
                                    }
                                    $message .= $guichet . " code:$value->innumber";
                                }

                                $hashids = new \Hashids\Hashids(env('HASHIDS_SALT'), 8); // minimum length of 8 characters
                                $hash = $hashids->encode($this->my_pobox()->pob);
                                // $userId = $hashids->decode($hash);

                                $message .= "\n If you need home delivery service,please call this number 0789499177";
                                $message .= "\n view details here: " . route('inboxings_mails',$hash);

                                $phone = substr($this->phoneNumber, 2);
                                (new NotificationController)->send_sms($phone, $message);
                            } else {
                                if ($this->language == 'english') {
                                    $response = "Seems like you don't have any mail";
                                } else {
                                    $response = "Nta butumwa ufitemo";
                                }
                            }
                        } else {
                            $response = "Invalid choice. Please try again. \n";
                        }
                        $this->ussd_stop($response);

                    }
                    break;

                case '6':
                    $lang = UssdLanguege::where('phone', $this->phoneNumber)->first();
                    if ($lang) {

                        $newLang = $lang->name == 'english' ? 'kinyarwanda' : 'english';
                        $lang->update(['name' => $newLang]);
                        $this->language = $newLang;
                    } else {
                        UssdLanguege::create(['phone' => $this->phoneNumber, 'name' => 'kinyarwanda']);
                        $this->language = 'kinyarwanda';
                    }
                    $this->goHome();
                    $this->home_menu();
                    break;

                default:
                    $response = "Invalid choice. Please try again. \n";
                    $this->ussd_stop($response);
                    break;
            }

        }

    }

}
