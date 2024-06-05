@extends('layouts.admin.app')
@section('page-name') P.O Box @endsection
@section('body')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">P.O Box</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">P.O Box</li>
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
                            <h5 class="card-title mb-0">P.O Box List</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">

                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Add
                                P.O Box
                            </button>
                            <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title">Add POB</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" method="post" action="{{ route('admin.box.store') }}">
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
                                                    <label for="status-field" class="form-label">Branch Name</label>
                                                    <select class="form-control" data-choices
                                                        data-choices-search-false name="branch"
                                                        id="status-field" required>
                                                        <option value="" disabled selected>Select branch name</option>
                                                        @foreach ($branches as $branch)
                                                        <option @if (old('branch') == $branch->id) selected @endif  value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status-field" class="form-label">Size</label>
                                                    <select class="form-control" data-choices
                                                        data-choices-search-false name="size"
                                                        id="status-field" required>
                                                        <option value="" disabled selected>Size</option>
                                                        <option @if (old('Pte') == 'Pte') selected @endif  value="Pte">Pte</option>
                                                        <option @if (old('Gde') == 'Gde') selected @endif  value="Gde">Gde</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">
                                                        Add POB
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
                                    <th scope="col" style="width: 40px">
                                        #
                                    </th>

                                    <th class="sort" data-sort="name">
                                       P.O BOX </th>
                                    <th class="sort" data-sort="branch">
                                       Branch Name </th>

                                    <th class="sort" data-sort="size">
                                       Size </th>

                                    <th class="sort" data-sort="at">
                                       Created At </th>

                                    <th class="sort" data-sort="action" style="width: 130px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($boxes as $key => $box)
                                <tr>
                                    <th scope="row">
                                        N<sub>{{ $key+1 }}</sub>
                                    </th>
                                    <td class="name">P.O BOX {{ $box->pob }}</td>
                                    <td class="branch">{{ $box->branch->name }}</td>
                                    <td class="size">{{ $box->size }}</td>
                                    <td class="at"> {{ $box->created_at->format('d M, Y') }}</td>

                                    <td>
                                        <a href="#showModal{{ $box->id }}" data-bs-toggle="modal" type="button"
                                            class="btn btn-primary btn-sm"><span>Edit</span></a>
                                        <div class="modal fade" id="showModal{{ $box->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light p-3">
                                                        <h5 class="modal-title">Edit P.O Box</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close" id="close-modal"></button>
                                                    </div>
                                                    <form class="tablelist-form" method="post" action="{{ route('admin.box.update',$box->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" id="token" value=""/>
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
                                                                <label for="status-field" class="form-label">Size</label>
                                                                <select class="form-control" data-choices
                                                                    data-choices-search-false name="size"
                                                                    id="status-field" required>
                                                                    <option value="" disabled selected>Size</option>
                                                                    <option @if ($box->size == 'Pte') selected @endif  value="Pte">Pte</option>
                                                                    <option @if ($box->size == 'Gde') selected @endif  value="Gde">Gde</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-success"
                                                                    id="add-btn">
                                                                    Edit P.O Box
                                                                </button>
                                                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="#deleteRecordModal{{ $box->id }}" data-bs-toggle="modal"  type="button" class="btn btn-danger btn-sm"><span>Delete</span></a>

                                        <!-- Modal -->
                                        <div class="modal fade zoomIn" id="deleteRecordModal{{ $box->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" id="deleteRecord-close"
                                                            data-bs-dismiss="modal" aria-label="Close"
                                                            id="btn-close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="{{ route('admin.box.destroy',$box->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                        <div class="mt-2 text-center">
                                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                trigger="loop"
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
<script>
    $(document).ready(function () {
        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.setting.index') }}",
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ]
        });
    });
@endsection
