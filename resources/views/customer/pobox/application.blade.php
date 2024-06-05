@extends('layouts.customer.app')
@section('page') POB Application @endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">P.O Box Application Form</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">MY P.O Box</a></li>
                    <li class="breadcrumb-item active">Application</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-body">
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
            <form action="{{ route('customer.application.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-radio-primary">
                                    <input class="form-check-input" type="radio" name="PBox" value="newPO" id="newPO"
                                        checked="">
                                    <label class="form-check-label" for="newPO">
                                        New P.O Box
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-radio-primary">
                                    <input class="form-check-input" type="radio" name="PBox" value="ExistPO"
                                        id="ExistPO">
                                    <label class="form-check-label" for="ExistPO">
                                        Existing P.O Box
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="formrow-firstname-input" class="form-label">Customer Type <span
                                    class="text-danger">*</span></label>
                            {{-- select option --}}
                            <select id="mySelect" name="pob_category" class="form-select"
                                aria-label="Default select example" required>
                                <option value="Individual">Individual</option>
                                <option value="Ambassade">Ambassade</option>
                                <option value="Banque">Banque</option>
                                <option value="Company">Company</option>
                                <option value="Eglise">Eglise</option>
                                <option value="Gov Institutions">Gov Institutions</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Box type <span
                                        class="text-danger">*</span></label>
                                <select id="box" class="form-select" name="service" required
                                    aria-label="Default select example">
                                    <option value="Physical Box">Physical Box</option>
                                    <option value="Virtual Box">Virtual Box</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Preferred Post
                                    office <span class="text-danger">*</span></label>
                                <select class="form-select" name="branch" id="branch" required
                                    aria-label="Default select example">
                                    <option value="" disabled selected>-- select branch --</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="formrow-firstname-input" class="form-label">PO Box:</label>
                            <select id="pobox" name="pobox" class="form-select" aria-label="Default select example">

                            </select>
                            <div style="display: none;" id="existypobox">
                                <select class="form-select" name="existypobox" id="takenpob">
                                </select>
                            </div>

                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="formrow-firstname-input" class="form-label">Virtual P.O Box</label>
                            <input type="text" name="virtualPob" minlength="10" maxlength="10"
                                class="form-control numbers" disabled id="virtualPob" value="{{ old('virtualPob') }}"
                                placeholder="Telephone Number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12 mb-3">
                            <label for="formrow-firstname-input" class="form-label">Full Name of Applicant
                                <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" required class="form-control"
                                value="{{ old('name') }}" placeholder="Customer Name">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" required placeholder="Customer email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Telephone No <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" minlength="10" maxlength="10"
                                    class="form-control numbers" value="{{ old('phone') }}" required
                                    placeholder="Customer Telephone">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            {{-- Attachment file --}}
                            <label id="myDiv1" for="formrow-firstname-input" class="form-label">Attachment
                                Natinal ID<span class="text-danger">*</span></label>
                            <label id="myDiv2" style="display: none;" for="formrow-firstname-input"
                                class="form-label">Attachment incorporation (RDB/RCA/RGB certificate)<span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" accept=".pdf" required name="attachment" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Total:</label>
                                <input disabled type="text" class="form-control" name="amount" id="amount" value="">
                                <input type="hidden" name="total_amount" id="total_amount" value="15000">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Confirm Mobile
                                    Number:</label>
                                <input type="text" class="form-control" id="paynumber" placeholder="Mobile number">
                            </div>
                        </div>
                        {{-- submit button --}}
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<!--jquery cdn-->
<script>
    // JavaScript code
    const mySelect = document.getElementById("mySelect");
    const myDiv1 = document.getElementById("myDiv1");
    const myDiv2 = document.getElementById("myDiv2");
    const amount = document.getElementById("amount");
    const box = document.getElementById("box");
    const pobox = document.getElementById("pobox");
    const branch = document.getElementById("branch");
    const ExistPO = document.getElementById("ExistPO");
    const newPO = document.getElementById("newPO");
    const paynumber = document.getElementById("paynumber");
    const existypobox = document.getElementById("existypobox");
    const total_amount = document.getElementById("total_amount");
    const virtualPob = document.getElementById("virtualPob");
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const phone = document.getElementById("phone");

    //numbers allow only numbers even . also not allow
    $('.numbers').keyup(function () {
        // replace . value to empty
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });

    // if newPO clicked disable amount
    newPO.addEventListener("click", function () {
        if (newPO.checked === true) {
            paynumber.disabled = false;
            box.disabled = false;
            pobox.style.display = "block";
            existypobox.style.display = "none";
            branch.value = '';
            box.value = "Physical Box";
            name.disabled = false;
            phone.disabled = false;
            name.value = '';
            phone.value = '';
            email.value = '';
            mySelect.disabled = false;

        }
    });
    // if ExistPO clicked disable amount
    ExistPO.addEventListener("click", function () {
        if (ExistPO.checked === true) {
            paynumber.disabled = true;
            amount.value = "0";
            total_amount.value = "0";
            box.disabled = true;
            existypobox.style.display = "block";
            pobox.style.display = "none";
            branch.value = '';
            name.disabled = true;
            phone.disabled = true;
            mySelect.disabled = true;


        }
    });

    box.addEventListener("change", function () {
        if (box.value === "Virtual Box") {
            pobox.disabled = true;
            amount.value = 5000;
            total_amount.value = 5000;
            virtualPob.disabled = false;

        } else {
            pobox.disabled = false;
            virtualPob.disabled = true;
            if (branch.value == 1 && mySelect.value == "Individual") {
                amount.value = 15000;
                total_amount.value = 15000;
            } else if (branch.value == 1 && mySelect.value != "Individual") {
                amount.value = 30000;
                total_amount.value = 30000;
            } else if (branch.value != 1 && mySelect.value == "Individual") {
                amount.value = 12000;
                total_amount.value = 12000;
            } else if (branch.value != 1 && mySelect.value != "Individual") {
                amount.value = 18000;
                total_amount.value = 18000;
            }
        }
    });

    mySelect.addEventListener("change", function () {
        if (mySelect.value === "Individual") {
            myDiv1.style.display = "block";
            myDiv2.style.display = "none";

            if (ExistPO.checked === false) {
                if (branch.value == 1 && box.value == "Physical Box") {
                    amount.value = 15000;
                    total_amount.value = 15000;
                } else if (branch.value != 1 && box.value == "Physical Box") {
                    amount.value = '';
                    total_amount.value = '';
                } else {
                    amount.value = 5000;
                    total_amount.value = 5000;
                }
            }
        } else {
            myDiv1.style.display = "none";
            myDiv2.style.display = "block";
            if (ExistPO.checked === false) {
                if (branch.value == 1 && box.value == "Physical Box") {
                    amount.value = 30000;
                    total_amount.value = 30000;
                } else if (branch.value != 1 && box.value == "Physical Box") {
                    amount.value = '';
                    total_amount.value = '';
                }
            }
        }

    });
    branch.addEventListener("change", function () {
        if (ExistPO.checked === false) {
            if (branch.value == 1) {
                if (mySelect.value == "Individual" && box.value == "Physical Box") {
                    amount.value = 15000;
                    total_amount.value = 15000;
                } else if (mySelect.value != "Individual" && box.value == "Physical Box") {
                    amount.value = 30000;
                    total_amount.value = 30000;
                } else {
                    amount.value = 5000;
                    total_amount.value = 5000;
                }
            } else {
                if (mySelect.value == "Individual" && box.value == "Physical Box") {
                    amount.value = 12000;
                    total_amount.value = 12000;
                } else if (mySelect.value != "Individual" && box.value == "Physical Box") {
                    amount.value = 18000;
                    total_amount.value = 18000;
                } else {
                    amount.value = 5000;
                    total_amount.value = 5000;
                }
            }
        }
    });

</script>
<!--select2 cdn-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/js/pages/select2.init.js') }}"></script>

<script>
    $('#branch').on('change', function () {
        var branch = $(this).val();
        console.log(branch);
        var url = '{{ route("customer.application.getAvailablePob", ":branch") }}';
        $.ajax({
            url: url.replace(':branch', branch),
            type: 'GET',
            success: function (response) {
                var pobox = $('#pobox');
                pobox.empty();
                if (response.length != 0) {
                    pobox.append(
                        '<option value="" disabled selected>-- select P.o box --</option>');
                    $.each(response, function (index, a) {
                        pobox.append('<option value="' + a.id + '">' + a.pob + '</option>');
                    });
                } else {
                    pobox.append('<option value="">No POB</option>');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
        var url = '{{ route("customer.application.getTakenPob", ":branch") }}';
        $.ajax({
            url: url.replace(':branch', branch),
            type: 'GET',
            success: function (response) {
                var takenpob = $('#takenpob');
                takenpob.empty();
                if (response.length != 0) {
                    takenpob.append(
                        '<option value="" disabled selected>-- select P.o box --</option>');
                    $.each(response, function (index, a) {
                        takenpob.append('<option value="' + a.id + '">' + a.pob +
                            '</option>');
                    });
                } else {
                    takenpob.append('<option value="">No POB</option>');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });

    });

    // on change of takenpob
    $('#takenpob').on('change', function () {
        var takenpob = $(this).val();
        var url = '{{ route("customer.application.getPobInfo", ":id") }}';
        $.ajax({
            url: url.replace(':id', takenpob),
            type: 'GET',
            success: function (response) {
                // name, phone, email, address
                $('#name').val(response.name);
                $('#phone').val(response.phone);
                $('#email').val(response.email);
                $('#mySelect').val(response.pob_category);
                // mySelect.disabled = true;
                // virtualPob.disabled = true;
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });

</script>
@endsection
