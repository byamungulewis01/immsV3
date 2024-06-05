@extends('layouts.admin.app')
@section('page-name') Create dispatch @endsection
@section('body')

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create Dispatch</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">IMMS P.O B</a></li>
                            <li class="breadcrumb-item active">Analytics</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card card-height-100">

                    <div class="card-body">
                        <div data-simplebar style="max-height: 315px;">
                        <div class="list-group list-group-fill-success">
                            @foreach ($branches as $branch)
                            <a href="{{ route('admin.sendDispatch.index',$branch->id) }}" class="list-group-item list-group-item-action {{ $branch->id == $branchId ? 'active': '' }}"><i class="ri-shield-check-line align-middle me-2"></i>{{ $branch->name }}</a>
                            @endforeach

                        </div>
                        </div><!-- end slimscroll -->
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-8">
                <div class="card" id="customerList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div class="align-items-center d-flex">
                                    <h5 class="card-title mb-0 flex-grow-1">Dispatch</h5>

                                    <div class="flex-shrink-0">
                                        <form action="{{ route('admin.sendDispatch.showStore') }}" method="post">
                                            @csrf

                                            <div class="input-group">
                                                <input type="hidden" name="id" value="{{ $id }}">

                                                <input id="autoCompleteFruit" type="text" name="refNumber" dir="ltr" spellcheck=false autocomplete="off" autocapitalize="off" required>
                                                <button type="submit" class="input-group-text"><i class="ri-add-line"></i></button>

                                            </div>
                                      </form>

                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                    <tr>

                                        <th scope="col" style="width: 40px">
                                            #
                                        </th>
                                        <th class="sort" style="width: 180px" data-sort="reference">
                                            Ref Number</th>

                                        <th class="sort" style="width: 160px" data-sort="date">
                                            Weight</th>

                                        <th class="sort" style="width: 200px" data-sort="rece">
                                            Receive </th>

                                        <th class="sort" style="width: 200px" data-sort="rece">
                                            Destination </th>

                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($dispatchDetails as $myMail)

                                    <tr>
                                        <td>
                                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>{{ $myMail->details->refNumber }}</td>
                                        </td>
                                        <td>
                                           {{ $myMail->details->weight }}
                                        </td>
                                        <td>
                                           {{ $myMail->details->destination->name }}
                                        </td>
                                        <td>
                                           {{ $myMail->details->destination->address }}
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#delete{{ $myMail->id }}"><i class="ri-delete-bin-line me-0"></i></button>
                                            <div class="modal fade zoomIn" id="delete{{ $myMail->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                                                aria-label="Close" id="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('admin.sendDispatch.showDestroy',$myMail->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="mt-2 text-center">
                                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                        colors="primary:#f7b84b,secondary:#f06548" style="width: 100px; height: 100px"></lord-icon>
                                                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                        <h4>Are you sure ?</h4>
                                                                        <p class="text-muted mx-4 mb-0">
                                                                            Are you sure you want to remove this record ?
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn w-sm btn-danger" id="delete-record">
                                                                        Yes, Delete It!
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                      </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </form>
                    </div>
                </div>
            </div>

        </div>


@endsection
@section('css')
<!-- autocomplete css -->

@endsection

@section('script')
   <!-- autocomplete js -->
   <script src="{{ asset('assets/libs/%40tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>
<script>
var multiSelectBasic=document.getElementById("multiselect-basic"),
multiSelectHeader=(multiSelectBasic&&multi(multiSelectBasic,{enable_search:!1}),document.getElementById("multiselect-header")),
multiSelectOptGroup=(multiSelectHeader&&multi(multiSelectHeader,{non_selected_header:"Cars",selected_header:"Favorite Cars"}),
document.getElementById("multiselect-optiongroup")),autoCompleteFruit=(multiSelectOptGroup&&multi(multiSelectOptGroup,{enable_search:!0}),new autoComplete({selector:"#autoCompleteFruit",placeHolder:"Search for reference...",
data:{src:[@foreach($mails as $mail)"{{ $mail }}",@endforeach],
cache:!0},resultsList:{element:function(e,t){var l;t.results.length||((l=document.createElement("div")).setAttribute("class","no_result"),
l.innerHTML='<span>Found No Results for "'+t.query+'"</span>',e.prepend(l))},noResults:!0},resultItem:{highlight:!0},events:{input:{selection:function(e){e=e.detail.selection.value;autoCompleteFruit.input.value=e}}}})),
autoCompleteCars=new autoComplete({selector:"#autoCompleteCars",placeHolder:"Search for Cars...",data:{src:["Chevrolet","Fiat","Ford","Honda","Hyundai","Hyundai","Kia","Mahindra","Maruti","Mitsubishi","MG","Nissan","Renault","Skoda","Tata","Toyato","Volkswagen"],
cache:!0},resultsList:{element:function(e,t){var l;t.results.length||((l=document.createElement("div")).setAttribute("class","no_result"),l.innerHTML='<span>Found No Results for "'+t.query+'"</span>',e.prepend(l))},noResults:!0},resultItem:{highlight:!0},
events:{input:{selection:function(e){e=e.detail.selection.value;autoCompleteCars.input.value=e}}}});
</script>

@endsection
