<!DOCTYPE html>
<html>

<head>
    <title>Branch Daily Activities</title>
    <style>
        body {
            font-family: sans-serif;
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

        p {
            margin: 0pt;
        }

        table.items {
            border: 0.1mm solid #000000;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        table thead td {
            background-color: #EEEEEE;
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

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;


        }

        .p3 {
            font-family: "Brush Script MT";
            color: blue;
        }
    </style>
</head>
<div class="watermark">Daily Activities</div>

<body>
    <p style="font-size: 14px; font-weight: bold;">REPUBLIC OF RWANDA<br>
        NATIONAL POSTS OFFICE<br>
        <img src="{{ public_path('img/logo.png') }}" alt="IPOSITA Logo" width="120" height="70">
        <br>
        B.P 4 KIGALI, TEL +250783626253 <br>
        E-mail:info@i-posita.rw <br>
        Website: www.i-posita.rw <br>
    </p>
    <h3 style="text-align:center">Branch Daily Activities ({{ $date }})</h3>

    <table width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Branch Name</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collection as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->branch_name }}</td>
                <td>{{ $item->total_amount }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    @php
        use Carbon\Carbon;
        $done_date = Carbon::now();
        $done_date->toDateString(); // Outputs the date in the format: YYYY-MM-DD
    @endphp


    Done a Kigali on {{ $done_date }}
    <br>
    <br>
    <table width="100%">
        <tr>
            <td> <b>PREPARED BY </b> <br><br>
                NAMES: <B> {{ strtoupper(auth()->user()->name) }}</B><br><br>
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
