@extends('layouts.admin.app')
@section('page-name') Branch POBox @endsection
@section('body')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Branch POBox</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">Branch POBox</li>
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
                            <h5 class="card-title mb-0">PHYSICAL P.O BOX</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card mb-1">
                        <table class="table align-middle" id="customerTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 40px">
                                        #
                                    </th>

                                    <th class="sort" data-sort="pob">
                                       P.OB </th>
                                    <th class="sort" data-sort="names">
                                       NAMES</th>

                                    <th class="sort" data-sort="phone">
                                       PHONE </th>

                                       <th class="sort" data-sort="email">
                                        EMAIL</th>

                                    <th class="sort" data-sort="type">
                                       TYPE</th>

                                    <th class="sort" data-sort="date">
                                       DATE</th>

                                    <th class="sort" data-sort="status">
                                       ATTACHMENT</th>

                                    <th class="sort" data-sort="action">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($boxes as $key => $box)
                                <tr>
                                    <th scope="row">
                                        N<sub>{{ $key+1 }}</sub>
                                    </th>
                                    <td class="pob">{{ $box->pob }}</td>
                                    <td class="names">{{ $box->name }}</td>
                                    <td class="phone">{{ $box->phone }}</td>
                                    <td class="email">{{ $box->email }}</td>
                                    <td class="type">{{ $box->pob_category }}</td>
                                    <td class="date">{{ $box->created_at->format('d M, Y') }}</td>
                                    <td class="status">
                                        <a href="{{ route('branchManager.download',$box->attachment) }}"><span>View</span></a>
                                    </td>


                                    <td>
                                        <a href="" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#approve{{ $box->id }}"><span>Approve</span></a>
                                            <div class="modal fade" id="approve{{ $box->id }}" aria-hidden="true"
                                                aria-labelledby="..." tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('branchManager.approve',$box->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body text-center p-5">
                                                                <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"
                                                                    trigger="loop"
                                                                    colors="primary:#f7b84b,secondary:#405189"
                                                                    style="width:130px;height:130px">
                                                                </lord-icon>
                                                                <div class="mt-4 pt-4">
                                                                    <h4>Are you sure you to Approve!!</h4>
                                                                    <p class="text-muted"> Approved by P.O BOX </p>
                                                                    <!-- Toogle to second dialog -->
                                                                    <button class="btn btn-primary">
                                                                        Yes Approve
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- reject --}}
                                        <a href="" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reject{{ $box->id }}"><span>Reject</span></a>
                                            <div class="modal fade" id="reject{{ $box->id }}" aria-hidden="true"
                                                aria-labelledby="..." tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('branchManager.reject',$box->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-body text-center p-5">
                                                                <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"
                                                                    trigger="loop"
                                                                    colors="primary:#f7b84b,secondary:#405189"
                                                                    style="width:130px;height:130px">
                                                                </lord-icon>
                                                                <div class="mt-4 pt-4">
                                                                    <h4>Are you sure you to Reject!!</h4>
                                                                    <p class="text-muted"> Reject Customer Application of P.O BOX </p>
                                                                    <!-- Toogle to second dialog -->
                                                                    <button class="btn btn-danger">
                                                                        Yes Reject
                                                                    </button>
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
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="#">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="#">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
@endsection

@section('script')

@endsection
