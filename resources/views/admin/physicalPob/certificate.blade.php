<!DOCTYPE html>
<html>

<head>
    <title>Certificate</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
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
    <p style="font-size: 18px; font-weight: bold;">REPUBLIC OF RWANDA<br>
        NATIONAL POSTS OFFICE<br>
        <img src="{{ public_path('img/logo.png') }}" alt="Girl in a jacket" width="160" height="100">
        <br>
        B.P 4 KIGALI, <br>
        EL +250783626253 <br>
        E-mail:info@i-posita.rw <br>
        Website: www.i-posita.rw <br>
    </p>
    <br>
    <br>
    <h2><u>CERTIFICATE OF DETENTION OF A POSTAL BOX</u></h2>
    <br>
    <p style="font-size: 19px;">
        I, undersigned Celestin KAYITARE , Director General of the Natinal Post Office ,
        hereby certify that <strong> {{ $box->name }} </strong> is a holder
        of the PO Box N<sup>0</sup> {{ $box->pob }} at the Postal Agency <strong>{{ $box->branch->name }}.</strong>

        <br>
        This certificate is issued to it as evidence under the heading above.
        <br>
        This certificate is valid until 31/01/{{ date('Y') + 1 }}

        <br><br>
        Done at Kigali on {{ date('d/m/Y') }}
        <br><br><br>

    </p>
    <p style="font-size: 20px;">
        <strong>KAYITARE Celestin</strong> <br>
        Director General
        <br>

        <br>
        By delegation:
        <br><br><br>
        <strong>Yvette KAMANZI </strong> <br>
        Head of the Postal Agency KIGALI
    </p>



</body>

</html>
