@php
    use Picqer\Barcode\BarcodeGeneratorPNG;
    $generator = new BarcodeGeneratorPNG();
    $barcodeData = 'REF:'.$out_id;
    $barcodeImage = 'data:image/png;base64,' . base64_encode($generator->getBarcode($barcodeData, $generator::TYPE_CODE_128));
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $barcodeData }} || EMS Mail Outboxing receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 4px;
            border: 1px solid black;
        }

        th {
            text-align: center;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            max-width: 150px;
        }

        h3 {
            text-align: center;
        }

        .border-right {
            border-right: 1px solid black;
        }

        #barcode img {
            max-width: 100%;
        }

        .mt-3 {
            margin-top: 5px;
        }
        .postal-holder {
            border: 2px solid #000;
            padding: 10px;
            width: fit-content;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th colspan="3">Receipt</th>
        </tr>
        <tr>
            <td colspan="3" class="logo">
                <img src="{{ public_path('logo/ems.jpg') }}" alt="" height="">
                <br>
                <b>RWANDA Express</b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <h3>EMS Mail Outboxing receipt</h3>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <b>{{ $barcodeData }}</b>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <h4>Sender Details</h4>
            </td>
            <td colspan="2">
                Names : {{ $outbox->snames }} <br>
                Phone : {{ $outbox->sphone }} <br>
                Email : {{ $outbox->semail }} <br>
                Address : {{ $outbox->saddress }} <br>

            </td>
        </tr>
        <tr>
            <td>
                <h4>Receiver Details</h4>
            </td>
            <td colspan="2">
                Names : {{ $outbox->rnames }} <br>
                {{-- Country --}}
                @php
                    $country_ = App\Models\Country::country_tarif($outbox->c_id,"data");
                @endphp
                Country : {{ "(".$outbox->c_id.")".$country_['countryname'] }}<br>
                Phone : {{ $outbox->rphone }} <br>
                Email : {{ $outbox->remail }} <br>
                Address : {{ $outbox->raddress }} <br>


            </td>
        </tr>
        <tr>
            <td class="border-right">
                {{-- <img class="logo" src="{{ asset('logo/tembre_holder.png') }}" alt="" height=""> --}}
            </td>
            <td class="border-right">
                <table>
                    <tr>
                        <th>Product</th>
                        <td>
                            {{-- product from outbox row  --}}
                            {{ number_format($outbox->amount) }} Rwf
                        </td>
                    </tr>
                    <tr>
                        <th>Tax</th>
                        <td>
                            {{-- tax from outbox row  --}}
                            {{ number_format($outbox->tax) }} Rwf
                        </td>
                    </tr>
                    <tr>
                        <th>Envelop</th>
                        <td>
                            {{-- envelop from outbox row  --}}
                            {{ number_format($outbox->postage) }} Rwf
                        </td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>
                            {{-- total from outbox row  --}}
                            {{ number_format($outbox->amount + $outbox->postage) }} Rwf
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <div id="barcode" align="center">
                    <img src="{{ $barcodeImage }}" alt="Barcode">
                    <br>
                    {{ $barcodeData }}
                </div>
                <br>
                <b class="mt-3">Signature: .............</b>
            </td>
        </tr>
    </table>
</body>
</html>
