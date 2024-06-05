@extends('layouts.customer.app')
@section('page') Physical POB @endsection
@section('content')

<div class="row">
  @forelse ($boxes as $box)
    <div class="col-xl-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden ms-0">
                        <h6 class="text-uppercase text-muted  mb-3"> {{ $box->name }}
                            <span class="float-end">
                                @if ($box->pob_type == 'Individual')
                                    <span class="badge bg-success">Individual</span>
                                @else
                                     <span class="badge bg-primary">Company</span>
                                @endif
                            </span>
                        </h6>
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="fs-4 flex-grow-1 mb-0">
                                P.O.BOX {{ $box->pob }}
                                <small class="text-muted">{{ $box->branch->name }}</small>
                            </h4>

                        </div>
                        <div class="d-flex align-items-center mb-3">
                                <ul class="list-unstyled vstack gap-2 mb-0">
                                    <li>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-xxs text-muted">
                                                <i class="ri-mail-line"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">Email Address</h6>
                                                <small class="text-muted">{{ $box->email }}</small>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-xxs text-muted">
                                                {{-- <i class="ri-earth-line"></i> --}}
                                                {{-- phone number --}}
                                                <i class="ri-phone-line"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">Mobile Number</h6>
                                                <small class="text-muted">{{ $box->phone }}</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                @if ($box->aprooved == 1)
                                     @php $id = App\Models\Box::where('pob', $box->pob)->first()->id; @endphp
                                    <ul class="list-unstyled mb-0 vstack">

                                        <li><i class="ri-map-pin-line align-middle me-1 text-muted fs-16"></i>
                                            {{ App\Models\Box::find($id)->hasAddress ? 'Addressed Provided' : 'No Address Provided' }}

                                        </li>
                                        <li>
                                            <div class="text-center">
                                                <a href="{{ route('customer.addressing.index',encrypt($id)) }}" class="text-muted text-decoration-underline">Show Address</a>
                                            </div>
                                        </li>
                                    </ul>

                                @else

                                @endif

                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            @if ($box->aprooved == 0)
                            <a href="" class="btn btn-sm btn-info w-100" data-bs-toggle="modal" id="create-btn"
                            data-bs-target="#update{{ $box->id }}">
                            <span> Modify Application </span>
                            </a>
                            @elseif($box->aprooved == 3)
                              <span class="badge bg-danger w-100">Application Rejected</span>
                            @else
                             @php $id = App\Models\Box::where('pob', $box->pob)->first()->id; @endphp
                            <a href="{{ route('customer.physicalPob.details', encrypt($id) ) }}" class="btn btn-primary btn-sm w-100"><span>P.O B Informations</span></a>
                            @endif
                          </div>


                        {{-- <h6 class="text-muted text-truncate mb-0">Post Office Details <span class="float-end">Active</span></h6> --}}
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
        <div class="modal fade" id="update{{ $box->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">P.O BOX INFORMATION UPDATE
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close" id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" method="post"
                        action="{{ route('customer.physicalPob.update',$box->id) }}" enctype="multipart/form-data">
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

                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <label for="formrow-firstname-input" class="form-label">P.O
                                        BOX</label>
                                    <input type="text" class="form-control" id="pob" name="pob"
                                        value="{{ $box->pob }}" disabled>
                                </div>
                                <div class="col-md-9">
                                    <label for="formrow-firstname-input"
                                        class="form-label">NAMES</label>
                                    <input type="text" class="form-control" id="names" name="name"
                                        value="{{ $box->name }}">
                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="formrow-firstname-input"
                                        class="form-label">EMAIL ADDRESS</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $box->email }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="formrow-firstname-input"
                                        class="form-label">PHONE</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $box->phone }}">

                                </div>
                                <div class="col-md-6">
                                    <label for="formrow-firstname-input" class="form-label">P.O BOX
                                        TYPE</label>
                                    <select name="pob_category" class="form-select" aria-label="Default select example" required>
                                        <option value="Individual" {{ $box->pob_category == 'Individual' ? 'selected' : '' }}>Individual</option>
                                        <option value="Ambassade" {{ $box->pob_category == 'Ambassade' ? 'selected' : '' }}>Ambassade</option>
                                        <option value="Banque" {{ $box->pob_category == 'Banque' ? 'selected' : '' }}>Banque</option>
                                        <option value="Company" {{ $box->pob_category == 'Company' ? 'selected' : '' }}>Company</option>
                                        <option value="Eglise" {{ $box->pob_category == 'Eglise' ? 'selected' : '' }}>Eglise</option>
                                        <option value="Gov Institutions" {{ $box->pob_category == 'Gov Institutions' ? 'selected' : '' }}>Gov Institutions</option>
                                        <option value="Others" {{ $box->pob_category == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>

                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="formrow-firstname-input" class="form-label">ATTACHMENT</label>
                                    <input type="file" class="form-control" accept=".pdf" id="attachment" name="attachment" value="{{ $box->attachment }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-success" id="add-btn">
                                    Update
                                </button>
                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end col -->
    @empty

    <div class="alert alert-danger alert-dismissible alert-additional fade show mb-xl-0" role="alert">
        <div class="alert-body">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                    <i class="ri-alert-line fs-24 align-middle"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="alert-heading">No P.O BOX Application Found</h5>
                    <p class="mb-0">It seems you have not applied for a <strong>P.O BOX</strong> yet ,
                        You can apply for a P.O BOX by clicking the button below.  <a href="{{ route('customer.application.index') }}">Apply Now</a>



                    </p>
                </div>
            </div>
        </div>

    </div>

  @endforelse
</div>
@endsection
@section('script')
@endsection
