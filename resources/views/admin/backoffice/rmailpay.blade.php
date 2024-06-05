@extends('layouts.admin.app')
@section('page-name')Mail Pay @endsection
@section('body')

      <!-- start page title -->
      <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                <h4 class="mb-sm-0">PAYEMENT OF REGISTED MAILS</h4>


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mail</a>
                        </li>
                        <li class="breadcrumb-item active">REGISTED MAILS</li>
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

                                <h5 class="card-title mb-0">PAYEMENT OF REGISTERED MAILS</h5>

                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions"
                                    onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>




                                {{-- <button type="button" class="btn btn-info">
                                    <i class="ri-file-download-line align-bottom me-1"></i>
                                    Import
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col" style="width: 80px">
                                           #
                                        </th>

                                        <th class="sort" data-sort="MAIL CODE">
                                            MAIL CODE
                                        </th>
                                        <th class="sort" data-sort="TRACKING NUMBER">TRACKING NUMBER</th>
                                        <th class="sort" data-sort="NAME">NAME</th>
                                        <th class="sort" data-sort="PHONE">PHONE</th>

                                        <th class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($inboxings as $key => $inboxing)
                                    <tr>
                                        <th scope="row">
                                            {{ $key + 1 }}
                                        </th>
                                        <td class="MAIL CODE"><a href="">{{ $inboxing->innumber }}</a></td>
                                        <td class="TRACKING NUMBER">{{ $inboxing->intracking }}</td>
                                        <td class="NAME">{{ $inboxing->inname }}</td>
                                        <td class="PHONE">{{ $inboxing->phone }}</td>



                                        <td>

                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#NotifyModel{{ $inboxing->id }}">RE NOTIFY</button>
                                        <div class="modal fade" id="NotifyModel{{ $inboxing->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light p-3">
                                                        <h5 class="modal-title">RCSN ACTION</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close" id="close-modal"></button>
                                                    </div>
                                                    <form class="tablelist-form" id="myForm" method="post"
                                                        action="{{ route('admin.list.notify', $inboxing->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                @if ($errors->any())
                                                                    <div class="alert alert-danger">
                                                                        <p><strong>Opps Something went
                                                                                wrong</strong></p>
                                                                        <ul>
                                                                            @foreach ($errors->all() as $error)
                                                                                <li>* {{ $error }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <input type="hidden" id="customername-field" name="mailtype"
                                                                class="form-control" value="{{ $inboxing->mailtype }}" />
                                                            <div class="mb-3">
                                                                <label for="customername-field" class="form-label">MAIL CODE
                                                                </label>
                                                                <input type="text" id="customername-field"
                                                                    name="innumber" class="form-control"
                                                                    placeholder="Enter Tracking Number"
                                                                    value="{{ $inboxing->innumber }}" readonly required />
                                                                <div class="invalid-feedback">
                                                                    Please enter a MAIL CODE .
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="name-field" class="form-label">Names</label>
                                                                <input type="text" id="email-field" class="form-control"
                                                                    name="inname" placeholder="Enter Names" required
                                                                    value="{{ $inboxing->inname }}" readonly />
                                                                <div class="invalid-feedback">
                                                                    Please enter Names.
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone-field" class="form-label">Phone</label>
                                                                <input type="text" name="phone"
                                                                    class="form-control phoneNumber"
                                                                    placeholder="Enter phone no." required
                                                                    value="{{ $inboxing->phone }}" readonly />
                                                                <div class="invalid-feedback">
                                                                    Please enter a phone.
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="status-field"
                                                                        class="form-label">Weight/Kg</label>
                                                                    <input type="text" id="phone-field" name="weight"
                                                                        class="form-control"
                                                                        value="{{ @\App\Models\Eric\Notification::where('cid', $inboxing->id)->first()->weight }}"
                                                                        placeholder="Enter Weight." required
                                                                        autocomplete="off" autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter a Weight
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">

                                                                    <label for="customername-field"
                                                                        class="form-label">Sherif
                                                                    </label>
                                                                    <input type="text" id="customername-field"
                                                                        name="akabati" class="form-control"
                                                                        placeholder="Enter Sherif"
                                                                        value="{{ $inboxing->akabati }}" required
                                                                        autocomplete="off" autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter Orgin Country .
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-success"
                                                                    id="add-btn" onclick="submitForm()">
                                                                    Notify
                                                                </button>
                                                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                            <a href="#showModal{{ $inboxing->id }}" data-bs-toggle="modal" type="button"
                                                class="btn btn-primary btn-sm"><span>PAY</span></a>

                                            <div class="modal fade" id="showModal{{ $inboxing->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light p-3">
                                                            <h5 class="modal-title">PAYEMENT OF REGISTED MAILS</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close" id="close-modal"></button>
                                                        </div>
                                                        <form class="tablelist-form" id="myForm" method="post" action="{{ route('admin.payr.storer',$inboxing->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">

                                                                <div class="mb-3">
                                                                    @if($errors->any())
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

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                    <label for="customername-field"
                                                                        class="form-label">MAIL CODE
                                                                        </label>
                                                                        <input type="hidden" id="email-field"
                                                                        class="form-control" name="extra"
                                                                       required
                                                                        value="{{ $inboxing->mailtype }}" />

                                                                    <input type="text" id="customername-field"
                                                                        name="innumber" class="form-control"

                                                                        value="{{ $inboxing->innumber }}"  disabled readonly required />

                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="name-field"
                                                                        class="form-label">P.O Box</label>
                                                                    <input type="text" id="email-field"
                                                                        class="form-control" name="pob"
                                                                       required
                                                                        value="{{ $inboxing->pob }} {{ $inboxing->branches->name }}" disabled readonly />
                                                                    <div class="invalid-feedback">
                                                                        Please enter Names.
                                                                    </div>
                                                                </div>
                                                            </div>


                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="status-field" class="form-label">NAMES</label>
                                                                        <input type="text" id="phone-field" name="inname" class="form-control phoneNumber"
                                                                            placeholder="Enter Weight." disabled readonly required value="{{ $inboxing->inname }}"/>
                                                                        <div class="invalid-feedback">
                                                                            Please enter a Innames
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="customername-field"
                                                                                class="form-label">PHONE
                                                                            </label>
                                                                            <input type="text" id="customername-field"
                                                                                name="phone" class="form-control"
                                                                                placeholder="Enter Orgin Country"
                                                                                value="{{ $inboxing->phone }}"
                                                                                required disabled readonly />
                                                                            <div class="invalid-feedback">
                                                                                Please enter Orgin Country .
                                                                            </div>
                                                                        </div>
                                                                </div>


                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="payment-method"
                                                                            class="form-label">Have P.O Box or Not?</label>

                                                                            <select id="selectOption" class="form-control" data-choices
                                                                            data-choices-search-false>
                                                                                <option value="" selected>Please Select</option>
                                                                                <option value="withPostal">With P.O Box</option>
                                                                                <option value="withoutPostal">Without P.O BOX</option>
                                                                            </select>
                                                                    </div>
                                                                        <div class="col-md-6 mb-3" id="inputContainer">
                                                                            <label for="customername-field"
                                                                                class="form-label">Amount
                                                                            </label>
                                                                            <input type="text"
                                                                                name="amount" class="form-control"
                                                                                placeholder="Enter Orgin Country"
                                                                                id="inputField" readonly>
                                                                            <div class="invalid-feedback">
                                                                                Please enter Orgin Country .
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="payment-method"
                                                                            class="form-label">PAYMENT MODE</label>
                                                                        <select class="form-control" data-choices
                                                                            data-choices-search-false name="ptype"
                                                                            id="payment-method" onchange="handlePaymentMethodChange()">
                                                                            <option @if (old('comment') == 'cash') selected @endif  value="cash">Cash</option>
                                                                            <option @if (old('comment') == 'momo') selected @endif  value="momo">Momo</option>
                                                                            <option @if (old('comment') == 'pos') selected @endif  value="pos">Pos</option>

                                                                        </select>
                                                                    </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="customername-field"
                                                                                class="form-label">PAY REFERENCE
                                                                            </label>
                                                                            <input type="text"
                                                                                name="reference" class="form-control"
                                                                                placeholder="Enter Payment Reference"

                                                                                autocomplete="off"/>
                                                                            <div class="invalid-feedback">
                                                                                Enter Payment Reference
                                                                            </div>
                                                                        </div>


                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="status-field"
                                                                            class="form-label">NATIONAL ID/PASSPORT</label>
                                                                        <select class="form-control" data-choices
                                                                            data-choices-search-false name="nidtype"
                                                                            id="status-field">
                                                                            <option @if (old('nidtype') == 'NID') selected @endif  value="NID">NID</option>
                                                                            <option @if (old('nidtype') == 'PASSPORT') selected @endif  value="Momo">PASSPORT</option>


                                                                        </select>
                                                                    </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="customername-field"
                                                                                class="form-label">NID/PASSPOR NUMBER
                                                                            </label>
                                                                            <input type="text" id="customername-field"
                                                                                name="nid" class="form-control"
                                                                                placeholder="Enter NID/PASSPOR"

                                                                                autocomplete="off"/>
                                                                            <div class="invalid-feedback">
                                                                                Please enter Orgin Country .
                                                                            </div>
                                                                        </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="name-field" class="form-label">PICKER NAMES</label>
                                                                    <input type="text" id="email-field" class="form-control" name="pknames"
                                                                        placeholder="Enter Picker Names" required  value="{{ old('pknames') }}" autocomplete="off"/>
                                                                    <div class="invalid-feedback">
                                                                        Please  Picker Names.
                                                                    </div>
                                                                </div>





                                                    </div>
                                                            <div class="modal-footer">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-success"
                                                                        id="add-btn" onclick="submitForm()">
                                                                        PAY
                                                                    </button>
                                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                                </div>
                                                            </div>
                                                        </form>
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
<script>
    const selectOption = document.getElementById('selectOption');
    const inputContainer = document.getElementById('inputContainer');
    const inputField = document.getElementById('inputField');

    selectOption.addEventListener('change', function() {
        const selectedValue = selectOption.value;

        if (selectedValue === 'withPostal') {
            inputField.value = '200';
            inputContainer.style.display = 'block';
        } else if (selectedValue === 'withoutPostal') {
            inputField.value = '500';
            inputContainer.style.display = 'block';
        } else {
            inputContainer.style.display = 'none';
        }
    });

    // Trigger the change event initially to set the initial value and visibility
    selectOption.dispatchEvent(new Event('change'));
</script>
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
@endsection
