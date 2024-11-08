@extends('layouts.admin.app')
@section('page-name')
    INCOMES
@endsection
@section('body')
    @php
        use Illuminate\Support\Facades\DB;
    @endphp

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">PHYSICAL INCOMES LIST</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">P.O Box</li>
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
                                <h5 class="card-title mb-0">PHYSICAL P.O Box INCOMES LIST</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                {{-- @if ($from && $to && $courierPays->count() > 0)
                                    <button class="btn btn-soft-danger">
                                        ALL FROM {{ $from }} to {{ $to }}
                                    </button>
                                @endif --}}

                                <form action="" method="get">
                                    <div class="input-group">
                                        <input type="date" class="form-control" value="{{ $from }}"
                                            name="from" max="{{ date('Y-m-d') }}">
                                        <input type="date" class="form-control" value="{{ $to }}"
                                            name="to" max="{{ date('Y-m-d') }}">
                                        <button class="input-group-text bg-primary border-primary text-white">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="buttons-datatables" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">
                                    #
                                </th>

                                <th class="sort" data-sort="DATE">DATE</th>
                                <th class="sort" data-sort="P.O BOX">P.O BOX</th>
                                <th class="sort" data-sort="YEAR">YEAR</th>
                                <th class="sort" data-sort="PAYMENT TYPE">PAYMENT TYPE</th>
                                <th class="sort" data-sort="PAYMENT MODEL">PAYMENT MODEL</th>
                                <th class="sort" data-sort="AMOUNT">AMOUNT</th>
                                <th class="sort" data-sort="DONEBY">DONE BY</th>

                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($courierPays as $key => $courierPay)
                                <tr>
                                    <th scope="row">
                                        {{ $key + 1 }}
                                    </th>
                                    <td>{{ $courierPay->pdate }}</td>
                                    <td>{{ $courierPay->box->pob }}</td>
                                    <td>{{ $courierPay->year }}</td>
                                    <td>{{ strtoupper($courierPay->payment_type) }}</td>
                                    <td>{{ strtoupper($courierPay->payment_model) }}</td>
                                    <td><b>{{ number_format($courierPay->amount) }}</b></td>
                                    <td>{{ $courierPay->user->name }}</td>
                                </tr>
                            @endforeach
                            {{-- @foreach ($courierPays as $key => $courierPay)
                                <tr>
                                    <th scope="row">
                                        {{ $key + 1 }}
                                    </th>
                                    <td class="MAIL CODE"><a href="">{{ $courierPay->pdate }}</a></td>
                                    <td class="TRACKING NUMBER"><b>{{ number_format($courierPay->cash) }}</b></td>

                                    <td>

                                        <a href="{{ route('physicalPob.detailphy', encrypt($courierPay->pdate)) }}"
                                            type="button" class="btn btn-success btn-sm"><span>Transactions</span></a>

                                    </td>
                                    </td>
                                </tr>
                            @endforeach --}}
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
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
    {{-- <script src="{{ asset('assets/libs/@simonwep/pickr/pickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script> --}}
@endsection
