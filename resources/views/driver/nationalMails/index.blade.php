@extends('layouts.admin.app')
@section('page-name')National Mails @endsection
@section('body')
@php
    use App\Models\Box;
@endphp

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">National Mails</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS </a>
                    </li>
                    <li class="breadcrumb-item active">National Mails</li>
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
                            <h5 class="card-title mb-0">National Mails</h5>
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

                                <th class="sort" data-sort="sender">
                                    SENDER</th>

                                <th class="sort" data-sort="amount">
                                    SENDER PHONE</th>

                                <th class="sort" data-sort="status">
                                    SENDER EMAIL </th>

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
                                    <input type="text" class="form-control form-control-sm apikey-value" readonly
                                        value="{{ $myMail->mailsNumber }}">
                                </td>

                                <td>
                                    {{ $myMail->senderName }}
                                </td>

                                <td>
                                    {{ $myMail->senderPhone }}
                                </td>

                                <td>
                                    {{ Box::where('pob',$myMail->senderPOBox)->first()->email }}
                                </td>

                                <td>

                                    <a href=""
                                        class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#topmodal{{ $myMail->id }}">Assign</a>
                                        <div id="topmodal{{ $myMail->id }}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center p-5">

                                                            <div class="text-muted text-center mx-lg-3">
                                                                <h4 class="">Driver Assignment</h4>
                                                                <p>Assign this mail to a driver to pick it up from sender</p>
                                                            </div>

                                                            <div class="mt-4">
                                                                <form action="{{ route('driver.nationalMails.assignMail',$myMail->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="mb-3">
                                                                        {{-- select driver --}}
                                                                        <select class="form-select" name="driver" aria-label="Default select example">
                                                                            <option selected>Select Driver</option>
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
