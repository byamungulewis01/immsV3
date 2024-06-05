@extends('layouts.admin.app')
@section('page-name')Purchase Report @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-purchases-center justify-content-between">
            <h4 class="mb-sm-0">Purchase Report</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">Purchase Report</li>
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
                <div class="row g-4 align-purchases-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">PURCHASE ITEM LIST</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="scroll-horizontal" class="table table-bordered nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">
                                #
                            </th>
                            <th class="sort" data-sort="code">
                                Invoice number
                            </th>
                            <th class="sort" data-sort="created_at">Purchase Date</th>
                            <th class="sort" data-sort="quantity">Quantity</th>
                            <th class="sort" data-sort="supplier">Suppplier</th>
                            <th class="sort" data-sort="Amount">Amount</th>
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total = 0;
                        @endphp
                        @foreach ($purchases as $key => $purchase)
                        @php
                        $total += $purchase->total;
                        @endphp
                        <tr>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="code"><a
                                    href="{{ route('admin.item.profile',$purchase->code) }}">{{ $purchase->code }}</a>
                            </td>
                            
                            <td class="created_at">{{ $purchase->created_at }}</td>
                            <td class="quantity">{{ $purchase->quantity }}</td>
                            <td class="supplier">
                                @php
                                $supplier = App\Models\Supplier::where('id',$purchase->supplier_id)->first();
                                @endphp
                                {{ $supplier->suppliername }}
                            </td>
                            <td class="Amount">{{ $purchase->total }}</td>
                            <td>
                                @can('update purchase')
                                <a type="button" class="btn btn-primary btn-sm edit-item"
                                        data-name="{{ $purchase->name }}"
                                        data-category="{{ $purchase->category }}"
                                        data-purchasingprice="{{ $purchase->purchasingprice }}"
                                        data-sellingprice="{{ $purchase->sellingprice }}"
                                        data-description="{{ $purchase->description }}"
                                        data-id="{{ $purchase->item_id }}"
                                        data-action="{{ route('admin.item.update',$purchase->item_id) }}"
                                        data-bs-toggle="modal" data-bs-target="#updatemodal"
                                        ><span>Edit</span></a>
                                @endcan

                                @can('delete purchase')
                                <a href="#deleteRecordModal" data-bs-toggle="modal" type="button" data-action="{{ route('admin.item.destroy', $purchase->item_id) }}"
                                    class="btn btn-danger btn-sm delete-item"><span>Delete</span></a>
                                @endcan

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">TOTAL AMOUNT PURCHASE:</td>
                            <td>{{ $total }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->


<!-- Modal -->
<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteitem" method="post" action="#">
                    @csrf
                    @method('DELETE')
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width: 100px; height: 100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">
                                Are you sure you want to remove this record ?
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn w-sm btn-danger" id="delete-record">
                            Yes, Delete It!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end modal -->

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

<!--datatable js-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script>
    // check if data loaded fully
    $(document).ready(function () {
        // update item delete modal with clicked button data
        $(document).on('click', '.delete-item', function () {
            // var itemid = $(this).data('itemid');
            var formaction = $(this).data('action');
            $('#deleteitem').attr('action', formaction);
            // $('#itemid').val(itemid);
        });
    });

</script>
@endsection
