<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        th {
            text-align: left;
        }

        tfoot {
            font-weight: bold;
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

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.1;
            font-size: 16px;
            font-weight: bold;
            color: #5c5c5c;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="watermark">POSTAL PARCEL <strong>Ref : # {{ str_pad($outbox->id, 4, '0', STR_PAD_LEFT) }}</strong></div>




    <htmlpageheader name="myheader">
        <table border="0" width="100%">
            <tr>
                <td width="100%" style="border: 0px;"><span style="font-weight: bold; font-size: 11pt;">NATIONAL POST
                        OFFICE</span><br>
                    <img src="{{ public_path('assets/images/iposta/logo.png') }}" alt="IPOSITA" height="110"><br>
                    E-mail :info@i-posita.rw<br />
                    TEL : 250-0252582703 <br>
                    B.P. 4 KIGALI<br />
                    Website: www.i-posita.rw
                </td>
            </tr>
        </table>



    </htmlpageheader>
    <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
    <sethtmlpagefooter name="myfooter" value="on" />
    <center><u>
            <h2>DEPOSIT RECEIPT OF A POSTAL PARCEL</h2><u></center>
    <h4>Ref : # {{ str_pad($outbox->id, 4, '0', STR_PAD_LEFT) }}</h4>
    <p style="margin-bottom: 0px;"> <strong>Sender Details</strong></p>
    <p style="margin-bottom: -4px;"> <strong>Names :</strong> {{ $outbox->snames }} </p>
    <p style="margin-bottom: -4px;"> <strong>Phone :</strong> {{ $outbox->sphone }} </p>
    <br>
    <p style="margin-bottom: 0px;"> <strong>Receiver Details</strong></p>
    <p style="margin-bottom: -4px;"> <strong>Names :</strong> {{ $outbox->rnames }} </p>
    <p style="margin-bottom: -4px;"> <strong>Phone :</strong> {{ $outbox->rphone }} </p>
    <p style="margin-bottom: -4px;"> <strong>Country :</strong>
        {{ Str::words($outbox->destiny->countryname, 2, ' ...') }} </p>

        <br>
    <hr>
    <table border="0" width="100%">
        <tr>
            <td width="50%" style="border: 0px;">
                <p style="margin-bottom: -4px;">Weight /kg :  {{ number_format($outbox->weight) }}</p>
                <p style="margin-bottom: -4px;">Amount :  {{ number_format($outbox->amount) }} Rwf</p>
                <p style="margin-bottom: -4px;">Carton/Envelop : {{ number_format($outbox->postage) }} Rwf</p>
                <p style="margin-bottom: -4px;"><strong>Total</strong> :  {{ number_format($outbox->amount + $outbox->postage) }} Rwf</p>

            </td>
            <td width="50%" style="border: 0px;">

                <p style="margin-bottom: -4px;"> <span>Done at Kigali on {{ $outbox->created_at->format('Y-m-d') }}</span></p>
                <p style="margin-bottom: -4px;"> <span>Cashier:{{ auth()->user()->name }}</span></p>
                <p style="margin-bottom: -4px;"> <span>Signature</span></p>
                <p style="margin-bottom: -4px;"> ...................................</p>

            </td>

        </tr>
    </table>

</body>


</html>
