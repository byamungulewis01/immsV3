<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>EMS Receipt</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            /* padding: 20px; */
            font-size: 13px;
            color: #0d5887;

        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0px;
        }

        header img {
            width: 400px;
        }

        h1,
        h2,
        h3 {
            margin: 0;
            padding: 0;
        }

        /* main {
            border: 3px solid #221c1c;
            padding: 20px;
        } */

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

        p {
            margin-top: 10px;
        }

        /* Customizing the layout for the invoice elements */



        footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            text-align: right;
            font-size: 10px;
            color: #888;
            /* Adjust color as needed */
        }


        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            header,
            main {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <main>
        <header>
            <table border="0" width="100%">
                <tr>
                    <td width="70%" style="border: 0px;">

                        <img src="{{ public_path('logo/ems_new.jpg') }}" alt="EMS Logo" width="400">
                    </td>

                </tr>
            </table>
        </header>
        <center>
            <h3 style="padding : 1px;font-size : 18px; font-weight:900;"> <u>EMS MAIL OUTBOXING RECEIPT</u></h3>
        </center>

        {{-- <p style="margin-bottom: -4px;"> <strong>Receipt :</strong>
            #{{ $receipt->receipt_number }} </p> --}}
        <h4>Ref : # {{ str_pad($outbox->id, 4, '0', STR_PAD_LEFT) }}</h4>
        <p style="margin-bottom: 0px;"> <strong>Sender Details</strong></p>
        <p style="margin-bottom: -4px;"> <strong>Names :</strong> {{ $outbox->snames }} </p>
        <p style="margin-bottom: -4px;"> <strong>Phone :</strong> {{ $outbox->sphone }} </p>
        <p style="margin-bottom: -4px;"> <strong>Email :</strong> {{ $outbox->semail }} </p>
        <p style="margin-bottom: -4px;"> <strong>Address :</strong> {{ $outbox->saddress }} </p>
        <br>
        <p style="margin-bottom: 0px;"> <strong>Receiver Details</strong></p>
        <p style="margin-bottom: -4px;"> <strong>Names :</strong> {{ $outbox->rnames }} </p>
        <p style="margin-bottom: -4px;"> <strong>Country :</strong>
            {{ Str::words($outbox->destiny->countryname, 2, ' ...') }} </p>
        <p style="margin-bottom: -4px;"> <strong>Phone :</strong> {{ $outbox->rphone }} </p>
        <p style="margin-bottom: -4px;"> <strong>Email :</strong> {{ $outbox->remail }} </p>
        <p style="margin-bottom: -4px;"> <strong>Address :</strong> {{ $outbox->raddress }} </p>
        <br>
        <hr>

        <table border="0" width="100%">
            <tr>
                <td width="50%" style="border: 0px;">
                    <p style="margin-bottom: -4px;">Weight /kg : {{ number_format($outbox->weight) }}</p>
                    <p style="margin-bottom: -4px;">Amount : {{ number_format($outbox->amount) }} Rwf</p>
                    <p style="margin-bottom: -4px;">Carton/Envelop : {{ number_format($outbox->postage) }} Rwf</p>
                    <p style="margin-bottom: -4px;"><strong>Total</strong> :
                        {{ number_format($outbox->amount + $outbox->postage) }} Rwf</p>

                </td>
                <td width="50%" style="border: 0px;">

                    <p style="margin-bottom: -4px;"> <span>Signature</span></p>
                    <p style="margin-bottom: -4px;"> ...................................</p>

                </td>

            </tr>
        </table>
    </main>

</body>

</html>
