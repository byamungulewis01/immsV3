@extends('layouts.admin.app')
@section('page-name')
    Roles
@endsection
@section('body')
    <!-- start page title -->

    <div class="container-xxl flex-grow-1 container-p-y">


        <h4 class="fw-semibold mb-4">Roles List</h4>

        <p class="mb-4">A role provided access to predefined menus and features so that depending on <br> assigned role an
            administrator can have access to what user needs.</p>
        <!-- Role cards -->
        <div class="row g-2">
            @foreach ($roles as $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal mb-2">Total {{ $role->users->count() }} users</h6>

                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-1">
                                <div class="role-heading">
                                    <h4 class="mb-1">{{ $role->name }}</h4>
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal"
                                        class="role-edit-modal"><span
                                            data="@foreach ($role->permissions as $permission)permission[{{ $permission->name }}], @endforeach"
                                            ariaLabel="{{ $role->name }}" ariaHidden="{{ $role->id }}">Edit
                                            Role</span></a>

                                </div>
                                <a href="#deleteRole{{ $role->id }}" data-bs-toggle="modal" class="text-danger"><i
                                        class="ri-delete-bin-5-fill fs-16"></i></a>

                                <!-- Modal -->
                                <div class="modal fade zoomIn" id="deleteRole{{ $role->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" id="deleteRecord-close"
                                                    data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('admin.roles.destroy', $role->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="mt-2 text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                            trigger="loop" colors="primary:#f7b84b,secondary:#f06548"
                                                            style="width: 100px; height: 100px"></lord-icon>
                                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                            <h4>Are you sure ?</h4>
                                                            <p class="text-muted mx-4 mb-0">
                                                                Are you sure you want to remove this record ?
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                        <button type="button" class="btn w-sm btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn w-sm btn-danger"
                                                            id="delete-record">
                                                            Yes, Delete It!
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal -->
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">

                    <div class="card-body">
                        <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                            class="btn btn-primary mb-2 text-nowrap add-new-role waves-effect waves-light">Add New
                            Role</button>
                        <p class="mb-0 mt-1">Add role, if it does not exist</p>
                    </div>
                    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title role-title"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>

                                <form id="addRoleForm" class="tablelist-form" method="post">
                                    @csrf
                                    <div class="modal-body m-5">

                                        <div class="mb-5">
                                            <label for="customername-field" class="form-label">Role
                                                Name</label>
                                            <input type="hidden" id="is" name="express" />
                                            <input type="text" id="modalRoleName" name="name" class="form-control"
                                                placeholder="Enter a role name" tabindex="-1" value="{{ old('name') }}">

                                        </div>
                                        <div class="mt-3">
                                            <div class="col-12 mt-2">
                                                <h5>Role Permissions</h5>
                                                <!-- Permission table -->
                                                <div class="table-responsive">
                                                    <table class="table table-flush-spacing">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-nowrap fw-semibold">Administrator Access <i
                                                                        class="ti ti-info-circle" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        aria-label="Allows a full access to the system"
                                                                        data-bs-original-title="Allows a full access to the system"></i>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="selectAll">
                                                                        <label class="form-check-label" for="selectAll">
                                                                            Select All
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @foreach ($activities as $item)
                                                                <tr>
                                                                    <td class="text-nowrap fw-semibold">
                                                                        {{ $item->activity->name }}</td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            @php
                                                                                $perms = App\Models\Activity::withPermissions(
                                                                                    $item->activity_id,
                                                                                );
                                                                            @endphp
                                                                            @foreach ($perms as $perm)
                                                                                <div class="form-check me-3 me-lg-5">
                                                                                    <input
                                                                                        name="permission[{{ $perm->name }}]"
                                                                                        class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="{{ $perm->name }}">
                                                                                    <label class="form-check-label"
                                                                                        for="{{ $perm->name }}">
                                                                                        {{ $perm->name }}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach


                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Permission table -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-success" id="add-btn">
                                                submit
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

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">All Users</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>

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
    <!--end row-->
@endsection

@section('script')
    <script>
        "use strict";
        $(function() {
                var e,
                    a = $(".datatables-users"),
                    l = {
                        1: {
                            title: "Pending",
                            class: "bg-label-warning"
                        },
                        2: {
                            title: "Active",
                            class: "bg-label-success"
                        },
                        3: {
                            title: "Inactive",
                            class: "bg-label-secondary"
                        }
                    },
                    i = "app-user-view-account.html";
                a.length && (e = a.DataTable({
                        ajax: assetsPath + "json/user-list.json",
                        columns: [{
                                data: ""
                            },
                            {
                                data: "full_name"
                            },
                            {
                                data: "role"
                            },
                            {
                                data: "current_plan"
                            },
                            {
                                data: "billing"
                            },
                            {
                                data: "status"
                            },
                            {
                                data: ""
                            }
                        ],
                        columnDefs: [{
                                className: "control",
                                orderable: !1,
                                searchable: !1,
                                responsivePriority: 2,
                                targets: 0,
                                render: function(e, a, t, s) {
                                    return ""
                                }
                            },
                            {
                                targets: 1,
                                responsivePriority: 4,
                                render: function(e, a, t, s) {
                                    var l = t.full_name,
                                        n = t.email,
                                        r = t.avatar;
                                    return '<div class="d-flex justify-content-left align-items-center"><div class="avatar-wrapper"><div class="avatar avatar-sm me-3">' +
                                        (r ? '<img src="' + assetsPath + "img/avatars/" + r +
                                            '" alt="Avatar" class="rounded-circle">' :
                                            '<span class="avatar-initial rounded-circle bg-label-' + [
                                                "success", "danger", "warning", "info", "primary",
                                                "secondary"
                                            ][Math.floor(6 * Math.random())] + '">' + (r = (((r = (l = t
                                                    .full_name).match(/\b\w/g) || []).shift() ||
                                                "") + (r.pop() || "")).toUpperCase()) + "</span>") +
                                        '</div></div><div class="d-flex flex-column"><a href="' + i +
                                        '" class="text-body text-truncate"><span class="fw-semibold">' +
                                        l + '</span></a><small class="text-muted">@' + n +
                                        "</small></div></div>"
                                }
                            },
                            {
                                targets: 2,
                                render: function(e, a, t, s) {
                                    t = t.role;
                                    return "<span class='text-truncate d-flex align-items-center'>" + {
                                        Subscriber: '<span class="badge badge-center rounded-pill bg-label-warning me-3 w-px-30 h-px-30"><i class="ti ti-user ti-sm"></i></span>',
                                        Author: '<span class="badge badge-center rounded-pill bg-label-success me-3 w-px-30 h-px-30"><i class="ti ti-settings ti-sm"></i></span>',
                                        Maintainer: '<span class="badge badge-center rounded-pill bg-label-primary me-3 w-px-30 h-px-30"><i class="ti ti-chart-pie-2 ti-sm"></i></span>',
                                        Editor: '<span class="badge badge-center rounded-pill bg-label-info me-3 w-px-30 h-px-30"><i class="ti ti-edit ti-sm"></i></span>',
                                        Admin: '<span class="badge badge-center rounded-pill bg-label-secondary me-3 w-px-30 h-px-30"><i class="ti ti-device-laptop ti-sm"></i></span>'
                                    } [t] + t + "</span>"
                                }
                            },
                            {
                                targets: 3,
                                render: function(e, a, t, s) {
                                    return '<span class="fw-semibold">' + t.current_plan + "</span>"
                                }
                            },
                            {
                                targets: 5,
                                render: function(e, a, t, s) {
                                    t = t.status;
                                    return '<span class="badge ' + l[t].class + '" text-capitalized>' +
                                        l[t].title + "</span>"
                                }
                            },
                            {
                                targets: -1,
                                title: "Actions",
                                searchable: !1,
                                orderable: !1,
                                render: function(e, a, t, s) {
                                    return '<div class="d-flex align-items-center"><a href="' + i +
                                        '" class="btn btn-sm btn-icon"><i class="ti ti-eye"></i></a><a href="javascript:;" class="text-body delete-record"><i class="ti ti-trash ti-sm mx-2"></i></a><a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm mx-1"></i></a><div class="dropdown-menu dropdown-menu-end m-0"><a href="javascript:;"" class="dropdown-item">Edit</a><a href="javascript:;" class="dropdown-item">Suspend</a></div></div>'
                                }
                            }
                        ],
                        order: [
                            [1, "desc"]
                        ],
                        dom: '<"row mx-2"<"col-sm-12 col-md-4 col-lg-6" l><"col-sm-12 col-md-8 col-lg-6"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center align-items-center flex-sm-nowrap flex-wrap me-1"<"me-3"f><"user_role w-px-200 pb-3 pb-sm-0">>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                        language: {
                            sLengthMenu: "Show _MENU_",
                            search: "Search",
                            searchPlaceholder: "Search.."
                        },
                        responsive: {
                            details: {
                                display: $.fn.dataTable.Responsive.display.modal({
                                    header: function(e) {
                                        return "Details of " + e.data().full_name
                                    }
                                }),
                                type: "column",
                                renderer: function(e, a, t) {
                                    t = $.map(t, function(e, a) {
                                        return "" !== e.title ? '<tr data-dt-row="' + e.rowIndex +
                                            '" data-dt-column="' + e.columnIndex + '"><td>' + e
                                            .title + ":</td> <td>" + e.data + "</td></tr>" : ""
                                    }).join("");
                                    return !!t && $('<table class="table"/><tbody />').append(t)
                                }
                            }
                        },
                        initComplete: function() {
                            this.api().columns(2).every(function() {
                                var a = this,
                                    t = $(
                                        '<select id="UserRole" class="form-select text-capitalize"><option value=""> Select Role </option></select>'
                                        ).appendTo(".user_role").on("change", function() {
                                        var e = $.fn.dataTable.util.escapeRegex($(this).val());
                                        a.search(e ? "^" + e + "$" : "", !0, !1).draw()
                                    });
                                a.data().unique().sort().each(function(e, a) {
                                    t.append('<option value="' + e +
                                        '" class="text-capitalize">' + e + "</option>")
                                })
                            })
                        }
                    })),
                    $(".datatables-users tbody").on("click", ".delete-record", function() {
                        e.row($(this).parents("tr")).remove().draw()
                    }),
                    setTimeout(() => {
                        $(".dataTables_filter .form-control").removeClass("form-control-sm"),
                            $(".dataTables_length .form-select").removeClass("form-select-sm")
                    }, 300)
            }),
            function() {
                var e = document.querySelectorAll(".role-edit-modal"),
                    a = document.querySelector(".add-new-role"),
                    b = document.querySelector("#modalRoleName"),
                    h = document.querySelector("#is"),
                    o = document.querySelectorAll('[type="checkbox"]'),
                    t = document.querySelector(".role-title");
                a.onclick = function() {
                        t.innerHTML = "Add New Role";
                        h.value = '0';
                    },
                    e && e.forEach(function(e) {
                        e.onclick = function(event) {
                            b.value = event.target.attributes[1].value;
                            h.value = event.target.attributes[2].value;
                            let permissions = event.target.attributes[0].value.split(', ');
                            o.forEach(e => {
                                e.checked = e.name && permissions.includes(e.name) ? true : false;
                            })
                            t.innerHTML = "Edit Role"
                        }
                    })
            }();
    </script>
    <script>
        // Get the "Select All" checkbox
        var selectAll = document.getElementById("selectAll");
        // Get all the checkboxes
        var checkboxes = document.querySelectorAll(".form-check-input");

        // Add event listener to the "Select All" checkbox
        selectAll.addEventListener("change", function() {
            // Loop through all checkboxes
            checkboxes.forEach(function(checkbox) {
                // Set the checked state of each checkbox to the state of the "Select All" checkbox
                checkbox.checked = selectAll.checked;
            });
        });

        // Add event listener to each checkbox
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                // If any checkbox is unchecked, uncheck the "Select All" checkbox
                if (!this.checked) {
                    selectAll.checked = false;
                }
                // If all checkboxes are checked, check the "Select All" checkbox
                else if ([...checkboxes].every(c => c.checked)) {
                    selectAll.checked = true;
                }
            });
        });
    </script>
@endsection
