@extends('layouts.admin.app')
@section('page-name')
    Items
@endsection
@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Items</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mails</a>
                        </li>
                        <li class="breadcrumb-item active">Items</li>
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
                                <h5 class="card-title mb-0">Items List</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
                                @can('create item')
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i> New
                                        Item
                                    </button>
                                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog model-lg">
                                            <div class="modal-content">
                                                <div class="modal-header p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Item Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" method="post"
                                                    action="{{ route('admin.item.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            @if ($errors->any())
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
                                                            <label for="item-field" class="form-label">
                                                                Name</label>
                                                            <input type="text" id="item-field" name="name"
                                                                class="form-control" placeholder="Enter Item name"
                                                                value="{{ old('name') }}" required />
                                                            <div class="invalid-feedback">
                                                                Please enter a item name.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="category-field" class="form-label">Category</label>

                                                            <select class="form-select category" name="category" required id="category-id">
                                                                <option value="">Select Category</option>
                                                                <option value="cartonEnvilop">Carton & Envilop</option>
                                                                <option value="stamps">Stamps</option>
                                                                <option value="postCard">Post Card</option>
                                                                <option value="service">Service</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Please enter Category.
                                                            </div>

                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="purchasingprice-field" class="form-label">
                                                                Purchasing Price</label>
                                                            <input type="text" id="purchasingprice-field"
                                                                name="purchasingprice" class="form-control"
                                                                placeholder="Enter Item Purchasing Price"
                                                                value="{{ old('purchasingprice') }}" />

                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="sellingprice-field" class="form-label">
                                                                Selling Price</label>
                                                            <input type="text" id="sellingprice-field" name="sellingprice"
                                                                class="form-control" placeholder="Enter Item Selling Price"
                                                                value="{{ old('sellingprice') }}" />
                                                        
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description-field" class="form-label">
                                                                Description</label>
                                                            <input type="text" id="description-field" name="description"
                                                                class="form-control" placeholder="Enter Item Description"
                                                                value="{{ old('description') }}" required />
                                                            <div class="invalid-feedback">
                                                                Please enter Description.
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" class="btn btn-success" id="add-btn">
                                                                Add Item
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
                                    Item Name
                                </th>
                                <th class="sort" data-sort="category">Category</th>
                                <th class="sort" data-sort="purchasingprice">Purchasing Price</th>
                                <th class="sort" data-sort="sellingprice">Selling Price</th>
                                <th class="sort" data-sort="description">Item Description</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $key => $item)
                                <tr>
                                    <td scope="row">
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="name">{{ $item->name }}</td>
                                    <td class="category">{{ ucfirst($item->category) }}</td>
                                    <td class="purchasingprice">{{ $item->purchasingprice }}</td>
                                    <td class="sellingprice">{{ $item->sellingprice }}</td>
                                    <td class="desc">{{ $item->description }}</td>
                                    <td>
                                        @can('update item')
                                            <a type="button" class="btn btn-primary btn-sm edit-item"
                                                data-name="{{ $item->name }}" data-category="{{ $item->category }}"
                                                data-purchasingprice="{{ $item->purchasingprice }}"
                                                data-sellingprice="{{ $item->sellingprice }}"
                                                data-description="{{ $item->description }}" data-id="{{ $item->item_id }}"
                                                data-action="{{ route('admin.item.update', $item->item_id) }}"
                                                data-bs-toggle="modal" data-bs-target="#updatemodal"><span>Edit</span></a>
                                        @endcan

                                        @can('delete item')
                                            <a href="#deleteRecordModal" data-bs-toggle="modal" type="button"
                                                data-action="{{ route('admin.item.destroy', $item->item_id) }}"
                                                class="btn btn-danger btn-sm delete-item"><span>Delete</span></a>
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
                    <form id="deleteitem" method="post" action="#">
                        @csrf
                        @method('DELETE')
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f7b84b,secondary:#f06548"
                                style="width: 100px; height: 100px"></lord-icon>
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

    @can('update item')
        <!-- Modal -->
        <div class="modal fade zoomIn" id="updatemodal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" id="updatemodal-close" data-bs-dismiss="modal"
                            aria-label="Close" id="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="itemupdate" action="#">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                @if ($errors->any())
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
                                <label for="edititem-field" class="form-label">
                                    Name</label>
                                <input type="text" id="edititem-field" name="editname" class="form-control"
                                    placeholder="Enter Item name" value="{{ old('editname') }}" required />
                                <div class="invalid-feedback">
                                    Please enter a item name.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="editcategory-field" class="form-label">Category</label>

                                <select class="form-control category" name="editcategory" id="editcategory-id">
                                    <option value="">Select Category</option>
                                    <option {{ old('editcategory') == 'cartonEnvilop' ? 'selected' : '' }} value="cartonEnvilop">Carton & Envilop</option>
                                    <option {{ old('editcategory') == 'stamps' ? 'selected' : '' }} value="stamps">Stamps</option>
                                    <option {{ old('editcategory') == 'postCard' ? 'selected' : '' }} value="postCard">Post Card</option>
                                    <option {{ old('editcategory') == 'service' ? 'selected' : '' }} value="service">Service</option>
                                    <option {{ old('editcategory') == 'other' ? 'selected' : '' }} value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editpurchasingprice-field" class="form-label">
                                    Purchasing Price</label>
                                <input type="text" id="editpurchasingprice-field" name="editpurchasingprice"
                                    class="form-control" placeholder="Enter Item Purchasing Price"
                                    value="{{ old('editpurchasingprice') }}" />
                                <div class="invalid-feedback">
                                    Please enter Purchasing Price.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="editsellingprice-field" class="form-label">
                                    Selling Price</label>
                                <input type="text" id="editsellingprice-field" name="editsellingprice"
                                    class="form-control" placeholder="Enter Item Selling Price"
                                    value="{{ old('editsellingprice') }}"  />
                                <div class="invalid-feedback">
                                    Please enter Selling Price.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="editdescription-field" class="form-label">
                                    Description</label>
                                <input type="text" id="editdescription-field" name="editdescription" class="form-control"
                                    placeholder="Enter Item Description" value="{{ old('editdescription') }}" required />
                                <div class="invalid-feedback">
                                    Please enter Description.
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-success" id="add-btn">
                                Save Item Info
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
        $(document).ready(function() {
            // update item delete modal with clicked button data
            $(document).on('click', '.delete-item', function() {
                // var itemid = $(this).data('itemid');
                var formaction = $(this).data('action');
                $('#deleteitem').attr('action', formaction);
                // $('#itemid').val(itemid);
            });

            // update updateitem modl with clicked button data
            $(document).on('click', '.edit-item', function() {
                var itemid = $(this).data('item_id');
                var itemname = $(this).data('name');
                var itemcategory = $(this).data('category');
                var itempurchasingprice = $(this).data('purchasingprice');
                var itemsellingprice = $(this).data('sellingprice');
                var itemdescription = $(this).data('description');
                var formaction = $(this).data('action');
                $('#itemupdate').attr('action', formaction);
                $('#edititem-field').val(itemname);
                $('#editcategory-id').val(itemcategory);
                $('#editpurchasingprice-field').val(itempurchasingprice);
                $('#editsellingprice-field').val(itemsellingprice);
                $('#editdescription-field').val(itemdescription);
            });
        });
    </script>
@endsection
