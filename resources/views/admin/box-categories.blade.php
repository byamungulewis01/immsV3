@extends('layouts.admin.app')
@section('page-name')
    Box Categories
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Box Categories</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS P.O B</a>
                        </li>
                        <li class="breadcrumb-item active">Box Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-6">
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">Box Categories List</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">

                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal">
                                    <i class="ri-add-line align-bottom me-1"></i> Add
                                    Category
                                </button>
                                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title">Category Registration</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>

                                            <form class="tablelist-form" method="post"
                                                action="{{ route('admin.box-categories.store') }}">
                                                @csrf
                                                <div class="modal-body">
                                                    @if ($errors->any())
                                                        <div class="mb-3">
                                                            <div class="alert alert-danger">
                                                                <p><strong>Opps Something went wrong</strong></p>
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>* {{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="mb-3">
                                                        <label for="customername-field" class="form-label">Category
                                                            Name</label>
                                                        <input type="text" id="customername-field" class="form-control"
                                                            placeholder="Enter name" name="name" required
                                                            value="{{ old('name') }}" />

                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success" id="add-btn">
                                                            Add Category
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col" style="width: 80px">
                                            #
                                        </th>

                                        <th class="sort" data-sort="name">
                                            Category Name
                                        </th>

                                        <th class="sort" data-sort="action" style="width: 140px">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($categories as $key => $category)
                                        <tr>
                                            <th scope="row">
                                                N<sub>#</sub> {{ $key + 1 }}
                                            </th>
                                            <td class="name">{{ $category->name }}</td>
                                            <td>
                                                <a href="#showModal{{ $category->id }}" data-bs-toggle="modal"
                                                    type="button" class="btn btn-primary btn-sm"><span>Edit</span></a>
                                                <div class="modal fade" id="showModal{{ $category->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-light p-3">
                                                                <h5 class="modal-title">Category Modification</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"
                                                                    id="close-modal"></button>
                                                            </div>
                                                            <form class="tablelist-form" id="myForm" method="post"
                                                                action="{{ route('admin.box-categories.update', $category->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">

                                                                    @if ($errors->any())
                                                                        <div class="mb-3">
                                                                            <div class="alert alert-danger">
                                                                                <p><strong>Opps Something went
                                                                                        wrong</strong></p>
                                                                                <ul>
                                                                                    @foreach ($errors->all() as $error)
                                                                                        <li>* {{ $error }}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    <div class="mb-3">

                                                                        <label for="customername-field"
                                                                            class="form-label">Category
                                                                            Name</label>
                                                                        <input type="text" id="customername-field"
                                                                            class="form-control" placeholder="Enter name"
                                                                            id="name" name="name" required
                                                                            value="{{ old('name', $category->name) }}" />

                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-light"
                                                                            data-bs-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit" class="btn btn-success"
                                                                            id="add-btn" >
                                                                            Edit Category
                                                                        </button>
                                                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="#deleteRecordModal{{ $category->id }}" data-bs-toggle="modal"
                                                    type="button" class="btn btn-danger btn-sm"><span>Delete</span></a>

                                                <!-- Modal -->
                                                <div class="modal fade zoomIn" id="deleteRecordModal{{ $category->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close"
                                                                    id="deleteRecord-close" data-bs-dismiss="modal"
                                                                    aria-label="Close" id="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post"
                                                                    action="{{ route('admin.box-categories.destroy', $category->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="mt-2 text-center">
                                                                        <lord-icon
                                                                            src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                            trigger="loop"
                                                                            colors="primary:#f7b84b,secondary:#f06548"
                                                                            style="width: 100px; height: 100px"></lord-icon>
                                                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                            <h4>Are you sure ?</h4>
                                                                            <p class="text-muted mx-4 mb-0">
                                                                                Are you sure you want to remove this record
                                                                                ?
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                        <button type="button" class="btn w-sm btn-light"
                                                                            data-bs-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit" class="btn w-sm btn-danger"
                                                                            id="delete-record">
                                                                            Yes, Delete It!
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end modal -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
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
@endsection
