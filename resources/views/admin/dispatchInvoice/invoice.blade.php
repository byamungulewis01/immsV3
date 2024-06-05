<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid black;
      padding: 8px;
    }

    th {
      text-align: left;
    }
    /* Align social media icons at the bottom */
    .social-media {
      position: fixed;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <p style="font-size: 14px; font-weight: bold;">REPUBLIC OF RWANDA<br>
    NATIONAL POSTS OFFICE<br>
    <img src="{{ public_path('img/logo.png')  }}"
    alt="Logon" width="120" height="70">
    <br>
    B.P 4 KIGALI, TEL +250783626253 <br>
    E-mail:info@i-posita.rw <br>
    Website: www.i-posita.rw <br>
    Our TIN/VAT is 100021341 <br>
  </p>
  <p style="font-size: 12px; font-weight: bold;">
   INVOICE PROFORMA N<sup><u>o</u></sup> : {{ $invoice->invoice_number }} <br>
   DATE OF ISSUE : {{ Carbon\Carbon::parse($invoice->created_at)->format('d M, Y') }} <br>
  </p>


  <table>
        <tr class="table-active">
            <th style="width: 50px;">#</th>
            <th>Reference</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Qte</th>
            <th>Amount</th>
        </tr>
        @foreach ($mails as $mail)
        <tr>
        <td><strong>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</strong></td>
        <td>{{  $invoice->invoice_number }}</td>
        <td>{{ $mail->details->destination->address }}</td>
        <td>{{ $mail->dateReceived }}</td>
        <td>1.00</td>
        <td>{{ $mail->price }}</td>
        </tr>
        @endforeach
</table><!--end table-->

    {{-- <hr> --}}
  {{-- <p>
    <b>Yvette KAMANZI</b> <br>
    <b>Branch Manager</b> <br><br>
    Payment should be made to the following accounts: <br>

    &nbsp;&nbsp;&nbsp; - &nbsp; National Bank of Rwanda (NBR): 100 00 10 487/ Frw <br>
    &nbsp;&nbsp;&nbsp; - &nbsp; Bank of Kigali (BK): 00040-00045362-96/Frw <br> <br>
- <b>N.B:</b> The renewal of PO BOX is made from January 02<sup>nd</sup> of every year until 31 January at
the normal tariff. Beyond this deadline, any renewal may be increased of a fine of
25% of the usual subscription tariff.


  </p> --}}



</body>
</html>

