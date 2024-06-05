@extends('layouts.admin.app')
@section('page-name')
    Mail Outboxing
@endsection
@php
    $countries = App\Models\Country::country_tarif();
@endphp
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Mail Outboxing</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mails</a>
                        </li>
                        <li class="breadcrumb-item active">Mails</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="card">
                <form method="post" action="{{ route('branch.outboxing.store2') }}" class="needs-validation">
                    @csrf
                    <div class="card-body border-bottom border-bottom-dashed p-4">
                        <div class="row">
                            <div class="col-lg-6">

                                <div>
                                    <div class="mb-3">
                                        <label for="companyAddress">SENDER INFORMATION</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="snames" class="form-control bg-light border-0"
                                            id="snames" value="{{ old('snames') }}" placeholder="Full Name" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="sphone" class="form-control bg-light border-0"
                                            id="sphone" value="{{ old('sphone') }}" placeholder="Phone Number" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="email" name="semail" class="form-control bg-light border-0"
                                            id="semail" value="{{ old('semail') }}" placeholder="Email Address">
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="snid" class="form-control bg-light border-0"
                                            id="snid" value="{{ old('snid') }}" placeholder="NID/Passport">
                                    </div>
                                    <div class="mb-2">
                                        <select name="district" required
                                            class="form-select bg-light border-0">
                                            <option value="" name="district" selected disabled> -- Select District --</option>
                                            <option value="Bugesera" @if (old('district') == 'Bugesera') selected @endif>
                                                Bugesera</option>
                                            <option value="Burera" @if (old('district') == 'Burera') selected @endif>Burera
                                            </option>
                                            <option value="Gakenke" @if (old('district') == 'Gakenke') selected @endif>
                                                Gakenke</option>
                                            <option value="Gasabo" @if (old('district') == 'Gasabo') selected @endif>Gasabo
                                            </option>
                                            <option value="Gatsibo" @if (old('district') == 'Gatsibo') selected @endif>
                                                Gatsibo</option>
                                            <option value="Gicumbi" @if (old('district') == 'Gicumbi') selected @endif>
                                                Gicumbi</option>
                                            <option value="Gisagara" @if (old('district') == 'Gisagara') selected @endif>
                                                Gisagara</option>
                                            <option value="Huye" @if (old('district') == 'Huye') selected @endif>Huye
                                            </option>
                                            <option value="Kamonyi" @if (old('district') == 'Kamonyi') selected @endif>
                                                Kamonyi</option>
                                            <option value="Karongi" @if (old('district') == 'Karongi') selected @endif>
                                                Karongi</option>
                                            <option value="Kayonza" @if (old('district') == 'Kayonza') selected @endif>
                                                Kayonza</option>
                                            <option value="Kicukiro" @if (old('district') == 'Kicukiro') selected @endif>
                                                Kicukiro</option>
                                            <option value="Kirehe" @if (old('district') == 'Kirehe') selected @endif>
                                                Kirehe</option>
                                            <option value="Muhanga" @if (old('district') == 'Muhanga') selected @endif>
                                                Muhanga</option>
                                            <option value="Musanze" @if (old('district') == 'Musanze') selected @endif>
                                                Musanze</option>
                                            <option value="Ngoma" @if (old('district') == 'Ngoma') selected @endif>Ngoma
                                            </option>
                                            <option value="Ngororero" @if (old('district') == 'Ngororero') selected @endif>
                                                Ngororero</option>
                                            <option value="Nyabihu" @if (old('district') == 'Nyabihu') selected @endif>
                                                Nyabihu</option>
                                            <option value="Nyagatare" @if (old('district') == 'Nyagatare') selected @endif>
                                                Nyagatare</option>
                                            <option value="Nyamagabe" @if (old('district') == 'Nyamagabe') selected @endif>
                                                Nyamagabe</option>
                                            <option value="Nyamasheke" @if (old('district') == 'Nyamasheke') selected @endif>
                                                Nyamasheke</option>
                                            <option value="Nyanza" @if (old('district') == 'Nyanza') selected @endif>
                                                Nyanza</option>
                                            <option value="Nyarugenge" @if (old('district') == 'Nyarugenge') selected @endif>
                                                Nyarugenge</option>
                                            <option value="Nyaruguru" @if (old('district') == 'Nyaruguru') selected @endif>
                                                Nyaruguru</option>
                                            <option value="Rubavu" @if (old('district') == 'Rubavu') selected @endif>
                                                Rubavu</option>
                                            <option value="Ruhango" @if (old('district') == 'Ruhango') selected @endif>
                                                Ruhango</option>
                                            <option value="Rulindo" @if (old('district') == 'Rulindo') selected @endif>
                                                Rulindo</option>
                                            <option value="Rusizi" @if (old('district') == 'Rusizi') selected @endif>
                                                Rusizi</option>
                                            <option value="Rutsiro" @if (old('district') == 'Rutsiro') selected @endif>
                                                Rutsiro</option>
                                            <option value="Rwamagana" @if (old('district') == 'Rwamagana') selected @endif>
                                                Rwamagana</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6 ms-auto">
                                <div>
                                    <div class="mb-3">
                                        <label for="companyAddress">RECEIVER INFORMATION</label>
                                    </div>
                                    <div class="mb-2">

                                        <input required type="text" value="{{ old('tracking') }}" name="tracking"
                                            class="form-control bg-light border-0" id="tracking"
                                            placeholder="Tracking Number">
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="rnames" value="{{ old('rnames') }}"
                                            class="form-control bg-light border-0" id="rnames" placeholder="Full Name"
                                            required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="rphone" value="{{ old('rphone') }}"
                                            class="form-control bg-light border-0" id="rphone"
                                            placeholder="Phone Number" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="email" name="remail" value="{{ old('remail') }}"
                                            class="form-control bg-light border-0" id="remail"
                                            placeholder="Email Address">
                                    </div>

                                    <div class="mb-2">
                                        <textarea name="raddress" class="form-control bg-light border-0" id="raddress" rows="2"
                                            placeholder="Receiver Address">{{ old('raddress') }}</textarea>
                                        <input type="hidden" value="0" name="postage" id="total_amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div>
                                <label for="items"> CARTON/ENVELOP</label>
                                <select name="" id="items" required class="form-select bg-light border-0">
                                    <option value="" selected disabled> -- Select --</option>
                                </select>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>

                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 270px;">Mail Type </th>
                                        <th scope="col" style="width: 300px;">Destination Country </th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="type" id="type" class="form-select">
                                                <option {{ old('type') == 'ems' ? 'selected' : '' }} value="ems">EMS
                                                </option>
                                                <option {{ old('type') == 'r' ? 'selected' : '' }}
                                                    value="r">Registered & Small Packet</option>
                                                <option {{ old('type') == 'p' ? 'selected' : '' }} value="p">
                                                    Parcel</option>
                                                <option {{ old('type') == 'stamps' ? 'selected' : '' }} value="stamps">
                                                    Stamps</option>
                                            </select>
                                        </td>
                                        <td> <select class="form-select sellect" name="country"
                                                type="text" id="countries" required>
                                                <option value="" disabled selected>Destination Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country['c_id'] }}">{{ $country['countryname'] }}</option>
                                                @endforeach
                                            </select></td>
                                        <td><input type="number" name="weight" class="form-control"
                                                min="0" step="0.01" placeholder="0.00" required> </td>
                                        <td><input type="number" name="unit" class="form-control"
                                                min="0" step="0.01" placeholder="0.00" required> </td>
                                        <td><input type="number" name="amount" id="sendTotalAmount"
                                                class="form-control" min="0" step="0.01"
                                                value="0.00" required> </td>
                                    </tr>
                                </tbody>

                            </table>
                            <!--end table-->
                        </div>

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
                                        <td colspan="3"><strong>Total Amount (Product)</strong></td>
                                        <td><span id="totalFooterAmount">0.00</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><strong>Grand Total</strong></td>
                                        <td><span id="grandTotal">0.00</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>


                            </table>
                            <!--end table-->
                        </div>

                        <!--end row-->
                        <div class="mt-4">
                            <label for="note" class="form-label text-muted text-uppercase fw-semibold">NOTES</label>
                            <textarea name="note" class="form-control alert alert-info" id="note" placeholder="Notes" rows="2">{{ old('note') }}</textarea>
                        </div>
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <button type="submit" class="btn btn-success"><i
                                    class="ri-printer-line align-bottom me-1"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection

@section('css')
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#type').change(function() {
            var selected = $(this).val();
            if (selected == 'stamps') {
                $('input[name="weight"]').prop('disabled', true);
                $('input[name="unit"]').prop('disabled', true);
                $('input[name="amount"]').prop('disabled', true);
            } else {
                $('input[name="weight"]').prop('disabled', false);
                $('input[name="unit"]').prop('disabled', false);
                $('input[name="amount"]').prop('disabled', false);
            }
        });
    });
</script>
    <script>
        $(document).ready(function() {
            // Fetch trainings from backend
            $.ajax({
                url: "{{ route('branch.outboxing.items') }}",
                method: 'GET',
                success: function(items) {
                    // Populate dropdown list with product options
                    items.forEach(item => {
                        $('#items').append(
                            `<option value="${item.item_id}" price="${item.sellingprice}" category="${item.category}" qty="${item.qty}">${item.name}</option>`
                        );
                    });
                }
            });

            $('#items').change(function() {
                var selectedOption = $(this).find('option:selected');
                var itemId = $(this).val();
                var itemName = selectedOption.text();
                var price = selectedOption.attr('price');
                var qty = selectedOption.attr('qty');
                var category = selectedOption.attr('category');

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
                        <td><strong>${itemName}</strong> <input type="hidden" value="${itemId}" name="items[]"/>
                            <input type="hidden" value="${category}" name="category[]"/>
                            ${category == 'service' ? '' : `<span class="badge bg-danger remain_qty">${qty}</span>`}
                        </td>
                        <td><input type="number" min="1" max="${qty}" name="quantity[]" value="1" class="form-control bg-light border-0 quantity" required> </td>
                        <td><input type="number" name="unitprice[]" value="${price}" class="form-control bg-light border-0" readonly required> </td>
                        <td><input type="number" name="amount_array[]" class="form-control bg-light border-0 amount" readonly required> </td>
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
                var sendTotalAmount = parseFloat($('#sendTotalAmount').val());
                var productTotalAmount = parseFloat(totalAmount);
                var totalBalance = sendTotalAmount + productTotalAmount;


                $('#total_amount').val(totalAmount.toFixed(2));
                $('#totalFooterAmount').text(totalAmount.toFixed(2));
                $('#grandTotal').text(totalBalance.toFixed(2));
            }

            // Handle input event on quantity fields
            $(document).on('input', '.quantity', function() {
                calculateAmount(); // Recalculate amounts when quantity changes
            });
            $(document).on('input', '#sendTotalAmount', function() {
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
