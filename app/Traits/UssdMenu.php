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
        $rentYearNumber = now()->year - $box->year;
        $totalRent = $box->amount * $rentYearNumber;
        $response = "Select option to pay";
        if (now()->month == 1 && now()->day <= 31):
            if ($box->year >= now()->year):
                $pernaty = 0;
                $response = "1) Rent " . $box->year + 1 . " - " . $box->amount;
            else:
                $pernaty = now()->year - ($box->year - 1);
                $response = "1) Rent " . $box->year + 1 . " - " . $box->amount + ($box->amount * 0.25);
                $response .= "\n 2) Pay All " . $totalRent + ($box->amount * 0.25 * $pernaty);

            endif;
        else:
            $pernaty = now()->year - $box->year;
            if ($box->year >= now()->year):
                $response = "1) Rent " . $box->year + 1 . " - " . $box->amount;
            else:
                $response = "1) Rent " . $box->year + 1 . " - " . $box->amount + ($box->amount * 0.25);
                $response .= "\n 2) Pay All " . $totalRent + ($box->amount * 0.25 * $pernaty);
            endif;
        endif;
        $response .= "\n 0)Go Back\n";

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
