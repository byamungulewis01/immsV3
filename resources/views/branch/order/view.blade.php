@extends('layouts.admin.app')
@section('page-name')
    Branch Orders
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Branch Orders</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">IMMS Mails</a></li>
                        <li class="breadcrumb-item active">Branch Orders</li>
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
                            <div> <h5 class="card-title mb-3">Branch Orders List</h5> </div>
                            @if (session()->has('warning1'))
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    {{ session()->get('warning1') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
                                @can('make branchorder-')
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i> New Order
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('branch.order.update', $order_1->regnumber) }}" id="po-form">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="list">
                            <thead>
                                <tr class="text-light bg-primary text-white">
                                    <th class="text-center py-1 px-2" colspan="4">
                                        Branch Name : {{ $branch->name }}
                                    </th>
                                </tr>
                                <tr class="text-light bg-primary text-white">
                                    <th class="text-center py-1 px-2" colspan="4">Ordered Products</th>
                                </tr>
                                <tr class="text-light bg-primary text-white">
                                    <th class="text-center py-1 px-2">#</th>
                                    <th class="text-center py-1 px-2">Item</th>
                                    <th class="text-center py-1 px-2">Qty</th>
                                    <th class="text-center py-1 px-2">Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- diaplay data with inputs --}}
                                @php
                                    $loops = 0;
                                @endphp
                                @foreach ($orders as $key => $row)
                                    @php
                                        $in = '';
                                        $edit_access = false;
                                        if ($row['status'] > 0) {
                                            $in = 'disabled';
                                        } else {
                                            if (!$edit_access) {
                                                $edit_access = true;
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td class="py-1 px-2 text-center">
                                            {{ $loops + 1 }}
                                        </td>
                                        <td class="py-1 px-2 text-center qty">
                                            @php
                                                $item = \App\Models\Item::find($row['item_id']);
                                            @endphp
                                            <span class="visible">{{ $item->name }}</span>
                                            <input type="hidden" name="order_id[]" value="{{ $row['order_id'] }}">
                                            <input type="hidden" name="item_id[]" value="{{ $row['item_id'] }}">
                                            <input type="hidden" name="bid" value="{{ $order_1->bid }}">
                                        </td>
                                        <td class="py-1 px-2 item">
                                            <input type="text" class="form-control" name="qty[{{ $row['order_id'] }}]"
                                                value="{{ $row['quantity'] }}" {{ $in }}>
                                        </td>
                                        <td class="py-1 px-2 text-center qty">
                                            @php
                                                // format date to d-m-Y H:i:s
                                                $row['created_at'] = date('d-m-Y H:i:s', strtotime($row['created_at']));
                                            @endphp
                                            <span class="visible">{{ $row['created_at'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" name="url_getter" value="" id="url_getter">
                    </div>
                    <div class="card-footer py-1 text-center">
                        @if ($edit_access)
                            @can('update branchorder')
                                <button class="btn btn-flat btn-success" type="button"
                                    onclick="btn_ck('{{ route('branch.order.update', $order_1->regnumber) }}','po-form');">Save
                                    Order Info</button>
                            @endcan
                            @can('approve branchorder')
                                <button class="btn btn-flat btn-primary" type="button"
                                    onclick="btn_ck('{{ route('branch.order.approve', $order_1->regnumber) }}','po-form');">Approve
                                    Order
                                </button>
                            @endcan
                            @can('reject branchorder')
                                <button class="btn btn-flat btn-danger" type="button"
                                    onclick="btn_ck('{{ route('branch.order.reject', $order_1->regnumber) }}','po-form');">Reject
                                    Order</button>
                            @endcan
                        @endif
                        @if (!$edit_access)
                            <b>Order Processed Before</b>
                        @endif
                        <a class="btn btn-flat btn-dark" href="{{ route('branch.order.history') }}">Back</a>
                    </div>
                </form>
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

        function btn_ck(url_setter = '', form_ref = '') {
            $("#url_getter").val(url_setter);
            $("#" + form_ref).attr('action', url_setter);
            $("#" + form_ref).submit();
        }
    </script>

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
@endsection
