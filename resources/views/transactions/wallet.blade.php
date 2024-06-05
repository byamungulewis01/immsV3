@extends('layouts.admin.app')
@section('page-name')
    Wallet
@endsection
@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Wallet</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Wallet</a>
                        </li>
                        <li class="breadcrumb-item active">All Wallet</li>
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
                                <h5 class="card-title mb-0">Wallet</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">

                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal">
                                    <i class="ri-add-line align-bottom me-1"></i> New Wallet
                                </button>
                                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog model-lg">
                                        <div class="modal-content">
                                            <div class="modal-header p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">New Wallet</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" method="post"
                                                action="{{ route('admin.wallet.store') }}" enctype="multipart/form-data">
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
                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <label for="amount"> Amount </label>
                                                            <input id="amount" type="number" name="amount"
                                                                class="form-control" value="{{ old('amount') }}"
                                                                aria-describedby="amount">
                                                        </div>

                                                        <div class="col-md-12 mb-2">
                                                            <label for="file">Attachment</label>
                                                            <input id="file" type="file" name="file"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <label for="customer-phone">Description</label>
                                                            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
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
                                                            Submit
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
                    <table id="datatable" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Attachment</th>
                                <th>Commission (3%)</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wallets as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->created_at->format('Y M d') }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td><a target="_black" href="{{ asset('wallets/' . $item->attachment) }}"
                                            class="btn btn-sm btn-primary"><i class="ri-download-fill align-middle"></i>
                                            Download</a></td>
                                    <td>{{ $item->amount * 0.3 }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <span class="badge bg-warning text-uppercase">Pending</span>
                                        @elseif($item->status == 'approved')
                                            <span class="badge bg-success text-uppercase">approved</span>
                                        @else
                                            <span class="badge bg-danger text-uppercase">rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="">

                                                    <li><button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#approve{{ $item->id }}"
                                                            href="javascript:void(0);"><i
                                                                class="ri-check-fill align-bottom me-2 text-muted"></i>
                                                            Approve</button></li>

                                                    <li><button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#reject{{ $item->id }}"
                                                            href="javascript:void(0);"><i
                                                                class="ri-close-fill align-bottom me-2 text-muted"></i>
                                                            Reject</button></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}"
                                                            href="javascript:void(0);"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            Edit</button></li>

                                                    <li>
                                                        <button data-bs-target="#deleteRecordModal{{ $item->id }}" class="dropdown-item remove-item-btn" data-bs-toggle="modal"
                                                            >
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog model-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Wallet</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close" id="close-modal"></button>
                                                    </div>
                                                    <form class="tablelist-form" method="post"
                                                        action="{{ route('admin.wallet.update', $item->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
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
                                                            <div class="row">
                                                                <div class="col-md-12 mb-2">
                                                                    <label for="amount"> Amount </label>
                                                                    <input id="amount"
                                                                        value="{{ old('amount', $item->amount) }}"
                                                                        type="number" name="amount"
                                                                        class="form-control" aria-describedby="amount">
                                                                </div>

                                                                <div class="col-md-12 mb-2">
                                                                    <label for="file">Attachment</label>
                                                                    <input id="file" type="file" name="file"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="col-md-12 mb-2">
                                                                    <label for="customer-phone">Description</label>
                                                                    <textarea name="description" class="form-control" rows="2">{{ old('description', $item->description) }}</textarea>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-success">
                                                                    Save Change
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="approve{{ $item->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog model-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3">

                                                    </div>
                                                    <form class="tablelist-form" method="post"
                                                        action="{{ route('admin.wallet.approval', $item->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12 text-center">
                                                                    <h3>Are you sure to approve wallet ?</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-success">
                                                                    Yes Approve
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="reject{{ $item->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog model-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3">

                                                    </div>
                                                    <form class="tablelist-form" method="post"
                                                        action="{{ route('admin.wallet.reject', $item->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12 text-center">
                                                                    <h3>Are you sure to reject wallet ?</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-success">
                                                                    Yes Approve
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade zoomIn" id="deleteRecordModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                                            aria-label="Close" id="btn-close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form  method="post" action="{{ route('admin.wallet.destroy',$item->id) }}">
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
    {{-- <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
    @if (old('id'))
        @if ($errors->any())
            <script>
                var myModal = new bootstrap.Modal(document.getElementById('editUser'), {
                    keyboard: false
                })
                myModal.show()
            </script>
        @endif
    @else
        @if ($errors->any())
            <script>
                var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
                    keyboard: false
                })
                myModal.show()
            </script>
        @endif
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
    {{-- <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
