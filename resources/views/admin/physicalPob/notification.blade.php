@extends('layouts.admin.app')
@section('page-name')
    POBox Notification
@endsection
@section('css')
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">POBox Notification</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS P.O B</a>
                        </li>
                        <li class="breadcrumb-item active">POBox Notification</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">P.O BOX RENT REMINDER</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendSmsModel">Send
                                    SMS</button>
                            </div>
                            <div class="modal fade" id="sendSmsModel" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">P.O BOX RENT REMINDER</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="{{ route('physicalPob.storeNotification') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div>
                                                    @if ($errors->any())
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
                                                    <div class="col-lg-12">
                                                        <label for="message" class="form-label">MESSAGE FORMAT</label>
                                                        <textarea name="message" id="message" class="form-control" readonly rows="6">{{ \App\Models\Setting::where('type', 'pobox_pay_rent_sms')->first()->value }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-lg-6">
                                                        <label for="message" class="form-label">RENT YEAR</label>
                                                        <input type="number" name="year" class="form-control"
                                                            value="{{ old('year', now()->year + 1) }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-success">
                                                        Send SMS dddd
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        id="customerTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col" style="width: 40px">
                                    #
                                </th>

                                <th class="sort" data-sort="date">
                                    PAYMENT YEAR</th>
                                <th class="sort" data-sort="date">
                                    DATE & TIME</th>
                                <th class="sort" data-sort="date">
                                    SENT</th>
                                <th class="sort" data-sort="date">
                                    NOT SENT</th>

                                {{-- <th class="sort" data-sort="action">ACTION</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->rent_year }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->sent_count }}</td>
                                    <td>{{ $item->not_sent_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection

@section('script')
@endsection
