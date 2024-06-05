@extends('layouts.admin.app')
@section('page-name') EMS International @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> EMS International</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS </a>
                    </li>
                    <li class="breadcrumb-item active">EMS International</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
     <form action="{{ route('driver.assigns.emsInternationalPickup') }}" method="post">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">EMS National List</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                 <button class="btn btn-soft-success" style="display: none;" id="deleteBtn">Pickup</button>
                    </div>
                </button>
                </div>
            </div>
            <div class="card-body">
                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 60px">
                                #
                            </th>
                            <th class="sort" style="width: 160px" data-sort="names">
                                DISPATCH NUMBER</th>

                            <th class="sort" data-sort="date">
                                DATE </th>

                            <th class="sort" data-sort="sender">
                                ORGIN </th>

                            <th class="sort" data-sort="wigth">
                                GROSS WEIGHT </th>
                            <th class="sort" data-sort="wigth">
                                COMMENT </th>
                           @if (Request::routeIs('driver.assigns.emsInternational'))
                            <th scope="col" style="width: 25px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        value="option">
                                </div>
                            </th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myMails as $myMail)
                        <tr>
                            <td>
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </td>

                            <td>
                                {{ $myMail->dispatchNumber }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($myMail->created_at)->locale('fr')->format('F j, Y') }}
                            </td>
                            <td>
                                {{ $myMail->orgincountry }}
                            </td>
                            <td>
                                {{ $myMail->grossweight }}
                            </td>
                            <td>
                                {{ $myMail->comment }}
                            </td>
                            @if (Request::routeIs('driver.assigns.emsInternational'))
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checkAll[]"
                                        value="{{ $myMail->id }}">
                                </div>
                            </th>
                            @endif

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
     </form>
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
        $(".numbers").on("input", function () {
            var value = $(this).val();
            var decimalRegex = /^[0-9.]+(\.[0-9]{1,2})?$/;
            if (!decimalRegex.test(value)) {
                $(this).val(value.substring(0, value.length - 1));
            }
        });
    });

</script>
<script>
    var checkAll = document.getElementById("checkAll");
    var checkboxes = document.querySelectorAll("tbody input[type=checkbox]");
    var deleteBtn = document.getElementById("deleteBtn");

    checkAll.addEventListener("change", function (e) {
        var t = e.target.checked;
        checkboxes.forEach(function (e) {
            e.checked = t;
        });
        toggleDeleteBtn();
    });

    checkboxes.forEach(function (e) {
        e.addEventListener("change", function (e) {
            checkAll.checked = Array.from(checkboxes).every(function (e) {
                return e.checked;
            });
            toggleDeleteBtn();
        });
    });

    function toggleDeleteBtn() {
        var checkedBoxes = document.querySelectorAll("tbody input[type=checkbox]:checked");
        if (checkedBoxes.length > 0) {
            deleteBtn.style.display = "block";
        } else {
            deleteBtn.style.display = "none";
        }
    }

</script>
@endsection
