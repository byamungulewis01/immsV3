@extends('layouts.admin.app')
@section('page-name')
    Mail Registration
@endsection
@php
    use App\Models\Branch;
@endphp

@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">MAIL REGISTRATION</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Mail</li>
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
                                <h5 class="card-title mb-0">REGISTERED PACKAGE REGISTRATION BASED ON BRANCH</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="col-xxl-12 order-xxl-0 order-first">
                    <div class="d-flex flex-column h-100">
                        <div class="row h-100">
                            @foreach ($branches as $branch)
                                <div class="col-lg-2 col-md-6">
                                    <div class="card">

                                        <a href="{{ route('admin.mailsr.registration', ['id' => encrypt($branch->id)]) }}">
               
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span
                                                            class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                            <i class="ri ri-home-fill align-middle"></i>
                                                        </span>

                                                    </div>
                                                    <div class="flex-grow-1 ms-3">

                                                        <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                                            {{ $branch->name }}</p>

                                                        <b>TOTAL:{{ $branch->rmt }}</b>
                                                    </div>

                                                </div>
                                            </div><!-- end card body -->
                                    </div><!-- end card -->
                                    </a>
                                </div><!-- end col -->
                            @endforeach

                        </div><!-- end row -->


                    </div>

                </div><!-- end col -->
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

@endsection
