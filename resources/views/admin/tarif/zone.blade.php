@extends('layouts.admin.app')
@section('page-name')EXPRESS MAIL SERVICE RWANDA PRICE LIST FOR INTERNATIONAL COURIER SERVICES DELIVERY @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-purchases-center justify-content-between">
            <h4 class="mb-sm-0">Zone Tarifs</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS Mails</a>
                    </li>
                    <li class="breadcrumb-item active">Zone Tarifs</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-purchases-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">EXPRESS MAIL SERVICE RWANDA PRICE LIST FOR INTERNATIONAL COURIER SERVICES DELIVERY</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table w-100" id="manageBrandTable">
                    <thead>
                      <tr>
                        <th>Weight<br>
                            (grms)
                        </th>
                        @php
                            $gen_tot = array();
                        @endphp
                        @foreach ($zones as $zone)
                            <th>{{ ucfirst($zone->zonename) }}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_tarifs as $tarifs)
                          <tr>
                            <td>
                              ({{ number_format($tarifs->minweight,2) }} - {{ number_format($tarifs->maxweight,2) }})
                            </td>
                            @php
                                unset($zone);
                            @endphp
                            @foreach ($zones as $zone)
                                @php
                                    $return = "N/A";
                                    // extract($value);
                                    $res = DB::table('tarifs')
                                            ->select('amount')
                                            ->where('minweight', $tarifs->minweight)
                                            ->where('maxweight', $tarifs->maxweight)
                                            ->where('zone_id', $zone->zone_id)
                                            ->get();

                                    if ($res->count() > 0) {
                                        $return = "N/A";
                                        foreach ($res as $row) {
                                            $return = number_format($row->amount, 2);
                                        }
                                    }

                                    $get = $return;
                                @endphp
                                <th>{{ ($get) }}</th>
                            @endforeach
                          </tr>
                        @endforeach

                    </tbody>
                  </table>
                  <table class="table table-bordered">
                    <tr>
                        <th>Zone</th>
                        <th>Countries</th>
                    </tr>
                    {{-- Display countries with zones --}}
                    @foreach ($zones as $zone)
                        <tr>
                            <td class="no-wrap nowrap">{{ ucfirst($zone->zonename) }}</td>
                            <td>
                                @php
                                    $countries = DB::table('czone')
                                                    ->select('c_id')
                                                    ->where('zone_id', $zone->zone_id)
                                                    ->get();
                                @endphp
                                @foreach ($countries as $country)
                                    {{-- Get country name from id specified --}}
                                    @php
                                        $country_name = DB::table('country')
                                                            ->select('countryname')
                                                            ->where('c_id', $country->c_id)
                                                            ->get();
                                    @endphp
                                    @foreach ($country_name as $name)
                                        {{ $name->countryname }},
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                  </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

@section('css')
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
@if($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
        keyboard: false
    })
    myModal.show()

</script>
@endif
<script>
    $(document).ready(function () {
        $(".phoneNumber").on("input", function () {
            var value = $(this).val();
            var decimalRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
            if (!decimalRegex.test(value)) {
                $(this).val(value.substring(0, value.length - 1));
            }
        });
    });

</script>

<!--datatable js-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
      $(document).ready(function () {
    // manage brand table
    var rep_tbl = $("#manageBrandTable").DataTable({
      'paging' : false,
      'order': [],

            'dom': 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                footer: true
            },
            {
                extend: 'csv',
                footer: true
            },
            {
                extend: 'excel',
                footer: true
            },
            {
                extend: 'pdf',
                footer: true
            },

        ]
    });

  });
    // check if data loaded fully
    $(document).ready(function () {

        // update item delete modal with clicked button data
        $(document).on('click', '.delete-item', function () {
            // var itemid = $(this).data('itemid');
            var formaction = $(this).data('action');
            $('#deleteitem').attr('action', formaction);
            // $('#itemid').val(itemid);
        });
    });

</script>
@endsection
