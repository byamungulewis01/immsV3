
<html>
<head>

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
<body>
 @foreach ($pays as $key => $pay)
<img src="{{ public_path('img/emslogo.jpg')  }}" alt="" width="300" height="90">
                                                   <b>RWANDA EXPRESS<b><br>
                                                    <center>NO {{ $out_id }}</center>

  <center><u><h2>DEPPOT RECEIPT OF AN EMS SHIPMENT</h2><u></center><br>

<p>SENDER:  {{ $pay->snames }}, {{ $pay->sphone }}, {{ $pay->saddress }}</p><br>
<P>RECEIVER: {{ $pay->rnames }}, {{ $pay->rphone }} ,{{ $pay->raddress }}</P><br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
 <tr>
    <td>Temble</td>
    <td>Weight/g</td>
    <td>Tax</td>
    <td>Carton</td>
    <td>Postage</td>
    <td>Total</td>
 </tr>
 <tr>
    <td>{{ number_format($pay->temb_amount )}} RWF</td>
    <td>{{ $pay->weight }}</td>
    <td>{{ number_format($pay->tax) }} RWF</td>
    <td>0 RWF</td>
    <td>0 RWF</td>
    <td>{{ number_format($pay->temb_amount )}} RWF</td>
    </tr>
</table>
<br>
<p>Contact Number {{ auth()->user()->phone }}<br><br>
<p>Signature.....................................
@endforeach
</body>


</html>

