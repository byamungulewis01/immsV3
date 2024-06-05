<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
<style>
body {font-family: sans-serif;
	font-size: 10pt;
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
.watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        opacity: 0.3;
        font-size: 50px;
        font-weight: bold;
        color: #5c5c5c;
        z-index: -1;
    }
</style>
</head>
<body>
    <div class="watermark">IPOSITA</div>

<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="100%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 11pt;">NATIONAL POST OFFICE</span><br> E-mail :info@i-posita.rw<br /> TEL : 250-0252582703 <br> B.P. 4 KIGALI
<br /> Website: www.i-posita.rw </td>
</tr></table>



</htmlpageheader>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
<div style="font-weight: bold; font-size: 12pt;" >BN: {{ $pay->id}}</div>
<div style=" font-size: 12pt;" >Client:{{ $pay->inname }}</div> <br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<thead>
<tr>
<td>MAIL CODE</td>


<td>Amount</td>
</tr>
</thead>
<tbody>



<tr>
<td align="center">{{ $pay->innumber }}</td>
<td align="center">{{ $pay->amount}} Frw</td>


</tr>


</tbody>
</table>
<div > Done at Kigali on {{ $pay->created_at->format('Y-m-d') }}</div>
<div >Cashier:{{ auth()->user()->name}}</div>
<div > Client Signature........................</div>
<hr>
{{-- pages --}}
<div style="text-align: center; font-size: 9pt;align-items: center;justify-content: center;display: flex;
bottom: 0;">
    Page <span class="pagenum">1</span> of <span class="pagecount">2</span>
</div>
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="100%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 11pt;">NATIONAL POST OFFICE</span><br> E-mail :info@i-posita.rw<br /> TEL : 250-0252582703 <br> B.P. 4 KIGALI
<br /> Website: www.i-posita.rw </td>
</tr></table>



</htmlpageheader>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
<div style="font-weight: bold; font-size: 12pt;" >BN: {{ $pay->id}}</div>

<div style=" font-size: 12pt;" >Client:{{$pay->inname }}</div> <br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<thead>
<tr>
<td>Mail Code</td>
<td>Amount</td>
</tr>
</thead>
<tbody>



<tr>
<td align="center">{{ $pay->innumber }}</td>
<td align="center">{{$pay->amount}} Frw</td>


</tr>


</tbody>
</table>
<br>
<div > Done at Kigali on {{ $pay->created_at->format('Y-m-d') }}</div>
<div >Cashier:{{ auth()->user()->name}}</div>
<div > Client Signature........................</div>
<hr>
{{-- pages --}}
<div style="text-align: center; font-size: 9pt;align-items: center;justify-content: center;display: flex;
bottom: 0;">
    Page <span class="pagenum">2</span> of <span class="pagecount">2</span>
</div>

</body>


</html>
