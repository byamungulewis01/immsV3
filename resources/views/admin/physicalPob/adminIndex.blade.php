@extends('layouts.admin.app')
@section('page-name')Physical P.O Box @endsection
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
                    <li class="breadcrumb-item active">Physical P.O Box</li>
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

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                    style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 40px">#</th>
                            <th class="sort" data-sort="pob">P.OB </th>
                            <th class="sort" data-sort="names">NAMES</th>
                            <th class="sort" data-sort="phone">PHONE </th>
                            <th class="sort" data-sort="type">TYPE</th>
                            <th class="sort" data-sort="size">SIZE</th>
                            <th class="sort" data-sort="date">DATE</th>
                            <th class="sort" data-sort="status"> STATUS</th>
                            <th class="sort" data-sort="action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
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
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function () {
        let branchId = "{{ auth()->user()->branch }}";
        $('#datatableAjax').DataTable({

            processing: true,
            scrollX: true,
            ajax: "{{ route('admin.physicalPob.pobApi', ['id' => ':branchId']) }}".replace(':branchId', branchId),
            columns: [
                { data: 'id'},
                { data: 'pob' },
                { data: 'name'},
                { data: 'phone' },
                { data: 'pob_type' },
                { data: 'size' },
                { data: 'date' },
                { data: 'status' },
                { data: ''  },
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: function (data, type, row, meta) {
                        return (meta.row) + 1;
                    }
                },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        // current year
                        var currentYear = new Date().getFullYear();
                        if (row.year >= currentYear) {
                            return '<span class="badge bg-success text-uppercase">Paid</span>';
                        } else {
                            return '<span class="badge bg-danger text-uppercase">Unpaid</span>';
                        }
                    },
                },
                {
                    targets: 8,
                    render: function (data, type, row, meta) {
                        var boxId = row.id;
                        var route = "{{ route('physicalPob.details', ['id' => ':id']) }}";
                        route = route.replace(':id', boxId);
                        var link = `<a href="${route}" class="btn btn-primary btn-sm"><span>P.O B Info</span></a>`;
                        return link;
                     }
                },
            ],
            order: [],
        });
    });

</script>
@endsection
