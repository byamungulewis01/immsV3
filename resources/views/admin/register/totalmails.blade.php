@extends('layouts.admin.app')
@section('page-name')Total Mail @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Total Mail</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS</a>
                    </li>
                    <li class="breadcrumb-item active">Mail Total</li>
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
                            <h5 class="card-title mb-0">Mail Total List</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">






                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>

                            <th scope="col">
                                #
                            </th>

                            <th class="sort" data-sort="name">
                                EMS
                            </th>

                            <th class="sort" data-sort="phone">OM</th>
                            <th class="sort" data-sort="branch">RM</th>
                            <th class="sort" data-sort="branch">PM</th>
                            <th class="sort" data-sort="date">RL</th>
                            <th class="sort" data-sort="date">OL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totals as $key => $total)
                        <tr>

                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="name"><a
                                    href="">{{ $total->emst }}</a>
                            </td>
                            <td class="email">{{ $total->omt }}</td>

                            <td class="phone">{{ $total->rmt }}</td>
                            <td class="phone">{{ $total->pmt }}</td>
                            <td class="phone">{{ $total->rlt }}</td>
                            <td class="phone">{{ $total->olt }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </form>
    <!--end col-->
</div>
<!--end row-->


<!-- Modal -->

<!--end modal -->


@endsection
@section('css')
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
@if($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
        keyboard: false
    })
    myModal.show()

</script>
@endif
<script>
    var checkAll = document.getElementById("checkAll");
    var checkboxes = document.querySelectorAll("tbody input[type=checkbox]");
    var deleteBtn = document.getElementById("deleteBtn");

    checkAll.addEventListener("change", function (e) {
      var t = e.target.checked;
      checkboxes.forEach(function (e) {
        e.checked = t;
      });
      toggleDeleteBtn();
    });

    checkboxes.forEach(function (e) {
      e.addEventListener("change", function (e) {
        checkAll.checked = Array.from(checkboxes).every(function (e) {
          return e.checked;
        });
        toggleDeleteBtn();
      });
    });

    function toggleDeleteBtn() {
      var checkedBoxes = document.querySelectorAll("tbody input[type=checkbox]:checked");
      if (checkedBoxes.length > 0) {
        deleteBtn.style.display = "block";
      } else {
        deleteBtn.style.display = "none";
      }
    }
  </script>
<!--datatable js-->



@endsection
