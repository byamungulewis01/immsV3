@extends('layouts.admin.app')
@section('page-name')
    Sorting Ems
@endsection
@section('body')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">EMS Dispatch Sorting</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Sorting</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="card p-5">
                <form class="tablelist-form" method="post" action="{{ route('admin.cntpsort.storeemssort') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5 class="mb-5">Dispatch Sort (DSP-{{ decrypt($id) }})</h5>
                        <div class="row">
                            <div class="col-sm-12">
                                <select type="text" class="item_id cv" id="item_id" autocomplete="off">
                                    @php
                                        $products = App\Models\Branch::Branch([], 'available');
                                    @endphp
                                    @foreach ($products as $prod)
                                        <option value="{{ $prod['id'] }}">{{ $prod['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                        <button type="button" class="btn btn-primary btn-block" id="add-row" style="display: none;"><i
                                class="mdi mdi-plus-circle me-2"></i> Add new Product
                            Row</button>
                        <table class="table table-bordered " id="my-table">
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Number Of Mails </th>
                                    <th>Weight (Kg) </th>
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <button type="submit" class="btn btn-success"><i
                                    class="ri-save-line align-bottom me-1"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="B" style="display: none;">
                <table id="my-table2">
                    <tbody>
                        <tr data-id="">
                            <td>
                                <b class="prodname"></b>
                                <input type="hidden" name="item_id[]" type="text" class="item_id cv" id="item_2"
                                    autocomplete="off">
                                <input type="hidden" name="dispatchId" value="{{ decrypt($id) }}" />
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button"
                                                class="btn btn-outline-secondary quantity-minus-btn">-</button>
                                        </div>
                                        <input type="number" class="form-control quantity-input p_qty" name="quantity[]"
                                            oninput="calc();" min="1">
                                        <div class="input-group-append">
                                            <button type="button"
                                                class="btn btn-outline-secondary quantity-plus-btn">+</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="number" class="form-control" min="0" name="weight[]" placeholder="weight" />
                            </td>
                            <td>
                                <button class="btn btn-danger remove-row" type="button"><i
                                        class="fa fa-times-circle"></i>
                                    X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <!--end col-->
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
    </script>

    <!--datatable js-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>

    {{-- <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            // Plus button click event
            $(document).on("click", ".quantity-plus-btn", function() {
                var inputField = $(this).closest(".input-group").find(".p_qty");
                var value = parseInt(inputField.val());
                inputField.val(value + 1);
                calc();
            });

            // Minus button click event
            $(document).on("click", ".quantity-minus-btn", function() {
                var inputField = $(this).closest(".input-group").find(".p_qty");
                var value = parseInt(inputField.val());
                if (value > 0) {
                    inputField.val(value - 1);
                    calc();
                }
            });

            // Quantity input change event
            $(document).on("change", ".p_qty", function() {
                var inputField = $(this);
                var value = parseInt(inputField.val());
                if (isNaN(value) || value < 1) {
                    inputField.val(1);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {


            var $select = $('#item_id');
            var allOptions = Array.from($select[0].options).map(function(option) {
                return {
                    value: option.value,
                    text: option.text
                };
            });

            $select.selectize({
                plugins: ['remove_button'],
                hideSelected: true,
                closeAfterSelect: true,
                // dropdownParent: ".modal-body",
                render: {
                    item: function(item, escape) {
                        return '<div class="item">' + escape(item.text) + '</div>';
                    },
                    option: function(item, escape) {
                        return '<div class="option">' + item.text + '</div>';
                    }
                },
                onInitialize: function() {
                    this.$control_input.attr('autocomplete', 'on');
                    this.clearOptions();
                    this.onSearchChange('');
                },
                onDropdownOpen: function() {
                    if (this.$control_input.val().trim() !== '') {
                        this.$control_input.focus();
                    } else {
                        this.clearOptions();
                    }
                },
                onDelete: function(values) {
                    // Handle delete event
                    this.clearOptions();
                    this.onSearchChange('');
                    this.close();
                },
                dropdownDirection: 'down',
                placeholder: 'Search Branch Here...',
                allowEmptyOption: false,
                loadThrottle: 300,
                valueField: 'value',
                labelField: 'text',
                searchField: ['text'],
                create: false,
                onType: function(str) {
                    if (str.trim() === '') {
                        this.clearOptions();
                        this.close();
                    } else {
                        var filteredOptions = allOptions.filter(function(option) {
                            return option.text.toLowerCase().includes(str.toLowerCase());
                        });

                        this.clearOptions();
                        this.load(function(callback) {
                            callback(filteredOptions);
                        });
                        this.open();
                    }
                }
            });
            //detect item_id change
            $('#item_id').change(function() {
                var selectize = $select[0].selectize;
                var selectedItem = selectize.getValue();
                // alert(selectedItem);
                if (selectedItem > 0) {
                    var selectedOption = selectize.options[selectedItem];
                    // make #item_2 has the same value as #item_1
                    $('#my-table2 #item_2').val(selectedOption.value);
                    // make prodname has the same value as #item_1 selected option text
                    $('#my-table2 .prodname').html(selectedOption.text);
                    $("#add-row").click();
                    selectize.clear();
                }


            })
            // manage brand table
            manageBrandTable = $("#manageBrandTable").DataTable({
                'order': [],

            });
        });

        function p_master(p_id) {
            var price = $('#price_' + p_id).val();
            var qty = $('#qty_' + p_id).val();
            var total = $('#total_' + p_id).html();
            var pd_change = $('#pd_change_' + p_id).val();
            $('#total_' + p_id).html(parseFloat(qty) * parseFloat(price));
            $('#pd_change_' + p_id).val('yes');
        }

        // $(".sellect").chosen({ no_results_text: 'Oops, nothing found!',width:   '100%' });

        function parse_receiver(selected = "") {
            var in_nm = selected + "_row";
            $('.check_row').hide();
            $('#' + in_nm).show();
        }
        $(".cv").on('input', function() {
            upd();
        });

        function upd() {
            return true
            // Add event listener to "Add Row" button
        }

        $("#add-row").click(function() {

            var item = $('#item_id').val();
            if ($('table#my-table tbody').find('tr[data-id="' + item + '"]').length > 0) {
                alert('Branch is already exists on the list.', 'error');
                return false;
            }
            if (item > 0) {
                // Clone the first table row
                const newRow = $("#my-table2 tbody tr:first").attr('data-id', item).clone();
                // Reset input values in the cloned row
                // newRow.find("input").val("");
                // newRow.find("tr");
                newRow.find(".p_qty").val(0);


                // Append the new row to the table body
                $("#my-table tbody").append(newRow);
            }



            // Get all selected values from previous rows
            //   var selectedValues = [];
            //   $(".sellect").not($(this).closest('#my-table tbody tr').find('.sellect')).each(function() {
            //     $(this).find("option:selected").each(function() {
            //       selectedValues.push($(this).val());
            //     });
            //   });


        });


        // Add event listener to "Remove" button
        $(document).on("click", ".remove-row", function() {
            $(this).closest("tr").remove(); // Remove the row containing the clicked button
        });
    </script>
@endsection
