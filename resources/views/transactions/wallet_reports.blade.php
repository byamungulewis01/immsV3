@extends('layouts.admin.app')
@section('page-name')
    Wallet
@endsection
@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Wallet</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Wallet</a>
                        </li>
                        <li class="breadcrumb-item active">All Wallet</li>
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
                                <h5 class="card-title mb-0">Wallet</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Attachment</th>
                                <th>Commission (3%)</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wallets as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->created_at->format('Y M d') }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td><a target="_black" href="{{ asset('wallets/' . $item->attachment) }}"
                                            class="btn btn-sm btn-primary"><i class="ri-download-fill align-middle"></i>
                                            Download</a></td>
                                    <td>{{ $item->amount * 0.3 }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <span class="badge bg-warning text-uppercase">Pending</span>
                                        @elseif($item->status == 'approved')
                                            <span class="badge bg-success text-uppercase">approved</span>
                                        @else
                                            <span class="badge bg-danger text-uppercase">rejected</span>
                                        @endif
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
    {{-- <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
    {{-- <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
