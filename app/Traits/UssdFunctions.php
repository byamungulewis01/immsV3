<?php
namespace App\Traits;

use App\Models\Box;
use App\Models\UssdMeterHistory;
use App\Models\UssdSession;
use Illuminate\Support\Facades\DB;

trait UssdFunctions
{
    public function ussd_proceed($response)
    {
        header('FreeFlow: FC');
        header('Content-type: text/plain');
        echo $response;
    }

    public function ussd_stop($response)
    {
        header('FreeFlow: FB');
        header('Content-type: text/plain');
        echo $response;
    }
    public function goBack()
    {
        $session = UssdSession::where('phone', $this->phoneNumber)->where('session_id', $this->sessionId)->first();
        $user_input = substr($session->user_input, 0, -4);
        $session->update(['user_input' => $user_input]);
        return true;
    }
    public function check_session()
    {
        $check = UssdSession::where('phone', $this->phoneNumber)->where('session_id', $this->sessionId)->first();
        if ($check) {
            $check->update(['user_input' => $check->user_input . '*' . $this->userInput]);
            return $check->user_input;
        } else {
            $new = UssdSession::create(['phone' => $this->phoneNumber,
                'session_id' => $this->sessionId,
                'user_input' => $this->userInput,
            ]);
            return $new->user_input;
        }

    }
    public function latest_meter()
    {
        $saveMeter = UssdMeterHistory::where('phone', $this->phoneNumber)->latest()->first();
        return $saveMeter;
    }
    public function my_pobox()
    {
        $phoneWithoutCode = substr($this->phoneNumber, 2);
        $box = Box::where('phone', $this->phoneNumber)->orWhere('phone', $phoneWithoutCode)->first();
        return $box;
    }
    public function search_pobox($pob, $branch_label)
    {
        $branches = DB::table('branches')->select('id', 'name')->get();

        foreach ($branches as $key => $branch) {
            if ($key == $branch_label - 1) {
                $branch_id = $branch->id;
            }
        }
        $box = Box::where('branch_id', $branch_id)->where('pob', $pob)->first();
        return $box;
    }
    public function branches()
    {
        $branches = DB::table('branches')->select('id', 'name')->get();
        return $branches;
    }
    private function selectedBranch($pob)
    {

        $branches = DB::table('branches')->select('id', 'name')->get();
        if ($this->userInput >= 1 && $this->userInput <= $branches->count()) {

            foreach ($branches as $key => $branch) {
                if ($key == $this->userInput - 1) {
                    $branch_id = $branch->id;
                }
            }
            $box = Box::where('branch_id', $branch_id)->where('pob', $pob)->first();

            if ($box) {
                $this->rentPobMenu($box);
            } else {
                $response = "P.O box not found. \n";
                $this->ussd_stop($response);
            }

        } else {
            $response = "Invalid choice. Please try again. \n";
            $this->ussd_stop($response);
        }
    }
    private function pobox_amount($box)
    {
        $totalRent = $box->amount * (now()->year - $box->year);
        $pernaty = now()->year - $box->year;
        $total = $totalRent + ($box->amount * 0.25 * $pernaty);
        if ($this->userInput == 1) {

            if (now()->month == 1 && now()->day <= 31):
                if ($box->year >= now()->year):
                    $amount = $box->amount;
                else:
                    $amount = $box->amount + ($box->amount * 0.25);
                endif;
            else:
                if ($box->year >= now()->year):
                    $amount = $box->amount;
                elseif ($box->year == now()->year - 1):
                    $amount = $box->amount + ($box->amount * 0.25);
                else:
                    $amount = $total;
                endif;
            endif;
            return (object) [
                'status' => true,
                'amount' => $amount,
                'year' => $box->year + 1,
            ];
        } elseif ($this->userInput == 2) {
            return (object) [
                'status' => true,
                'amount' => $total,
                'year' => $box->year + 1,
            ];

        } else {
            return (object) [
                'status' => false,
            ];
        }
    }
}
