@extends('layouts.admin.app')
@section('page-name')Purchases @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-purchases-center justify-content-between">
            <h4 class="mb-sm-0">Purchases</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">Purchases</li>
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
                            <h5 class="card-title mb-0">DAILY PURCHASE ITEM LIST</h5>
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
                            <th class="sort" data-sort="name">
                                Product Name
                            </th>
                            <th class="sort" data-sort="category">Category</th>
                            <th class="sort" data-sort="quantity">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total = 0;
                        @endphp
                        @foreach ($items as $item)
                        <tr>
                            <td scope="row">
                                {{ $loop->iteration }}
                            </td>
                            <td class="name">
                                {{ $item->name }}
                            </td>
                            <td class="category">
                                {{ ucfirst($item->category) }}
                            </td>
                            <td class="name">
                                {{ $item->inStore }}
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
