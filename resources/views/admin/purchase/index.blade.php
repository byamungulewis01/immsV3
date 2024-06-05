@extends('layouts.admin.app')
@section('page-name')
    Purchase Form
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Items</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mails</a>
                        </li>
                        <li class="breadcrumb-item active">Items</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="card">
                <form method="post" action="{{ route('admin.purchase.store') }}" class="needs-validation">
                    @csrf
                    <div class="card-body border-bottom border-bottom-dashed p-4">
                        <div class="row">
                            <div class="col-lg-6">

                                <div>
                                    <div class="mb-3">
                                        <label for="companyAddress">PURCHASE LIST FORM</label>
                                    </div>

                                    <div class="mb-2">
                                        <label for="" class="form-label">Supplier</label>
                                        <select name="supplier_id" required class="form-select bg-light border-0">
                                            <option selected disabled> -- Select -- </option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('supplier_id') == $item->id) selected @endif>
                                                    {{ $item->suppliername }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!--end row-->
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div>
                                <label for="items"> ITEMS</label>
                                <select id="items" required class="form-select bg-light border-0">
                                    <option value="" selected disabled> -- Select --</option>
                                    @foreach ($items as $item)
                                        <option price="{{ $item->purchasingprice }}" value="{{ $item->item_id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>

                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table id="itemsTable" class="table table-nowrap">
                                <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 10px;">#</th>
                                        <th scope="col" style="width: 250px;">ITEM NAME</th>
                                        <th scope="col"> QUANTITY </th>
                                        <th scope="col" style="width: 250px;">COST</th>
                                        <th scope="col">TOTAL</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><strong>GRAND TOTAL</strong></td>
                                        <td><span id="grandTotal">0.00</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>


                            </table>
                            <!--end table-->
                        </div>


                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <button type="submit" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i>
                                Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection

@section('css')
    <!--datatable css-->
@endsection

@section('script')
<script>
    $(document).ready(function() {

        $('#items').change(function() {
            var selectedOption = $(this).find('option:selected');
            var itemId = $(this).val();
            var itemName = selectedOption.text();
            var price = selectedOption.attr('price');

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
                    <td> <strong>${itemName}</strong> <input type="hidden" value="${itemId}" name="item_id[]"/></td>
                    <td><input type="number" min="1" name="qty[]" value="1" class="form-control bg-light border-0 quantity" required> </td>
                    <td><input type="number" name="price[]" value="${price}" class="form-control bg-light border-0 price" required> </td>
                    <td><input type="number" name="total[]" class="form-control bg-light border-0 amount" readonly> </td>
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
                var unitPrice = parseFloat($(this).find('input[name="price[]"]').val());
                var amount = quantity * unitPrice;

                $(this).find('.amount').val(amount.toFixed(2));
                $(this).find('td:first').text(index + 1); // Update the row count
                totalAmount += amount;
            });
            $('#grandTotal').text(totalAmount.toFixed(2));
        }

        // Handle input event on quantity fields
        $(document).on('input', '.quantity', function() {
            calculateAmount(); // Recalculate amounts when quantity changes
        });
        $(document).on('input', '.price', function() {
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
