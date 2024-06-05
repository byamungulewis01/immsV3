@extends('layouts.admin.app')
@section('page-name') Reporting @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">MAIL REPORT</h4>

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
<div class="row mb-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">ORDINARY MAIL DAIRLY REPORT</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a class="btn btn-soft-dark btn-sm">Print </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th class="sort" data-sort="MAIL CODE">DATE</th>
                            <th class="sort" data-sort="IN MAILS">IN MAILS</th>
                            <th class="sort" data-sort="OUT MAILS">OUT MAILS</th>
                            <th class="sort" data-sort="BALANCE">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordinaryReports as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('F d, Y') }}</td>
                            <td>{{ $item->inMails }}</td>
                            <td>{{ $item->outMails }}</td>
                            <td>{{ $item->balance }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">REGISTERED MAIL DAIRLY REPORT</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <a class="btn btn-soft-dark btn-sm">Print </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th class="sort" data-sort="MAIL CODE">DATE</th>
                            <th class="sort" data-sort="IN MAILS">IN MAILS</th>
                            <th class="sort" data-sort="OUT MAILS">OUT MAILS</th>
                            <th class="sort" data-sort="BALANCE">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registeredReports as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('F d, Y') }}</td>
                            <td>{{ $item->inMails }}</td>
                            <td>{{ $item->outMails }}</td>
                            <td>{{ $item->balance }}</td>
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
<div class="row mb-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">PARCEL MAIL DAIRLY REPORT</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a class="btn btn-soft-dark btn-sm">Print </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th class="sort" data-sort="MAIL CODE">DATE</th>
                            <th class="sort" data-sort="IN MAILS">IN MAILS</th>
                            <th class="sort" data-sort="OUT MAILS">OUT MAILS</th>
                            <th class="sort" data-sort="BALANCE">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($percelReports as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('F d, Y') }}</td>
                            <td>{{ $item->inMails }}</td>
                            <td>{{ $item->outMails }}</td>
                            <td>{{ $item->balance }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">EMS DAIRLY REPORT</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a target="_blank" href="{{ route('admin.mailde.emsReports') }}" class="btn btn-soft-dark btn-sm">Print </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <table class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th class="sort" data-sort="MAIL CODE">DATE</th>
                            <th class="sort" data-sort="IN MAILS">IN MAILS</th>
                            <th class="sort" data-sort="OUT MAILS">OUT MAILS</th>
                            <th class="sort" data-sort="BALANCE">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emsReports as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('F d, Y') }}</td>
                            <td>{{ $item->inMails }}</td>
                            <td>{{ $item->outMails }}</td>
                            <td>{{ $item->balance }}</td>
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
<div class="row mb-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">GOOGLE ADs DAIRLY REPORT</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a class="btn btn-soft-dark btn-sm">Print </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <table class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th class="sort" data-sort="MAIL CODE">DATE</th>
                            <th class="sort" data-sort="IN MAILS">IN MAILS</th>
                            <th class="sort" data-sort="OUT MAILS">OUT MAILS</th>
                            <th class="sort" data-sort="BALANCE">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($googleReports as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('F d, Y') }}</td>
                            <td>{{ $item->inMails }}</td>
                            <td>{{ $item->outMails }}</td>
                            <td>{{ $item->balance }}</td>
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
@if($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
        keyboard: false
    })
    myModal.show()

</script>
@endif
<script>
    $(document).ready(function () {
        $(".phoneNumber").on("input", function () {
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
