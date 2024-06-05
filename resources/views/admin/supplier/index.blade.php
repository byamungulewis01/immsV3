@extends('layouts.admin.app')
@section('page-name')Suppliers @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Suppliers</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS Mails</a>
                    </li>
                    <li class="breadcrumb-item active">Suppliers</li>
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
                            <h5 class="card-title mb-0">Suppliers List</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                <i class="ri-delete-bin-2-line"></i>
                            </button>
                            @can('create supplier')
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Add
                                Supplier
                            </button>
                            <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog model-lg">
                                    <div class="modal-content">
                                        <div class="modal-header p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">supplier Registration</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" method="post"
                                            action="{{ route('admin.supplier.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    @if($errors->any())
                                                    <div class="alert alert-danger">
                                                        <p><strong>Opps Something went wrong</strong></p>
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                            <li>* {{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label for="supplier-field" class="form-label">Supplier
                                                        Name</label>
                                                    <input type="text" id="supplier-field" name="suppliername"
                                                        class="form-control" placeholder="Enter Supplier name"
                                                        value="{{ old('suppliername') }}" required />
                                                    <div class="invalid-feedback">
                                                        Please enter a suplier name.
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tin-field" class="form-label">Tin Number</label>
                                                    <input type="tinnumber" id="tin-field" class="form-control"
                                                        name="tinnumber" placeholder="Enter Tin Number" required
                                                        value="{{ old('tinnumber') }}" />
                                                    <div class="invalid-feedback">
                                                        Please enter an Tin Number.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone-field" class="form-label">Phone</label>
                                                    <input type="text" id="phone-field" name="phone"
                                                        class="form-control phoneNumber" minlength="10"
                                                        maxlength="10" placeholder="Enter phone no." required
                                                        value="{{ old('phone') }}" />
                                                    <div class="invalid-feedback">
                                                        Please enter a phone.
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">
                                                        Add Supplier
                                                    </button>
                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @endcan

                            {{-- <button type="button" class="btn btn-info">
                                    <i class="ri-file-download-line align-bottom me-1"></i>
                                    Import
                                </button> --}}
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

                            <th class="sort" data-sort="name">
                                Supplier Name
                            </th>
                            <th class="sort" data-sort="email">Tin Number</th>
                            <th class="sort" data-sort="phone">Phone Number</th>
                            <th class="sort" data-sort="phone">Registed Date</th>
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $key => $supplier)
                        <tr>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="name">{{ $supplier->suppliername }}</td>
                            <td class="tin">{{ $supplier->tinnumber }}</td>
                            <td class="phone">{{ $supplier->phone }}</td>
                            <td class="phone">{{ $supplier->created_at->format('M d,Y') }}</td>
                            <td>
                                @can('update supplier')
                                <a type="button" class="btn btn-primary btn-sm edit-supplier"
                                        data-suppliername="{{ $supplier->suppliername }}" data-tinnumber="{{ $supplier->tinnumber }}"
                                        data-phone="{{ $supplier->phone }}"
                                        data-id="{{ $supplier->id }}"
                                        data-action="{{ route('admin.supplier.update',$supplier->id) }}"
                                        data-bs-toggle="modal" data-bs-target="#updatemodal"
                                        ><span>Edit</span></a>
                                @endcan

                                @can('delete supplier')
                                <a href="#deleteRecordModal" data-bs-toggle="modal" type="button" data-action="{{ route('admin.supplier.destroy',$supplier->id) }}"
                                    class="btn btn-danger btn-sm delete-supplier"><span>Delete</span></a>
                                @endcan

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
<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="deletesupplier" method="post" action="#">
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

@can('update supplier')
<!-- Modal -->
<div class="modal fade zoomIn" id="updatemodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="updatemodal-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="supplierupdate" action="#">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <p><strong>Opps Something went wrong</strong></p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>* {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="edit-supplier-field" class="form-label">Supplier
                            Name</label>
                        <input type="text" id="edit-supplier-field" name="editsuppliername"
                            class="form-control" placeholder="Enter Supplier name"
                            value="{{ old('editsuppliername') }}" required />
                        <div class="invalid-feedback">
                            Please enter a suplier name.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-tin-field" class="form-label">Tin Number</label>
                        <input type="number" id="edit-tin-field" class="form-control"
                            name="edittinnumber" placeholder="Enter Tin Number" required
                            value="{{ old('edittinnumber') }}" />
                        <div class="invalid-feedback">
                            Please enter an Tin Number.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editphone-field" class="form-label">Phone</label>
                        <input type="text" id="editphone-field" name="editphone"
                            class="form-control" minlength="10"
                            maxlength="10" placeholder="Enter phone no." required
                            value="{{ old('editphone') }}" />
                        <div class="invalid-feedback">
                            Please enter a phone.
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-success" id="add-btn">
                        Save Supplier Info
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!--end modal -->
@endcan
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
        // update supplier delete modal with clicked button data
        $(document).on('click', '.delete-supplier', function () {
            // var supplierid = $(this).data('supplierid');
            var formaction = $(this).data('action');
            $('#deletesupplier').attr('action', formaction);
            // $('#supplierid').val(supplierid);
        });
        // update updatesupplier modl with clicked button data
        $(document).on('click', '.edit-supplier', function () {
            // alert("hello m");
            var supplierid = $(this).data('supplierid');
            var suppliername = $(this).data('suppliername');
            var tinnumber = $(this).data('tinnumber');
            var phone = $(this).data('phone');
            var formaction = $(this).data('action');

            $('#supplierupdate').attr('action', formaction);
            $('#edit-supplier-field').val(suppliername);
            $('#edit-tin-field').val(tinnumber);
            $('#editphone-field').val(phone);
        });
    });

</script>
@endsection
