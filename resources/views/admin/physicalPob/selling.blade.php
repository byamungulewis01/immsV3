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
                            <th class="sort" data-sort="size">SIZE</th>
                            <th class="sort" data-sort="cotion">COTION</th>
                            <th class="sort" data-sort="amount"> AMOUNT</th>
                            <th class="sort" data-sort="action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($boxes as $key => $box)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $box->pob }}</td>
                            <td>{{ $box->size }}</td>
                            <td>{{ $box->cotion ? 'Yes':'No' }}</td>
                            <td>{{ $box->amount }}</td>
                            <td>
                                <!-- Grids in modals -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalgrid{{ $box->id }}">
                                    P.O BOX RENT
                                </button>
                                <div class="modal fade" id="exampleModalgrid{{ $box->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalgridLabel">RENTING OF P.O BOX {{ $box->pob }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('physicalPob.pobSellingPut',$box->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row g-3">
                                                        <div class="col-xxl-6">
                                                            <div>
                                                                <label for="firstName" class="form-label">P.O BOX</label>
                                                                <input type="text" class="form-control" id="firstName" value="{{ $box->pob }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <div>
                                                                <label for="name" class="form-label">NAMES</label>
                                                                <input type="text" class="form-control" id="name" name="name" required
                                                                    placeholder="Enter name">
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <div>
                                                                <label for="email" class="form-label">EMAIL</label>
                                                                <input type="text" class="form-control" id="email" name="email" required
                                                                    placeholder="Enter email">
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-6">
                                                            <div>
                                                                <label for="phone" class="form-label">PHONE</label>
                                                                <input type="text" minlength="10" maxlength="10" class="form-control phone" name="phone" required
                                                                    placeholder="Enter phone">
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-6">
                                                            <div>
                                                                <label for="lastName" class="form-label">P.O BOX TYPE</label>
                                                                    <select class="form-select" name="category" required>
                                                                        <option value="" selected disabled> -- Please Select Box Type -- </option>
                                                                        <option value="Individual">Individual</option>
                                                                        <option value="Ambassade">Ambassade</option>
                                                                        <option value="Banque">Banque</option>
                                                                        <option value="Company">Company</option>
                                                                        <option value="Eglise">Eglise</option>
                                                                        <option value="Gov Institutions">Gov Institutions</option>
                                                                        <option value="Non-Governmental Organisation">Non-Governmental Organisation</option>
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row-->
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
    // phone
    $(document).ready(function () {
        $('.phone').mask('000 000 000');
    });
</script>

<script>
    $(document).ready(function () {
    $('#datatableAjax').DataTable({
        scrollX: true,
    });
});

</script>
@endsection
