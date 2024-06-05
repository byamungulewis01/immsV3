@extends('layouts.admin.app')
@section('page-name')
   Other Revuenue Report
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Other Revuenue Report</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Other Revuenue</li>
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
                                <h5 class="card-title mb-0">Other Revuenue Report From {{ (!$startDate) ? now()->format('Y-m-d') : $startDate }} to {{ (!$endDate) ? now()->format('Y-m-d') : $endDate  }} </h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>

                                <a id="report_mask" style='display: none;'>.</a>
                                <button class="btn btn-primary ftb" data-bs-toggle="modal" data-bs-target=".modal-report"><i
                                        class="ri-calendar-2-fill"></i> Filter report by date</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table nowrap table-bordered align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 7%">#</th>
                                <th class="sort" data-sort="tracking">Branch</th>
                                <th class="sort" data-sort="amount">Amount</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($collection as $item)
                                <tr>
                                    <td scope="row">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="tracking">{{ $item->branch }}</td>
                                    <td class="receiver">{{ number_format($item->total_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>
                                Total
                            </th>
                            <th colspan="1"></th>
                            <th>{{ number_format($collection->sum('total_amount'), 2) }}</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="modal fade modal-report">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Report By date</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="report_date">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body register-card-body table-responsive p-3">

                                <div class="form-group">
                                    <label for="from">
                                        From :
                                    </label>
                                    <div class="input-group mb-3">
                                        <input type="date" name="from" value="{{ now()->format('Y-m-d') }}"
                                            id="from" class="form-control" placeholder="From" required="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="to">
                                        To :
                                    </label>
                                    <div class="input-group mb-3">
                                        <input type="date" name="to" id="to"
                                            value="{{ now()->format('Y-m-d') }}" class="form-control" placeholder="To"
                                            required="true">
                                    </div>
                                </div>
                                <div class="wait" align="center"></div>
                            </div>
                            <!-- /.form-box -->
                        </div><!-- /.card -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" id="reg_close"><span
                                class="fa fa-times"></span> Close</button>

                        <button type="submit" class="btn btn-primary" id="get_report">Get Filtered report</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
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
@endsection

@section('script')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
