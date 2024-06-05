@extends('layouts.admin.app')
@section('page-name')Route @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Routes List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS </a>
                    </li>
                    <li class="breadcrumb-item active">Routes</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Routes List</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex align-items-center gap-3">
                            <a href="" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#showModal"><i
                                    class="mdi mdi-plus"></i> New Route</a>
                                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light p-3">
                                                    <h5 class="modal-title">Add New Route</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" method="post" action="{{ route('driver.route.store') }}" onsubmit="disableSubmitButton()">
                                                    @csrf
                                                    <div class="modal-body">
                                                        @if($errors->any())
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
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="name-field" class="form-label">Plate Number</label>
                                                                <input type="text" class="form-control" value="{{ auth()->user()->vehicles->plate_number }}"
                                                                    disabled id="name-field" required>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="phone-field" class="form-label">Vihiacle Name</label>
                                                                <input type="text" class="form-control" value="{{ auth()->user()->vehicles->name }}"
                                                                    disabled id="phone-field" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="name-field" class="form-label">Out KM</label>
                                                            <input type="text" class="form-control kilometer" name="km_out" required>
                                                            <input type="hidden" name="vehicle_id" value="{{ auth()->user()->vehicle_id }}">

                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="phone-field" class="form-label">Destination</label>
                                                            <input type="text" class="form-control" name="destination" required>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" class="btn btn-success" id="submitButton">
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
                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%;">
                    <thead>
                        <tr>
                            <th scope="col">
                                #
                            </th>

                            <th class="sort" data-sort="name">
                                Vehicle
                            </th>
                            <th class="sort" data-sort="phone">Plate Number </th>
                            <th class="sort" data-sort="branch">KM Out</th>
                            <th class="sort" data-sort="out">Time Out</th>
                            <th class="sort" data-sort="date">KM In</th>
                            <th class="sort" data-sort="date">Time In</th>
                            <th class="sort" data-sort="date">Differ KM</th>
                            <th class="sort" data-sort="date">Destination</th>
                            <th class="sort" data-sort="date">Action </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $key => $item)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $item->vehicles->name }}
                            </td>
                            <td>
                                {{ $item->vehicles->plate_number }}
                            </td>
                            <td>
                                {{ $item->km_out }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('D, d M Y H:i:s') }}
                            </td>
                            <td>
                                {{ $item->km_in }}
                            </td>
                            <td>
                                @if ($item->date_returned)
                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->date_returned)->format('D, d M Y H:i:s') }}
                                @endif
                            </td>
                            <td>
                                @if (!$item->km_in)
                                -
                                @else
                                {{ $item->km_in - $item->km_out }}
                                @endif
                            </td>
                            <td>
                                {{ $item->destination  }}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li><button class="dropdown-item @if($key > 0) disabled @endif" data-bs-toggle="modal" data-bs-target="#showModal{{ $item->id }}"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit</button></li>
                                        <li><a class="dropdown-item @if($key > 0) disabled @endif" data-bs-toggle="modal" data-bs-target="#kmIn{{ $item->id }}" href="javascript:void(0);"><i class="ri-download-2-line align-bottom me-2 text-muted"></i>
                                                km in</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item remove-item-btn" data-bs-toggle="modal" data-bs-target="#deleteOrder{{ $item->id }}" href="#">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal fade" id="kmIn{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title">Kilometer In</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" method="post" action="{{ route('driver.route.kmIn',$item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    @if($errors->any())
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
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="name-field" class="form-label">Plate Number</label>
                                                            <input type="text" class="form-control" value="{{ auth()->user()->vehicles->plate_number }}"
                                                                disabled id="name-field" required>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="phone-field" class="form-label">Vihiacle Name</label>
                                                            <input type="text" class="form-control" value="{{ auth()->user()->vehicles->name }}"
                                                                disabled id="phone-field" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name-field" class="form-label">In KM</label>
                                                        <input type="text" class="form-control kilometer" name="km_in" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="showModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title">Update Route</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" method="post" action="{{ route('driver.route.update',$item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    @if($errors->any())
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
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="name-field" class="form-label">Plate Number</label>
                                                            <input type="text" class="form-control" value="{{ auth()->user()->vehicles->plate_number }}"
                                                                disabled id="name-field" required>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="phone-field" class="form-label">Vihiacle Name</label>
                                                            <input type="text" class="form-control" value="{{ auth()->user()->vehicles->name }}"
                                                                disabled id="phone-field" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name-field" class="form-label">Out KM</label>
                                                        <input type="text" class="form-control kilometer" name="km_out" value="{{ $item->km_out }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="phone-field" class="form-label">Destination</label>
                                                        <input type="text" class="form-control" name="destination" value="{{ $item->destination }}" required>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade zoomIn" id="deleteOrder{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('driver.route.destroy',$item->id) }}">
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
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')


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
    $(document).ready(function () {
        $(".kilometer").on("input", function () {
            var value = $(this).val();
            var decimalRegex = /^[0-9.]+(\.[0-9]{1,2})?$/;
            if (!decimalRegex.test(value)) {
                $(this).val(value.substring(0, value.length - 1));
            }
        });
    });

</script>
<script>
    function disableSubmitButton() {
    document.getElementById('submitButton').disabled = true;
    }
    </script>
@endsection
