@extends('layouts.admin.app')
@section('page-name')
    P.O Boxes
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Physical P.O Box</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS P.O B</a>
                        </li>
                        <li class="breadcrumb-item active">P.O Boxes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">PHYSICAL P.O BOX</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a class="btn btn-primary" href="{{ route('physicalPob.index') }}">All P.O.Box</a>
                                <a class="btn btn-info" href="{{ route('physicalPob.index', ['available' => 0]) }}">Renewed
                                    P.O.Box</a>
                                <a class="btn btn-dark" href="{{ route('physicalPob.index', ['available' => 1]) }}">Not
                                    Renewed</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 40px">Postal Branch</th>
                                <th class="sort" data-sort="pob">Total PO Boxes</th>
                                <th class="sort" data-sort="size">Renewed</th>
                                <th class="sort" data-sort="cotion">Not renewed</th>
                                {{-- <th class="sort" data-sort="amount"> Total BP renewed</th>
                            <th class="sort" data-sort="action">Total BP not renewed</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $totalrenew = 0;
                                $totalavailable = 0;
                            @endphp
                            @foreach ($boxes as $key => $box)
                                <tr>
                                    <td>{{ $box->pob_category }}</td>
                                    <td>{{ $box->total }}</td>
                                    <td>{{ $box->totalrenew }}</td>
                                    <td>{{ $box->totalavailable }}</td>
                                </tr>
                                @php
                                    $total = $box->total + $total;
                                    $totalrenew = $box->totalrenew + $totalrenew;
                                    $totalavailable = $box->totalavailable + $totalavailable;
                                @endphp
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td>{{ $total }}</td>
                                <td>{{ $totalrenew }}</td>
                                <td>{{ $totalavailable }}</td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        // phone
        $(document).ready(function() {
            $('.phone').mask('000 000 000');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#datatableAjax').DataTable({
                pageLength: 100,
            });
        });
    </script>
@endsection
