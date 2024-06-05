@extends('layouts.admin.app')
@section('page-name') Addressing @endsection
@section('body')

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Addressing</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">IMMS P.O B</a></li>
                            <li class="breadcrumb-item active">Map</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 h-100">
                <div class="card">
                    <div class="card-body">
                        <div id="gmaps-markers" class="gmaps"></div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>



@endsection

@section('script')
   <!-- google maps api -->
   <script src="https://maps.google.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script>

   <!-- gmaps plugins -->
   <script src="{{ asset('assets/libs/gmaps/gmaps.min.js') }}"></script>

   <!-- gmaps init -->
   <script src="{{ asset('assets/js/pages/gmaps.init.js') }}"></script>
@endsection
