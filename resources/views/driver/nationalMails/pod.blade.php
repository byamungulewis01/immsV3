<!DOCTYPE html>
<html>
<head>
  <title>P.O.D</title>
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
  <p style="font-size: 14px; font-weight: bold;">
    NATIONAL POSTS OFFICE<br>
    EXPRESS MAIL SERCVICE (EMS)<br>
    TEL +250788303493 <br>
    Website: www.i-posita.rw <br>
  </p>

  <h5>
    <u>
        P.O.D AND DAILY RECORD OF MAIL DELIVERED
    </u>
  </h5>


  <table>
        <tr class="table-active">
            <th>Order No</th>
            <th>Date</th>
            <th>Ref Number</th>
            <th>Destination</th>
            <th>Date,Name and sign of Address</th>
            <th>Weight</th>
            <th>Price</th>
            <th>Observation</th>
        </tr>
        @foreach ($dispatches as $mail)
        <tr>
        <td><strong>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</strong></td>
        <td>{{  $mail->created_at->format('Y-m-d') }}</td>
        <td>{{ $mail->refNumber }}</td>
        <td>{{ $mail->destination->address }}</td>
        <td></td>
        <td>{{ $mail->weight }}</td>
        <td>{{ $mail->price }}</td>
        <td>{{ $mail->observation }}</td>
        </tr>
        @endforeach
</table><!--end table-->
 <br><br>
<p>
    Date and Time : ...............  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    Name and Signature of the Postal Agent : ............... &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      Name and Signature of the Sender : ...............&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
</p>


</body>
</html>

