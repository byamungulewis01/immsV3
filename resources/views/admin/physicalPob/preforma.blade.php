@php
function convertNumber($num = false)
{
    $num = str_replace(array(',', ''), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' and ' . $list1[$tens] . ' ' : '' );
        } elseif ($tens >= 20) {
            $tens = (int)($tens / 10);
            $tens = ' and ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    $words = implode(' ',  $words);
    $words = preg_replace('/^\s\b(and)/', '', $words );
    $words = trim($words);
    $words = ucfirst($words);
    $words = $words . ".";
    return $words;
}
@endphp
<!DOCTYPE html>
<html>
<head>
  <title>Pro Forma Invoice</title>
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
  <p style="font-size: 14px; font-weight: bold;">REPUBLIC OF RWANDA<br>
    NATIONAL POSTS OFFICE<br>
    <img src="{{ public_path('img/logo.png')  }}"
    alt="Girl in a jacket" width="160" height="100">
    <br>
    B.P 4 KIGALI, TEL +250783626253 <br>
    E-mail:info@i-posita.rw <br>
    Website: www.i-posita.rw <br>
    Our TIN/VAT is 100021341 <br>
  </p>
  <p style="font-size: 12px; font-weight: bold;">
   INVOICE PROFORMA N<sup><u>o</u></sup> : {{ $item->bill_number }} <br>
   DATE OF ISSUE : {{ $item->created_at->format('Y-m-d') }} <br>
  </p>

  <p style="border: 1px solid black; padding: 8px;font-size: 15px;">
   CLIENT'S NAME :<b> {{ $item->pobBox->name }}</b><br>
    PO BOX : {{ $item->pobBox->pob }}<br>
    ADDRESS : {{ $item->pobBox->branch->name }}<br>
  </p>

    <b>{{ $item->pobBox->name }} </b> National Post Office <b><em> {{strtoupper(convertNumber($item->total_amount))}} RWANDA FRANCS ({{ number_format($item->total_amount) }}) </em></b> for:__ <br>

    <hr>

    <p>
        @php
        $years = explode(',', $item->non_pay_years);
        $rent = $item->rental_amount + ($item->rental_amount * 0.25);
        @endphp
        @foreach ($years as $key => $value)
        {{ $key+1 }}. PO BOX Rental Fees {{ $value }}......................................................................................................: <b>{{ number_format($rent) }} Rwf</b><br>
        @endforeach
        {{ count($years) + 1 }}. VAT of 18%...............................................................................................................................: Included <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;
         -------------------------------------------------- <br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <b>TOTAL  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              {{ number_format($item->total_amount) }} </b>
        <br>
    </p>
  <p>
    <b>
        {{ auth()->user()->name }}
    </b> <br>
    <b>Branch Manager</b> <br><br>
    Payment should be made to the following accounts: <br>

    &nbsp;&nbsp;&nbsp; - &nbsp; National Bank of Rwanda (NBR): 100 00 10 487/ Frw <br>
    &nbsp;&nbsp;&nbsp; - &nbsp; Bank of Kigali (BK): 00040-00045362-96/Frw <br> <br>
- <b>N.B:</b> The renewal of PO BOX is made from January 02<sup>nd</sup> of every year until 31 January at
the normal tariff. Beyond this deadline, any renewal may be increased of a fine of
25% of the usual subscription tariff.


  </p>



</body>
</html>

