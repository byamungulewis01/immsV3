@extends('layouts.admin.app')
@section('page-name')Vehicle History @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Vehicle History</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS </a>
                    </li>
                    <li class="breadcrumb-item active">Vehicle History</li>
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
                            <h5 class="card-title mb-0">Vehicle History List</h5>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">
                                #
                            </th>

                            <th class="sort" data-sort="name">
                                Driver Name
                            </th>
                            <th class="sort" data-sort="email">Email</th>
                            <th class="sort" data-sort="phone">Phone</th>
                            <th class="sort" data-sort="branch">Vehicle</th>
                            <th class="sort" data-sort="date">Plate Number</th>
                            <th class="sort" data-sort="status">Received Vehicle Date</th>
                            <th class="sort" data-sort="action">Return Vehicle Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicleHistory as $key => $item)
                        <tr>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="name">{{ $item->driver->name }}
                            </td>
                            <td class="email">{{ $item->driver->email }}</td>
                            <td class="phone">{{ $item->driver->phone }}</td>
                            <td class="branch">{{ $item->vehicle->name }}</td>
                            <td class="branch">{{ $item->vehicle->plate_number }}</td>

                            <td class="date"> {{ $item->created_at->format('d M, Y') }}</td>
                            <td class="status">

                                @if ($item->date_of_return == null)
                                    <span class="badge bg-dark">Not Returned</span>
                                @else
                                    {{ \Carbon\Carbon::parse($item->date_of_return)->format('d M, Y') }}
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

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

@endsection
