@extends('layouts.admin.app')
@section('page-name')
    ACTIVITY REPORT FOR AGENCIES
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">BRANCH ACTIVITY REPORT FOR AGENCIES </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Mails</li>
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
                                <h5 class="card-title mb-0">BRANCH ACTIVITY REPORT FOR AGENCIES - {{ request('date') }}</h5>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    @php
                        // Group results by branch and name for easier access
                        $groupedByBranch = $results->groupBy('branch');
                        $groupedByName = $results->groupBy('name');

                        // Calculate total amounts per branch
                        $totalAmountsPerBranch = [];
                        foreach ($groupedByBranch as $branch => $data) {
                            $totalAmountsPerBranch[$branch] = $data->sum('total_amount');
                        }

                        $totalAmountsPerName = [];
                        foreach ($groupedByName as $name => $data) {
                            $totalAmountsPerName[$name] = $data->sum('total_amount');
                        }
                        $grandTotal = $results->sum('total_amount');
                    @endphp
                    <table id="datatable" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Activities</th>
                                @foreach ($groupedByBranch as $branch => $data)
                                    <th>{{ $branch }}</th>
                                @endforeach
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupedByName as $name => $data)
                                <tr>
                                    <td>{{ $name }}</td>
                                    @foreach ($groupedByBranch as $branch => $branchData)
                                        @php
                                            $amount = $branchData->firstWhere('name', $name)->total_amount ?? 0;
                                        @endphp
                                        <td>{{ number_format($amount, 2) }}</td>
                                    @endforeach
                                    <td>{{ number_format($totalAmountsPerName[$name], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                @foreach ($totalAmountsPerBranch as $branch => $totalAmount)
                                    <th>{{ number_format($totalAmount, 2) }}</th>
                                @endforeach
                                <th>{{ number_format($grandTotal, 2) }}</th>
                            </tr>
                        </tfoot>

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


@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
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
        $(document).ready(function() {
        $('#datatable').DataTable({
            scrollX: true,

            'order': [],
            'dom': 'Bfrtip',
            buttons: [{
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
                }
            ]
        });
        });
    </script>
@endsection
