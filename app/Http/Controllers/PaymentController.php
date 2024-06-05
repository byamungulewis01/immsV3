<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    function index()
    {
        return view('home.payment');
    }
    function callback()
    {
        return view('home.payment_cancel');
    }
    function webhook()
    {
        Payment::create(['phone' => 2222, 'transaction_id' => time()]);
    }
    function store_payment(Request $request)
    {
        $xmlData = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
        <API3G>
        <CompanyToken>" . env('COMPANY_TOKEN') . "</CompanyToken>
        <Request>createToken</Request>
        <Transaction>
        <PaymentAmount>$request->amount</PaymentAmount>
        <PaymentCurrency>RWF</PaymentCurrency>
        <CompanyRef>49FKEOA</CompanyRef>
        <RedirectURL>" . route('payment_test.index') . "</RedirectURL>
        <BackURL>" . route('payment_test.callback') . " </BackURL>
        <CompanyRefUnique>0</CompanyRefUnique>
        <PTL>5</PTL>
        </Transaction>
        <Services>
         <Service>
           <ServiceType>" . env('SERVICE_TYPE') . "</ServiceType>
           <ServiceDescription>Electricity payments</ServiceDescription>
           <ServiceDate>". date('Y/m/d H:i:s') ."</ServiceDate>
         </Service>
        </Services>
        </API3G>";

        $response = $this->sendCurlRequest($xmlData);

        $xml = simplexml_load_string($response);

        $resultCode = (string) $xml->Result;
        $transToken = (string) $xml->TransToken;
        if ($resultCode === "000") {
            $xmlData2 = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                <API3G>
                   <CompanyToken>" . env('COMPANY_TOKEN') . "</CompanyToken>
                   <Request>ChargeTokenMobile</Request>
                   <TransactionToken>$transToken</TransactionToken>
                   <PhoneNumber>$request->phone</PhoneNumber>
                   <MNO>mtn</MNO>
                   <MNOcountry>rwanda</MNOcountry>
                </API3G>";

                $response2 = $this->sendCurlRequest($xmlData2);
                dd($response2);
        }

    }
    public function sendCurlRequest($xmlData)
    {

        $endpoint = "https://secure.3gdirectpay.com/API/v6/";
        $ch = curl_init();

        if (!$ch) {
            die("Couldn't initialize a cURL handle");
        }
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);

        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }
}
