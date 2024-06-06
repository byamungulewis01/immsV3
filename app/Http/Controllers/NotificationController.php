<?php

namespace App\Http\Controllers;

use App\Mail\NationalInvioceMailer;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    //
    public $message;
    public $phone;
    public $subject;
    public $attachmentPath;

    public function notify_sms($message, $phone)
    {
        $data = [
            'message' => $message,
            'phone' => $phone,
        ];
        $url = "http://smsc.xwireless.net/API/WebSMS/Http/v1.0a/index.php?username=xxxx&password=xxxx&sender=xxxx&to=$phone&message=$message&reqid=1&format={json|text}&route_id=7";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public function nationalMailInvoice($email, $subject, $message, $attachmentPath)
    {
        $data = [
            'subject' => $subject,
            'message' => $message,
            'attachmentPath' => $attachmentPath,
        ];
        Mail::to($email)->send(new NationalInvioceMailer($data));
    }

    public function send_sms($phone, $message)
    {

        // API endpoint
        $url = 'https://afrobulksms.com/api/sent/compose';

        // API parameters
        $fields = array(
            'api_key' => '10|iCcWjf4UcUVi8vrnmZ4jtPVxS1QyOu9kst8sygMRfa6d5d8b',
            'from_number' => 8,
            'from_type' => 'sender_id',
            'sender_id' => 'IPOSITA',
            'to_numbers' => '+25' . $phone,
            'body' => $message,
        );
        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }
    public function intouchsms($phone, $message)
    {
        $data = array(
            "sender" => 'ISMS',
            "recipients" => $phone,
            "message" => $message,
        );

        $url = "https://www.intouchsms.co.rw/api/sendsms/.json";
        $data = http_build_query($data);
        $username = "menyatips";
        $password = "Menyatips14";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $result;
    }
}
