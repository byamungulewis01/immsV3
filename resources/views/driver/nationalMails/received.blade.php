@extends('layouts.admin.app')
@section('page-name')Received Mails @endsection
@section('body')
@php
    use App\Models\Box;
@endphp

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Received Mails</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS </a>
                    </li>
                    <li class="breadcrumb-item active">Received Mails</li>
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
                            <h5 class="card-title mb-0">Received Mails</h5>
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
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col" style="width: 60px">
                                    #
                                </th>
                                <th class="sort" style="width: 160px" data-sort="names">
                                    DISPATCH NUMBER</th>

                                <th class="sort" data-sort="date">
                                    DATE </th>

                                <th class="sort" style="width: 90px" data-sort="names">
                                    MAILS N<sup>0</sup></th>

                                <th class="sort" style="width: 90px" data-sort="weight">
                                    WEIGHT</th>

                                <th class="sort" data-sort="sender">
                                    SENDER</th>

                                <th class="sort" data-sort="amount">
                                    SENDER PHONE</th>

                                <th class="sort" data-sort="action">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($myMails as $myMail)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <a href="#">{{ $myMail->dispatchNumber }}
                                    </a>

                                </td>
                                <td>{{ \Carbon\Carbon::parse($myMail->created_at)->locale('fr')->format('F j, Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-soft-success text-success">
                                        {{ $myMail->mailsNumber }}
                                    </span>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm apikey-value" readonly
                                        value="{{ $myMail->weight }}">
                                </td>

                                <td>
                                    {{ $myMail->senderName }}
                                </td>

                                <td>
                                    {{ $myMail->senderPhone }}
                                </td>

                                <td>  <a href="{{ route('driver.nationalMails.details',encrypt($myMail->id)) }}" class="btn btn-soft-info btn-sm">Dispatch</a>  </td>

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
<script>
    $(document).ready(function() {
        $('#scroll-horizontal').DataTable({
            "scrollX": true,
        });
    });
</script>

@endsection
