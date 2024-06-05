<!-- resources/views/combined-table.blade.php -->
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

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;

}

td, th {
  border: 2px solid #180606;
  text-align: left;
  padding: 8px;


}

 .p3 {
  font-family: "Brush Script MT";
  color:blue;
}
</style>
<body>
    <table width="100%">
        <tr>
        <td  width="25%">


        <img src="{{ public_path('img/logo.png')  }}" alt="Girl in a jacket" width="100" height="100">

        </td>
        <td>
        <h2 class="p3">REPUBLIC OF RWANDA</h2>
        <h2 class="p3">NATIONAL POST OFFICE</h2>
        <h2>B.P 4 KIGALI, TEL +250783626253</h2>
        <h2>E-mail:info@i-posita.rw </h2>
        <h2>Website: www.i-posita.rw</h2>


        </td>
        </tr>

        </table>
    <center><h1>PACKING LIST</h1></center>
    <table border="2" cellspacing="0">
        <thead>
            <tr>
                <th>Date</th>
                <th>ORGINE</th>
                <th>DESTINATION</th>
                <th>DESCRIPTION</th>
                <th>SENDER</th>
                <th>PHONE N./B.P</th>
                <th>RECEIVER</th>
                <th>DSP</th>
                <th>WEIGHT</th>
                <!-- Add other column headers here -->
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td style="width: 70px">{{ $item->recdate }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->c_id }}</td>
                    <td></td>
                    <td>{{ $item->snames }}</td>
                    <td>{{ $item->sphone }}</td>
                    <td>{{ $item->rnames }}</td>
                    <td>{{ $item->trid }}</td>
                    <td>{{ $item->weight }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>





 <br>
 <br>

<table width="100%">
<tr>
<td> <b>PREPARED BY  </b> <br><br>
NAMES: <B> {{strtoupper(auth()->user()->name) }}</B><br><br>
Signature ----------------------------------------------<br><br>
</tr>
</table>
</body>
</body>
</html>

