@extends('layouts.admin.app')
@section('page-name')
    Dispatch Report
@endsection
@section('body')
    @php
        use Illuminate\Support\Facades\DB;
    @endphp

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">DISPATCH OPENING REPORT</h4>

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
                                <h5 class="card-title mb-0">DAILY DISPATCH OPENING REPORT LIST</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
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

                                <th class="sort" data-sort="MAIL CODE">
                                    DATE
                                </th>
                                <th class="sort" data-sort="TRACKING NUMBER">TOTAL DISPATCH</th>
                                <th class="sort" data-sort="TRACKING NUMBER">TOTAL WEIGHT/KG</th>
                                <th class="sort" data-sort="NAME">ACTION</th>

                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($opens as $key => $open)
                                <tr>
                                    <th scope="row">
                                        {{ $key + 1 }}
                                    </th>
                                    <td class="MAIL CODE">{{ $open->cntppickupdate }}</td>
                                    <td class="TRACKING NUMBER"><b>{{ $open->total }}</b></td>
                                    <td class="TRACKING NUMBER"><b>{{ $open->weight }}</b></td>
                                    <td>
                                        <a href="{{ route('admin.cntp.details', encrypt($open->cntppickupdate)) }}"
                                            type="button" class="btn btn-success btn-sm" target="_blank"><span>View
                                                Details</span></a>

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


    <!-- Modal -->
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
