@extends('layouts.admin.app')
@section('page-name')
    Transfered Mails Outboxing
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Transfered Mails Outboxing</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mails</a>
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
                                <h5 class="card-title mb-0">List outboxing List</h5>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table nowrap table-bordered align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th class="sort" data-sort="tracking">Tracking</th>
                                <th class="sort" data-sort="tracking">Type</th>
                                <th class="sort" data-sort="sender">Sender Name</th>
                                <th class="sort" data-sort="sender">Sender Phone</th>
                                <th class="sort" data-sort="receiver">Receiver Name</th>
                                <th class="sort" data-sort="receiver">Receiver Phone</th>
                                <th class="sort" data-sort="country">Country</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($outboxings as $key => $outbox)
                                <tr>
                                    <td scope="row">
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="tracking">{{ $outbox->tracking }}</td>
                                    <td class="sender">
                                        @if ($outbox->type == 'ems')
                                            EMS
                                        @elseif ($outbox->type == 'p')
                                            Parcel
                                        @elseif ($outbox->type == 'r')
                                            Registered
                                        @else
                                            Ordinary
                                        @endif
                                    </td>
                                    <td class="sender">{{ $outbox->snames }}</td>
                                    <td class="sender">{{ $outbox->sphone }}</td>
                                    <td class="receiver">{{ $outbox->rnames }}</td>
                                    <td class="receiver">{{ $outbox->rphone }}</td>
                                    <td class="country">{{ Str::words($outbox->destiny->countryname, 2, ' ...') }}</td>

                                    <td class="action">
                                        @can('make outboxing')
                                            <a href="{{ route('branch.outboxing.print_out', $outbox->id) }}"
                                                class="btn btn-sm btn-info" target="_blank">PRINT</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <tfoot>
                            <th colspan="4">
                                Today's Income
                            </th>
                            <th id="amount_rep"></th>
                            <th id="carton_rep"></th>
                            <th id="total_rep"></th>
                        </tfoot> --}}
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

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"> --}}
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
