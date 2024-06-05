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
        <div class="col-xxl-5">
            <div class="card">
                <div class="card-header">
                    <h3>DPO INTEGRATION WEB PORTIAL </h3>
                </div>
                <form method="post" action="{{ route('admin.dpo.store') }}" class="needs-validation">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <div class="mb-0">
                                <input type="number" name="amount" class="form-control" id="amount"
                                    value="{{ old('amount') }}" placeholder="Amount" required>
                            </div>
                            <div class="hstack gap-2 justify-content-end d-print-none mt-3">
                                <button type="submit" class="btn btn-success">
                                    Submit</button>
                            </div>
                        </div>
                        <!--end row-->
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
@endsection
