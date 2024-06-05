@extends('layouts.admin.app')
@section('page-name')Virtual P.O Box @endsection
@section('body')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Virtual P.O Box</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">Virtual P.O Box</li>
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
                            <h5 class="card-title mb-0">Virtual P.O BOX</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                    style="width: 100%;">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col" style="width: 40px">
                                #
                            </th>

                            <th class="sort" data-sort="pob">
                                P.OB </th>
                            <th class="sort" data-sort="names">
                                NAMES</th>

                            <th class="sort" data-sort="phone">
                                PHONE </th>

                            <th class="sort" data-sort="type">
                                CATEGORY </th>
                            <th class="sort" data-sort="date">
                                DATE</th>
                            <th class="sort" data-sort="status">
                                STATUS</th>

                            <th class="sort" data-sort="action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach ($boxes as $key => $box)
                        <tr>
                            <th scope="row">{{ $key+1 }}
                            </th>
                            <td class="pob">+250{{ $box->pob }}</td>
                            <td class="names">{{ $box->name }}</td>
                            <td class="phone">{{ $box->phone }}</td>
                            <td class="type">{{ $box->pob_category }}</td>
                            <td class="date">{{ $box->date }}</td>
                            <td class="status">
                                @if ($box->year >= now()->year)
                                <span class="badge bg-success">Paid</span>
                                @else
                                <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </td>


                            <td>
                                <a href="{{ route('virtualPob.details',encrypt($box->id)) }}"
                                    class="btn btn-primary btn-sm"><span>P.O B Info</span></a>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<!--end col-->
</div>
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
