<?php
namespace App\Traits;

trait UssdMenu
{
    public function home_menu()
    {
        if ($this->language == 'english') {
            # code...
            $lang = $this->language;
            $response = "Welcome to Iposita online Services $lang \n";
            $response .= "1) Buy Electricity \n";
            $response .= "2) Buy Airtime \n";
            $response .= "3) Rent P.O Box \n";
            $response .= "4) P.O Box Certificate \n";
            $response .= "5) Chech P.O Box \n";
            $response .= "6) Hindura Ururimi \n";
        } else {
            # code...
            $lang = $this->language;

            $response = "Ikaze kuri serivise z'Iposita $lang \n";
            $response .= "1) Kugura Umuriro \n";
            $response .= "2) Kugura Amainite \n";
            $response .= "3) Kwishura Ubukode (P.O Box) \n";
            $response .= "4) Icyangobwa cya Seritifika\n";
            $response .= "5) Kureba ubutumwa \n";
            $response .= "6) Change Language\n";
        }

        $this->ussd_proceed($response);
    }
    public function rentPobOptionsMenu()
    {
        $pobox = $this->my_pobox();
        if ($pobox) {
            if ($this->language == 'english') {
                $response = "Please select P.O box\n";
                $response .= "1)$pobox->pob " . $pobox->branch->name . "\n";
                $response .= "2)Enter Another P.O Box number\n";
                $response .= "0)Go Back\n";
            } else {
                $response = "Hitamo Akabati kawe\n";
                $response .= "1)$pobox->pob " . $pobox->branch->name . "\n";
                $response .= "2)Andika umubare wakabati kawe\n";
                $response .= "0)Gusubira inyuma \n";
            }
        } else {
            if ($this->language == 'english') {
                $response = "Enter P.O Box number\n";
            } else {
                $response = "Andika numurero ya meter yiwe\n";
            }
        }
        $this->ussd_proceed($response);
    }
    public function rentPobMenu($box)
    {
        if ($this->language == 'english') {
            $response = "Select option to pay \n";
            $rent = "Rent";
            $all = "Pay All";
        } else {
            $response = "Hitamo ayo wishyure \n";
            $rent = "Ubukode";
            $all = "Ishura yose";
        }
        $response = "Select option to pay \n";
        $totalRent = $box->amount * (now()->year - $box->year);
        $pernaty = now()->year - $box->year;
        $total = $totalRent + ($box->amount * 0.25 * $pernaty);

        if (now()->month == 1 && now()->day <= 31):
            if ($box->year >= now()->year):
                $response .= "1) $rent(" . $box->year + 1 . ") " . $box->amount . " RWF";
            elseif ($box->year == now()->year - 1):
                $response .= "1) $rent(" . $box->year + 1 . ") " . $box->amount . " RWF";
            else:
                $response .= "1) $rent(" . $box->year + 1 . ") " . $box->amount + ($box->amount * 0.25) . " RWF";
                $response .= "\n 2) $all " . $total . " RWF";
            endif;
        else:
            if ($box->year >= now()->year):
                $response .= "1) $rent(" . $box->year + 1 . ") " . $box->amount . " RWF";
            elseif ($box->year == now()->year - 1):
                $response .= "1) $rent(" . $box->year + 1 . ") " . $box->amount + ($box->amount * 0.25) . " RWF";
            else:
                $response .= "1) $rent(" . $box->year + 1 . ") " . $box->amount + ($box->amount * 0.25) . " RWF";
                $response .= "\n 2) $all(" . $box->year + 1 . "-" . now()->year . ") " . $total . " RWF";
            endif;
        endif;
        // $response .= "\n 0)Go Back\n";

        // $total = $totalRent + $box->amount * 0.25 * $pernaty;
        $this->ussd_proceed($response);
    }
    public function certPobMenu()
    {
        if ($this->language == 'english') {
            $response = "P.O Box Certifacate (5000 FRW)\n";
            $response .= "1) To pay certificate \n";
        }else{
            $response = "P.O Box Seritifika (5000 FRW)\n";
            $response .= "1) Emeza Kwishyura \n";
        }

        // $total = $totalRent + $box->amount * 0.25 * $pernaty;
        $this->ussd_proceed($response);
    }
    public function branches_menu()
    {
        if ($this->language == 'english') {
            $response = "Choose P.O Box Branch \n";
        }else{
            $response = "Hitamo ishami \n";
        }

        $branches = $this->branches();
        foreach ($branches as $key => $branch) {
            $response .= $key + 1 . ") " . $branch->name . "\n";
        }
        $this->ussd_proceed($response);
    }

}
