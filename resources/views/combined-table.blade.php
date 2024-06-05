@extends('layouts.admin.app')
@section('page-name')
Daily Outboxing Report
@endsection
@php
    use App\Models\Eric\AirportDispach;

@endphp
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Daily Report</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Dispatch Report</li>
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
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">DAILY OUTBOXING REPORT</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="manageBrandTable" class="table nowrap table-bordered align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th class="sort" data-sort="TRACKING NUMBER">Date</th>
                                <th class="sort" data-sort="NAME">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $data1 = DB::table('transferouts')
                                ->select('rvdate', DB::raw('COUNT(*) as total'))
                                ->where('status', '1')
                                ->groupBy('rvdate')
                                ->orderBy('rvdate', 'desc')
                                ->limit(20)
                                ->get();
                            @endphp

                            @foreach ($data1 as $key => $item)
                                <tr>
                                    <td scope="row">
                                        {{ $key + 1 }}
                                    </td>

                                    <td class="email">{{ $item->rvdate }}</td>
                                    <td>
                                        <a href="{{ route('admin.combined.transactionallrep', encrypt($item->rvdate)) }}" type="button" class="btn btn-success btn-sm" target="_blank"><span>View Details</span></a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
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
    @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
                keyboard: false
            })
            myModal.show()
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $(".phoneNumber").on("input", function() {
                var value = $(this).val();
                var decimalRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
                if (!decimalRegex.test(value)) {
                    $(this).val(value.substring(0, value.length - 1));
                }
            });
        });
    </script>

    <!--datatable js-->



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



    <script type="text/javascript">
        $(".sellect").chosen({
            width: '100%'
        });
    </script>
    <script>
        $(document).ready(function() {

            // top bar active

            // manage brand table
            var rep_tbl = $("#manageBrandTable").DataTable({
                // 'processing': true,
                // 'serverSide': true,
                'order': [],


            });
        });
    </script>
@endsection
