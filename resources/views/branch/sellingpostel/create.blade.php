@extends('layouts.admin.app')
@section('page-name')
    Selling Carte Postel
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Selling Carte Postel</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mails</a>
                        </li>
                        <li class="breadcrumb-item active">Selling Carte Postel</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header">
                <h3>Selling Carte Postel Form</h3>
            </div>
            <div class="card-body">
                <form class="tablelist-form" method="post" action="{{ route('branch.sellingpostel.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <input type="hidden" id="total_amount" name="total_amount">
                            <label class="form-label" for="validationCustom01">Full Name</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="form-control"
                                id="validationCustom01" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                            <input name="phone" value="{{ old('phone') }}" required type="text"
                                class="form-control phoneNumber" id="validationCustom01" autocomplete="off">
                        </div>

                        <div class="col-12 mt-4">
                            <label class="form-label" for="validationCustom01"><b>PRODUCT INFORMATION</b></label>
                            <select name="" id="items" required class="form-select bg-light border-0">
                                <option value="" selected disabled> -- Select --</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->item_id }}" price="{{ $item->sellingprice }}"
                                        qty="{{ $item->qty }}">
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="table-responsive">
                            <table id="itemsTable" class="table table-nowrap">
                                <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col">#</th>
                                        <th scope="col" style="width: 320px;">CARTE POSTEL</th>
                                        <th scope="col" style="width: 300px;"> QUANTITY </th>

                                        <th scope="col">UNIT PRICE</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><strong>Total:</strong></td>
                                        <td><span id="totalFooterAmount">0.00</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>


                            </table>
                            <!--end table-->
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-success"> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
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

    <script>
        $(document).ready(function() {


            $('#items').change(function() {
                var selectedOption = $(this).find('option:selected');
                var itemId = $(this).val();
                var itemName = selectedOption.text();
                var price = selectedOption.attr('price');
                var qty = selectedOption.attr('qty');


                // Check if the product is already in the table
                if ($('#itemsTable tr[data-id="' + itemId + '"]').length > 0) {
                    alert(itemName + 'Item already added!');
                    return;
                }

                // Add selected product to the table
                var rowCount = $('#itemsTable tbody tr').length + 1;
                $('#itemsTable tbody').append(`
                    <tr data-id="${itemId}">
                        <td>${rowCount}</td>
                        <td> <strong>${itemName}</strong> <input type="hidden" value="${itemId}" name="items[]"/> <span class="badge bg-danger remain_qty">${qty}</span></td>
                        <td><input type="number" min="1"  max="${qty}" name="quantity[]" value="1" class="form-control bg-light border-0 quantity" required> </td>
                        <td><input type="number" name="unitprice[]" value="${price}" class="form-control bg-light border-0" readonly required> </td>
                        <td><input type="number" name="amounts[]" class="form-control bg-light border-0 amount" required> </td>
                        <td><button type="button" class="btn btn-sm btn-danger removeBtn">Remove</button></td>
                    </tr>`);

                // Calculate and set the amount
                calculateAmount();
            });

            // Function to calculate the amount and total
            function calculateAmount() {
                var totalAmount = 0;
                $('#itemsTable tbody tr').each(function(index) {
                    var quantity = parseFloat($(this).find('.quantity').val());
                    var unitPrice = parseFloat($(this).find('input[name="unitprice[]"]').val());
                    var remain_qty = parseFloat($(this).find('.quantity').attr('max'));
                    var remaining_quantity = remain_qty - quantity;
                    var amount = quantity * unitPrice;
                    $(this).find('.amount').val(amount.toFixed(2));
                    $(this).find('.remain_qty').text(remaining_quantity.toFixed(0));
                    $(this).find('td:first').text(index + 1); // Update the row count
                    totalAmount += amount;
                });
                $('#total_amount').val(totalAmount.toFixed(2));
                $('#totalFooterAmount').text(totalAmount.toFixed(2));
            }

            // Handle input event on quantity fields
            $(document).on('input', '.quantity', function() {
                calculateAmount(); // Recalculate amounts when quantity changes
            });

            // Handle removing items from the table
            $(document).on('click', '.removeBtn', function() {
                $(this).closest('tr').remove();
                calculateAmount(); // Recalculate amounts after removal
            });

        });
    </script>
@endsection
