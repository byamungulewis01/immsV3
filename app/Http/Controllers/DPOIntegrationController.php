<?php

namespace App\Http\Controllers;

use Zepson\Dpo\Dpo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DPOIntegrationController extends Controller
{
    //
    public function index()
    {
        return view('dpo-integration.index');
    }
    public function success()
    {
        return 'success';
    }
    public function fail()
    {
        return 'fail';
    }
    public function store(Request $request)
    {
        // $date = date('Y/m/d H:i:s');
        $data = [
            'paymentAmount' => $request->amount,
            'paymentCurrency' => "RWF",
            'customerFirstName' => "BYAMUNGU",
            'customerLastName' => "Lewis",
            'customerAddress' => "Kigali",
            'customerCity' => "Kigali",
            'customerPhone' => "078543135",
            'customerEmail' => "byamungulewis@gmail.com",
            'companyRef' => "49FKEOA",
        ];

        $dpo = new Dpo;
        $token = $dpo->createToken($data);
        $payment_url = $dpo->getPaymentUrl($token);

        return Redirect::to($payment_url);

        // return $dpo->directPayment($order); // this will redirect user to DPO Payment page

        // $transaction = $this->createTokenApi($request->amount);
        // return $this->chargeMobile($transaction, "0785436135");
    }
    public function generateXmlData($amount)
    {
        $date = date('Y/m/d H:i:s');
        // XML data string
        $xmlData = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
            <API3G>
            <CompanyToken>" . env('COMPANY_TOKEN') . "</CompanyToken>
            <Request>createToken</Request>
            <Transaction>
            <PaymentAmount>$amount</PaymentAmount>
            <PaymentCurrency>RWF</PaymentCurrency>
            <CompanyRef>49FKEOA</CompanyRef>
            <RedirectURL>http://www.domain.com/payurl.php</RedirectURL>
            <BackURL>http://www.domain.com/backurl.php </BackURL>
            <CompanyRefUnique>0</CompanyRefUnique>
            <PTL>5</PTL>
            </Transaction>
            <Services>
                <Service>
                <ServiceType>" . env('SERVICE_TYPE') . "</ServiceType>
                <ServiceDescription>Electricity payments</ServiceDescription>
                <ServiceDate>$date</ServiceDate>
                </Service>
            </Services>
            </API3G>";
        return $xmlData;
    }
    public function createTokenApi($amount)
    {
        $endpoint = "https://secure.3gdirectpay.com/API/v6/";
        $xmlData = $this->generateXmlData($amount);
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

        $xmlResponse = simplexml_load_string($result);

        // Access the TransToken element
        $transtoken = (string) $xmlResponse->TransToken;

        return $transtoken;
    }

    public function chargeTokenXmlData($transtoken, $phone)
    {

        $xmlData = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                    <API3G>
                        <CompanyToken>" . env('COMPANY_TOKEN') . "</CompanyToken>
                        <Request>ChargeTokenMobile</Request>
                        <TransactionToken>$transtoken</TransactionToken>
                        <PhoneNumber>$phone</PhoneNumber>
                        <MNO>mtn</MNO>
                        <MNOcountry>rwanda</MNOcountry>
                    </API3G>";
        return $xmlData;
    }
    public function chargeMobile($transtoken, $phone)
    {

        $xmlData = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                    <API3G>
                        <CompanyToken>" . env('COMPANY_TOKEN') . "</CompanyToken>
                        <Request>ChargeTokenMobile</Request>
                        <TransactionToken>$transtoken</TransactionToken>
                        <PhoneNumber>$phone</PhoneNumber>
                        <MNO>mtn</MNO>
                        <MNOcountry>rwanda</MNOcountry>
                    </API3G>";


                    $ch = curl_init();

                    if (!$ch) {
                        die("Couldn't initialize a cURL handle");
                    }
                    curl_setopt($ch, CURLOPT_URL, "https://secure.3gdirectpay.com/API/v6/");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);

                    $result = curl_exec($ch);

                    curl_close($ch);

                    $xmlResponse = simplexml_load_string($result);

                    return $xmlResponse;

    }
}
