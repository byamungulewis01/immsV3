<!DOCTYPE html>
<html>
<head>
  <title>Post Card Mail Transfer</title>
  <style>
   body {font-family: sans-serif;
	font-size: 10pt;
}
.watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        opacity: 0.3;
        font-size: 30px;
        font-weight: bold;
        color: #CCCCCC;
        z-index: -1;
    }
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { vertical-align: top; }
.items td {
	border-left: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;

}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;


}

 .p3 {
  font-family: "Brush Script MT";
  color:blue;
}

</style>
</head>
<div class="watermark">POSTAL CARD MAIL TRANSFER</div>
<body>
  <p style="font-size: 14px; font-weight: bold;">REPUBLIC OF RWANDA<br>
    NATIONAL POSTS OFFICE<br>
    <img src="{{ public_path('img/logo.png')  }}"
    alt="Girl in a jacket" width="120" height="70">
    <br>
    B.P 4 KIGALI, TEL +250783626253 <br>
    E-mail:info@i-posita.rw <br>
    Website: www.i-posita.rw <br>
    Our TIN/VAT is 100021341 <br>
  </p>
  <h1 style="text-align:center">MAIL TRANSFER FORM NO: MT {{ decrypt($id) }}  </h1>

  <table width="100%">

    @empty($inboxings)
    <h2>Total Mail Transfered ------------  <strong style="color: tomato">{{ $number }}</strong></h2>
    @else
    <thead>
        <tr>
            <th>#</th>
            <th width="15%">MAIL CODE </th>
            <th>NAMES</th>
            <th>PHONE</th>
            <th>DATE</th>
            <th>CHECKING</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($inboxings as $key => $inboxing)
            <tr>
                <th scope="row">
                    {{ $key + 1 }}
                </th>
                <td>{{ $inboxing->innumber }}</a></td>
                <td>{{ $inboxing->inname }}</td>
                <td>{{ $inboxing->phone }}</td>
                <td>{{ $inboxing->created_at }}</td>
                <td></td>

            </tr>
        @endforeach
    </tbody>
    @endempty
</table>
<br>
@php
use Carbon\Carbon;
$date = Carbon::now();
$date->toDateString(); // Outputs the date in the format: YYYY-MM-DD
@endphp


Done a Kigali on {{ $date }}
 <br>
 <br>
<table width="100%">
    <tr>
        <td> <b>PREPARED BY  </b> <br><br>
        NAMES: <B> {{strtoupper(auth()->user()->name) }}</B><br><br>
        Signature ----------------------------------------------<br><br>
        Date -----------------------------------------------------</td>
        <td><b>VERIFIED BY </b> <br><br>
        NAMES ---------------------------------------------------<br><br>
        Signature ----------------------------------------------<br><br>
        Date -----------------------------------------------------</td>
        </tr>
</table>
</body>


</html>

</body>
</html>

