<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <style>
    /* CSS styles for the invoice page */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .logo {
      width: 150px;
    }

    .date {
      text-align: right;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <div class="header">
    {{-- heading --}}
    <div class="">
      <img src="" alt="Logo" height="100px">
    </div>
    <div class="date">
      {{-- <strong>Date:</strong> 2023-06-01 --}}
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Reference</th>
        <th>Destination</th>
        <th>Date </th>
        <th>Qte</th>
        <th>Price</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($mails as $mail)
        <tr>
        <td>{{ $invoice_number }}</td>
        <td>{{ $mail->details->destination->address }}</td>
        <td>{{ $mail->dateReceived }}</td>
        <td>{{ $mail->weight }}</td>
        <td>{{ $mail->price }}</td>
        <td>{{ $mail->total_amount }}</td>
        </tr>
        @endforeach
      <!-- Add more rows for other invoice items -->
    </tbody>
  </table>
</body>
</html>
