@extends('layouts.admin.app')
@section('page-name')Recieved Dispatch @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dispatches Recieved</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS </a>
                    </li>
                    <li class="breadcrumb-item active">Dispatches Recieved</li>
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
                            <h5 class="card-title mb-0">List </h5>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                    style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 60px">
                                #
                            </th>
                            <th class="sort" data-sort="date">
                                DATE </th>

                            <th class="sort" style="width: 140px" data-sort="names">MAILS NUMBER</th>

                            <th class="sort" style="width: 130px" data-sort="weight">WEIGHT</th>
                            <th class="sort" data-sort="sentDate">SENT DATE</th>
                            <th class="sort" data-sort="status">STATUS</th>
                            <th class="sort" data-sort="">
                            </th>


                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach ($dispatches as $dispatch)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($dispatch->created_at)->locale('fr')->format('F j, Y') }}
                            </td>
                            <td>
                                <span class="badge bg-soft-success text-success">
                                    {{ $dispatch->mailsNumber }}
                                </span>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm apikey-value" readonly
                                    value="{{ $dispatch->weight }}">
                            </td>

                            <td>
                                {{ $dispatch->sentDate }}
                            </td>

                            <td>
                                {{-- status --}}
                                @if($dispatch->status == 0)
                                <span class="badge bg-soft-warning text-warning">
                                    Pending
                                </span>
                                @elseif($dispatch->status == 1)
                                <span class="badge bg-soft-success text-success">
                                    Dispatched
                                </span>
                                @elseif($dispatch->status == 2)
                                <span class="badge bg-soft-info text-primary">
                                    Received
                                </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('receiveDispatch.show',$dispatch->id) }}" class="btn btn-sm btn-info">
                                    <i class="mdi mdi-eye"></i> Dispatch
                                </a>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @endsection

    @section('script')
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
            $('#datatableAjax').DataTable({
                scrollX: true,
            });
        });

    </script>
    @endsection
