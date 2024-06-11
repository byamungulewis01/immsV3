<?php
namespace App\Traits;

trait UssdMenu
{
    public function home_menu()
    {
        $response = "Welcome to Iposita online Services \n";
        $response .= "1) Buy Electricity \n";
        $response .= "2) Buy Airtime \n";
        $response .= "3) Rent P.O Box \n";
        $response .= "4) P.O Box Certificate \n";
        $response .= "5) Chech P.O Box \n";
        $this->ussd_proceed($response);
    }
    public function rentPobOptionsMenu()
    {
        $pobox = $this->my_pobox();
        if ($pobox) {
            $response = "Please select P.O box\n";
            $response .= "1)$pobox->pob " . $pobox->branch->name . "\n";
            $response .= "2)Enter Another P.O Box number\n";
            $response .= "0)Go Back\n";
        } else {
            $response = "Enter P.O Box number\n";
        }
        $this->ussd_proceed($response);
    }
    public function rentPobMenu($box)
    {

        $response = "Select option to pay \n";
        $totalRent = $box->amount * (now()->year - $box->year);
        $pernaty = now()->year - $box->year;
        $total = $totalRent + ($box->amount * 0.25 * $pernaty);

        if (now()->month == 1 && now()->day <= 31):
            if ($box->year >= now()->year):
                $response .= "1) Rent(" . $box->year + 1 . ") " . $box->amount . " RWF";
            elseif ($box->year == now()->year - 1):
                $response .= "1) Rent(" . $box->year + 1 . ") " . $box->amount . " RWF";
            else:
                $response .= "1) Rent(" . $box->year + 1 . ") " . $box->amount + ($box->amount * 0.25) . " RWF";
                $response .= "\n 2) Pay All " . $total . " RWF";
            endif;
        else:
            if ($box->year >= now()->year):
                $response .= "1) Rent(" . $box->year + 1 . ") " . $box->amount . " RWF";
            elseif ($box->year == now()->year - 1):
                $response .= "1) Rent(" . $box->year + 1 . ") " . $box->amount + ($box->amount * 0.25) . " RWF";
            else:
                $response .= "1) Rent(" . $box->year + 1 . ") " . $box->amount + ($box->amount * 0.25) . " RWF";
                $response .= "\n 2) Pay All(" . $box->year + 1 . "-" . now()->year . ") " . $total . " RWF";
            endif;
        endif;
        // $response .= "\n 0)Go Back\n";

        // $total = $totalRent + $box->amount * 0.25 * $pernaty;
        $this->ussd_proceed($response);
    }
    public function certPobMenu()
    {
        $response = "P.O Box Certifacate (5000 FRW)\n";
        $response .= "1) To pay certificate \n";
        // $total = $totalRent + $box->amount * 0.25 * $pernaty;
        $this->ussd_proceed($response);
    }
    public function branches_menu()
    {
        $response = "Choose P.O Box Branch \n";

        $branches = $this->branches();
        foreach ($branches as $key => $branch) {
            $response .= $key + 1 . ") " . $branch->name . "\n";
        }
        $this->ussd_proceed($response);
    }

}
