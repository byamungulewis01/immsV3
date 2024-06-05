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

                                    <th class="sort" data-sort="type">
                                       TYPE</th>
                                    <th class="sort" data-sort="size">
                                       SIZE</th>
                                    <th class="sort" data-sort="date">
                                       DATE</th>
                                    <th class="sort" data-sort="status">
                                       STATUS</th>

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
                                    <td class="type">{{ $box->pob_category }}</td>
                                    <td class="size">{{ $box->size }}</td>
                                    <td class="date">{{ $box->date }}</td>
                                    <td class="status">
                                        @if ($box->year >= now()->year)
                                        <span class="badge bg-success">Paid</span>
                                        @else
                                        <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>


                                    <td>
                                        <a href="{{ route('branchManager.details',$box->id) }}"
                                            class="btn btn-primary btn-sm"><span>P.O B Info</span></a>
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
