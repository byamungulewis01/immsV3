@extends('layouts.admin.app')
@section('page-name')Dispatch Opening @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">DISPATCH OPENING</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS</a>
                    </li>
                    <li class="breadcrumb-item active">Dispatch opening</li>
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
                        <div>
                            <h5 class="card-title mb-0">DISPATCH LIST</h5>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">

                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>

                            </th>
                            <th scope="col">
                                #
                            </th>

                            <th class="sort" data-sort="name">
                                Dispatch Code
                            </th>

                            <th class="sort" data-sort="phone">Gross Weight</th>
                            <th class="sort" data-sort="branch">Dispatch Type</th>
                            <th class="sort" data-sort="date">Current Weight</th>
                            <th class="sort" data-sort="date">Date Received</th>
                            <th class="sort" data-sort="date">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inboxings as $key => $inboxing)
                        <tr>
                            <td scope="row">

                            </td>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="name"><a
                                    href="">{{ $inboxing->dispatchNumber }}</a>
                            </td>
                            <td class="email">{{ $inboxing->grossweight }}</td>

                            <td class="phone">{{ $inboxing->dispachetype }}</td>
                            <td class="phone">{{ $inboxing->currentweight }}</td>
                            <td class="date"> {{ $inboxing->cntppickupdate }}</td>
                            <td>
                            @if (is_null($inboxing->mailnumber))

                            <a href="#showModal{{ $inboxing->id }}" data-bs-toggle="modal" type="button"
                                class="btn btn-primary btn-sm"><span>Dispatch Open</span></a>
                            @elseif (!is_null($inboxing->mailnumber) && $inboxing->regstatus == 0)
                            <span class="badge bg-success">Dispatch Opened Completed</span>
                            @elseif ((!is_null($inboxing->mailnumber) && $inboxing->regstatus == 1))
                            <span class="badge bg-info">Dispatch Opened But Not Completed</span>
                            @elseif ((!is_null($inboxing->mailnumber) && $inboxing->regstatus == 2))
                            <span class="badge bg-success">Dispatch Opened Completed</span>
                            @elseif ((!is_null($inboxing->mailnumber) && $inboxing->mstatus == 1))
                            <span class="badge bg-success">Dispatch Opened Completed</span>

                                @endif
                                <div class="modal fade" id="showModal{{ $inboxing->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title">Dispatch Opening</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" id="myForm" method="post" action="{{ route('admin.cntp.filling',$inboxing->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <input type="hidden" id="token" value="{{ $inboxing->id }}"/>
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
                                                    <input type="hidden" name="dispachetype" value="{{ $inboxing->dispachetype }}">
                                                    @if ($inboxing->dispachetype =='EMS')
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="customername-field" class="form-label">Enter Number Of EMS
                                                            </label>
                                                        <input type="number" min="0" id="customername-field" name="ems"
                                                            class="form-control" placeholder="Enter Number Of EMS"
                                                            value="{{ old('ems') }}" autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please Enter EMS.
                                                        </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="customername-field" class="form-label">Weight/Kg
                                                            </label>
                                                            <input type="text" id="customername-field" name="cntpweight" class="form-control"
                                                                placeholder="Weight" value="{{ old('cntpweight') }}" autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter current weight
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="branch" class="form-label">Comment</label>
                                                            <select class="form-control" required name="cntpcomment"
                                                                id="branch">
                                                                <option value="" disabled selected>Select Comment</option>
                                                                @foreach ($comments as $comment)
                                                                <option @if (old('cntpcomment')==$comment->name) selected @endif
                                                                    value="{{ $comment->name }}">{{ $comment->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    @elseif ($inboxing->dispachetype =='PERCEL')




                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="email-field" class="form-label">Enter Number of PERCEL</label>
                                                            <input type="number" min="0"  id="email-field" class="form-control" name="percel"
                                                                placeholder="Enter Number of Percel"  value="{{ old('percel') }}" autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter an Model.
                                                            </div>

                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="customername-field" class="form-label">Weight/Kg
                                                            </label>
                                                            <input type="text"  name="cntpweight" class="form-control"
                                                                placeholder="Weight" value="{{ old('cntpweight') }}" autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter current weight
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="branch" class="form-label">Comment</label>
                                                            <select class="form-control" name="cntpcomment"
                                                                id="branch">
                                                                <option value="" disabled selected>Select Comment</option>
                                                                @foreach ($comments as $comment)
                                                                <option @if (old('cntpcomment')==$comment->name) selected @endif
                                                                    value="{{ $comment->name }}">{{ $comment->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    @elseif ($inboxing->dispachetype =='Mails')


                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="name-field" class="form-label">Ordinary Package</label>
                                                            <input type="number"  class="form-control" name="rm"
                                                                placeholder="Enter Number Ordinary Package" value="{{ old('rm') }}"autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter Registered Mails
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label for="name-field" class="form-label">Weight/Kg </label>
                                                            <input type="text" class="form-control" name="omweight"
                                                                placeholder="Enter Ordinary Letter Weight" value="{{ old('omweight') }}"autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter Ordinary  Mails
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label for="branch" class="form-label">Comment</label>
                                                            <select class="form-control"  name="omcomment"
                                                                id="branch">
                                                                <option value="" disabled selected>Select Comment</option>
                                                                @foreach ($comments as $comment)
                                                                <option @if (old('odcomment')==$comment->name) selected @endif
                                                                    value="{{ $comment->id }}">{{ $comment->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name-field" class="form-label">Ordinary Letter</label>
                                                                <input type="number"  class="form-control" name="ol"
                                                                    placeholder="Enter Number Of Ordinary Letter" value="{{ old('ol') }}"autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter Registered Mails
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label for="name-field" class="form-label">Weight/Kg </label>
                                                                <input type="number" class="form-control" name="olweight"
                                                                    placeholder="Enter Ordinary Letter Weight" value="{{ old('olweight') }}"autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter Ordinary  Mails
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label for="branch" class="form-label">Comment</label>
                                                                <select class="form-control" name="olcomment"
                                                                    id="branch">
                                                                    <option value="" disabled selected>Select Comment</option>
                                                                    @foreach ($comments as $comment)
                                                                    <option @if (old('olcomment')==$comment->name) selected @endif
                                                                        value="{{ $comment->name }}">{{ $comment->name }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        <h3>If This Dispatch have Registered Mail ? Please check</h3>
                                                        <h3>If This Dispatch have Not Registered Mail ? Please Not check</h3>
                                                      <div class="form-check form-check-outline form-check-primary mb-3">
                                                        <center><input class="form-check-input" name="regstatus" value="1" type="checkbox"
                                                                id="formCheck13">
                                                            <label class="form-check-label" for="formCheck13">
                                                                Check If I Have Registered Mail
                                                            </label></center>
                                                        </div>

                                                    </div>
                                                       </div>
                                                    @endif


                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success"
                                                            id="add-btn" onclick="submitForm()">
                                                           Submit
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
    </form>

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

@endsection
