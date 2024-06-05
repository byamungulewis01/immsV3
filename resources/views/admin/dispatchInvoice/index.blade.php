@extends('layouts.admin.app')
@section('page-name')Customer Invoice @endsection
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
            <h4 class="mb-sm-0">Customer Invoice </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">Customer Invoice</li>
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
                            <h5 class="card-title mb-0">CUSTOMER INVOICE</h5>
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
                            <th class="sort" data-sort="pob">P.O BOX </th>
                            <th class="sort" data-sort="names">NAMES</th>
                            <th class="sort" data-sort="email">EMAIL</th>
                            <th class="sort" data-sort="phone">PHONE</th>
                            <th class="sort" data-sort="category">CATEGORY</th>
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
        $('#datatableAjax').DataTable({

            processing: true,
            scrollX: true,
            ajax: "{{ route('dispatchInvoice.api') }}",
            columns: [ { data: 'id'},{ data: 'pob' },{ data: 'name'},{ data: 'email' },{ data: 'phone' },
                { data: 'pob_category' },{ data: ''  },
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: function (data, type, row, meta) {
                        return (meta.row) + 1;
                    }
                },
                {
                    targets: 1,
                    render: function (data, type, row, meta) {
                        var branch = row.branch;
                        return row.pob + ' - ' + branch.name;
                    }
                }
                ,
                {
                    targets: 6,
                    render: function (data, type, row, meta) {
                        var id = row.id;
                        var route = "{{ route('admin.dispatchInvoice.show', ['id' => ':id']) }}";
                        route = route.replace(':id', id);
                        var link = `<a href="${route}" class="btn btn-sm btn-primary"> Invoice </a>`;
                        return link;
                    }
                }
            ],
            order: [],
            dom: 'Bfrtip',
            buttons: [{ extend: 'print',  title: 'Client list', exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
                    customize: function (win)
                    { $(win.document.body).css('font-size', '10pt');
                      $(win.document.body).find('table').addClass('table-bordered').css('font-size', 'inherit');
                    }
                },
                { extend: 'excel', title: 'Client list', exportOptions: { columns: [0, 1, 2, 3, 4, 5] } },
                { extend: 'pdf', title: 'Client list', exportOptions: { columns: [0, 1, 2, 3, 4, 5] } },
                { extend: 'csv', title: 'Client list', exportOptions: { columns: [0, 1, 2, 3, 4, 5] } },
            ],
        });
    });

</script>
@endsection
