@extends('layouts.admin.app')
@section('page-name')
    Dashboard
@endsection
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">IMMS V.3</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    @if (auth()->user()->level == 'administrative')
        @include('admin.dashboard.admindashboard')
    @endif
    @if (auth()->user()->level == 'backOffice')
        @include('admin.dashboard.backofficedashboard')
    @endif
    @if (auth()->user()->level == 'branchManager')
        @include('admin.dashboard.branchmanagerdashboard')
    @endif
    @if (auth()->user()->level == 'airport')
        @include('admin.dashboard.airportdash')
    @endif

    @if (auth()->user()->level == 'cntp')
        @include('admin.dashboard.cntpdashboard')
    @endif
    @if (auth()->user()->level == 'register')
        @include('admin.dashboard.registerdashboard')
    @endif
    @if (auth()->user()->level == 'driver')
        @include('admin.dashboard.chiefdriverdashboard')
    @endcan

@endsection
