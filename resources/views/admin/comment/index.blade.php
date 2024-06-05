@extends('layouts.admin.app')
@section('page-name')Comment Registration @endsection
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

                <h4 class="mb-sm-0">Comment Registration</h4>


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Comment Registration</li>
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

                                <h5 class="card-title mb-0">COMMENTS LIST</h5>

                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions"
                                    onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>

                                    <button type="button" class="btn btn-success add-btn"
                                        data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i>New
                                        Comment
                                    </button>


                                {{-- <button type="button" class="btn btn-info">
                                    <i class="ri-file-download-line align-bottom me-1"></i>
                                    Import
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        style="width: 100%;">
                        <thead>

                                    <tr>
                                        <th scope="col" style="width: 80px">
                                           #
                                        </th>

                                        <th class="sort" data-sort="MAIL CODE">
                                            Comment Name
                                        </th>
                                        <th class="sort" data-sort="DATE">DATE</th>
                                        <th class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($comments as $key => $comment)
                                    <tr>
                                        <th scope="row">
                                             {{ $key + 1 }}
                                        </th>
                                        <td class="MAIL CODE"><a href="">{{ $comment->name }}</a></td>


                                        <td class="date"> {{ $comment->created_at->format('d M, Y') }}</td>


                                        <td>

                                            <a href="#showModal{{ $comment->id }}" data-bs-toggle="modal" type="button"
                                                class="btn btn-primary btn-sm"><span>Edit</span></a>

                                            <div class="modal fade" id="showModal{{ $comment->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light p-3">
                                                            <h5 class="modal-title">COMMENT INFORMATION UPDATE</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close" id="close-modal"></button>
                                                        </div>
                                                        <form class="tablelist-form" id="myForm" method="post" action="{{ route('admin.comments.updates',$comment->id) }}">
                                                            @csrf
                                                            @method('PUT')
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
                                                                    <label for="customername-field" class="form-label">Comment Name
                                                                        </label>
                                                                    <input type="text" id="customername-field" name="name"
                                                                        class="form-control" placeholder="Enter Comment Name"
                                                                        value="{{ $comment->name }} {{ old('name') }}" autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter a Tracting Number .
                                                                    </div>
                                                                </div>
                                                            <div class="modal-footer">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-success"
                                                                        id="add-btn" onclick="submitForm()">
                                                                        UPDATE
                                                                    </button>
                                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Comment Registration</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close" id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" method="post" action="{{ route('admin.comments.store') }}">
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
                                            <label for="customername-field" class="form-label">Comment
                                                Name</label>
                                            <input type="text" id="customername-field" name="name"
                                                class="form-control" placeholder="Enter Comment Name"
                                                value="{{ old('name') }}" autocomplete="off" />
                                            <div class="invalid-feedback">
                                                Please enter a Tracting Number .
                                            </div>
                                        </div>

                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-success" id="add-btn">
                                                Save
                                            </button>
                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                        </div>
                                    </div>
                                </form>
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


        });
    });

</script>

@endsection
