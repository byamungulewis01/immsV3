@extends('layouts.admin.app')
@section('page-name') Home Delivery @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Home Delivery</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Home Delivery</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if (Request::routeIs('driver.homeDelivery.index'))
                        New requests
                        @elseif(Request::routeIs('driver.homeDelivery.transit'))
                        In Transit
                        @elseif(Request::routeIs('driver.homeDelivery.delivered'))
                        Delivered
                        @endif

                    </li>
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
                            <h5 class="card-title mb-0">Customer Requests</h5>
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

                            <th class="sort" data-sort="name">Customer Name</th>
                            <th class="sort" data-sort="phone">Customer Phone</th>
                            <th class="sort" data-sort="address">Address</th>
                            <th class="sort" data-sort="courier">Courier No</th>
                            <th class="sort" data-sort="request">Requested Date</th>
                            <th class="sort" data-sort="request">Expected Delivery Date</th>
                            @if (Request::routeIs('driver.homeDelivery.index'))
                            <th class="sort" data-sort="action"></th>
                            @else
                            <th class="sort" data-sort="action">Driver</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveries as $key => $delivery)
                        <tr>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>

                         <td> {{ $delivery->box->name }} </td>
                         <td> {{ $delivery->box->phone }} </td>
                        <td> @if ($delivery->addressOfDelivery == 'home')
                            {{ $delivery->box->homeAddress }}
                        @else
                            {{ $delivery->box->officeAddress }}
                        @endif
                        </td>
                        <td> {{ $delivery->curier->innumber }} </td>
                        <td> {{ $delivery->expectedDateOfDelivery }} </td>
                        <td> {{ $delivery->created_at->format('d-m-Y') }} </td>
                        @if (Request::routeIs('driver.homeDelivery.index'))
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#topmodal{{ $delivery->id }}">Assign</button>
                            <div id="topmodal{{ $delivery->id }}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body text-center p-5">

                                                <div class="text-muted text-center mx-lg-3">
                                                    <h4 class="">Driver Assignment</h4>
                                                    <p>Assign a driver to deliver this box</p>
                                                </div>

                                                <div class="mt-4">
                                                    <form action="{{ route('driver.homeDelivery.assignDelivery',$delivery->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3">
                                                            {{-- select driver --}}
                                                            <select class="form-select" name="driver" aria-label="Default select example" required>
                                                            <option selected disabled>Select Driver</option>
                                                                @foreach ($drivers as $driver)
                                                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mt-3">
                                                            <button type="submit" class="btn btn-success w-100">Confirm</button>
                                                        </div>

                                                    </form>

                                                </div>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </td>
                        @else
                        <td>{{ $delivery->user->name }}</td>
                        @endif

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

{{-- <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> --}}

<script>
    $(document).ready(function() {
        $('#scroll-horizontal').DataTable({
            "scrollX": true,
        });
    });
</script>

@endsection
