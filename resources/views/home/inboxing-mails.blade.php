@extends('layouts.customer.auth')
@section('page')
    Mails
@endsection
@section('contents')
    <!-- start hero section -->
    <section class="section pb-0 mb-5" id="hero">
        <div class="container w-50" style="height: 480px">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">P.O Box {{ $inboxings->first()->pob }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-border table-centered align-middle table-nowrap mb-0">
                                    <thead class="text-muted bg-light-subtle">
                                        <tr>
                                            <th>MAIL CODE</th>
                                            <th>TRANKING NUMBER</th>
                                            <th>COUNTRY FROM</th>
                                            <th>DATE </th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        @foreach ($inboxings as $item)
                                        <tr>
                                            <td>{{ $item->innumber }}</td>
                                            <td>{{ $item->intracking }}</td>
                                            <td>{{ $item->country->countryname }}</td>
                                            <td>{{ $item->rcndate }}</td>

                                        </tr><!-- end -->
                                        @endforeach

                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div><!-- end tbody -->

                        </div>
                    </div>
                </div><!--end col-->
                <!--end card-->

            </div>
        </div>
        <!-- end container -->
    </section>
    <!-- end hero section -->
@endsection
