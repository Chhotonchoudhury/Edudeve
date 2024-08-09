@extends('layouts/layoutMaster')

@section('title', 'Roles & Permissions')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
<style>
    .search-form .input-group {
        width: auto;
        margin-left: auto;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.25rem 1rem;
    }
    .card-title {
        font-size: 0.985rem;
        margin-bottom: 0;
    }
    .input-group .form-control, .input-group .btn {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }
    .card {
        margin-bottom: 0;
    }
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
    .footer-info {
        font-size: 0.875rem;
        color: #6c757d;
    }
    .pagination {
        margin-bottom: 0;
    }

    .footer-info {
    font-size: 0.900rem;
    color: #333333; /* Darker text color for better readability */
    background-color: #f0f0f0; /* Light grey background */
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    display: flex;
    align-items: center;
    border: 1px solid #d1d1d1; /* Light border to give button-like appearance */
   }
      /* Reduce padding for table cells and headings */
    


</style>
@endsection

@section('content')
<!-- Success Message -->
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Roles Table -->
<div class="card m-0 p-0">
    <div class="card-header" style="padding: 1%;">
        <h6 class="card-title mb-0">Roles & Permissions</h6>
        <!-- Search Form -->
        <form method="GET" action="{{ route('roles-permissions.index') }}" class="search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search roles or permissions"
                    value="{{ request()->query('search') }}">
                <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i></button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th class=" p-2 col-1">#</th>
                    <th class=" p-2 col-2">Role</th>
                    <th class=" p-2 col-8">Permissions</th>
                    <th class=" p-2 col-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $index => $role)
                <tr>
                    <td class="p-2">{{ $index + 1  }}</td>
                    <td class="p-2"><span class="badge bg-label-primary m-1">{{ $role->name }}</span></td>
                    <td class="p-2">
                        @foreach($permissions as $permission)
                            @if($role->permissions->contains($permission))
                            <a href="#"><span class="badge bg-label-success m-1">{{ $permission->name }}</span></a>
                            @else
                            <a href="#"><span class="badge bg-label-danger m-1">{{ $permission->name }}</span></a>
                            @endif
                            @endforeach
                    </td>
                    <td class="p-2">&nbsp;&nbsp;&nbsp;
                        <a href="#"  data-role-id="{{ $role->id }}" title="Edit" class="btn-edit  btn btn-outline-primary mx-1" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;"><i class='bx bx-edit'></i></a>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer" style="padding: 1%">
        <!-- Total Records -->
        <div class="footer-info" >
            Total Records : {{ $roles->total() }}
        </div>
        <!-- Pagination -->
        <div class="pagination-container">
            {{ $roles->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

<!--this is the modal for edit role and permissions--->

<!-- Modal -->
<!-- Modal -->
<!-- Modal -->

<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Permissions for : <span id="roleNameModal"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm">
                    @csrf
                    <input type="hidden" id="roleId" name="role_id">
                    <div class="mb-3">
                        <div class="row"> 
                        <div class="col-3">     
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllPermissions">
                            <label class="form-check-label" for="selectAllPermissions">Select All</label>
                        </div>
                        </div>
                        <div class="col-9">
                        <label for="permissions" class="form-label">All Permissions</label>
                        </div>
                        </div>
                        <hr>

                        <div class="row mt-3" id="permissionsCheckboxes"></div>

                        
                    </div>
                    <hr>
                    <div class="text-end">
                        <button type="submit" id="savePermissionsButton" class="btn btn-primary">Save Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







@endsection

@section('scripts')

<script>
    $(document).ready(function() {
       
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.btn-edit').click(function() {
            var roleId = $(this).data('role-id');
            var editUrl = "{{ route('roles-permissions.edit', ':id') }}".replace(':id', roleId);

            $.ajax({
                url: editUrl,
                method: 'GET',
                success: function(data) {
                    console.log('Received data:', data);
                    $('#roleId').val(data.role.id);
                    $('#roleNameModal').text(data.role.name);

                    var permissionsCheckboxes = '';
                    data.permissions.forEach(function(permission, index) {
                        var checked = data.role.permissions.some(rp => rp.id === permission.id) ? 'checked' : '';
                        if (index % 3 === 0) {
                            permissionsCheckboxes += '<div class="col-md-4">';
                        }
                        permissionsCheckboxes += `
                            <div class="form-check">
                                <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="${permission.id}" ${checked}>
                                <label class="form-check-label">${permission.name}</label>
                            </div>
                        `;
                        if (index % 3 === 2 || index === data.permissions.length - 1) {
                            permissionsCheckboxes += '</div>';
                        }
                    });

                    $('#permissionsCheckboxes').html(permissionsCheckboxes);
                    $('#editRoleModal').modal('show');

                    // Select All Checkbox Functionality
                    $('#selectAllPermissions').prop('checked', false); // Uncheck initially
                    $('#selectAllPermissions').change(function() {
                        var isChecked = $(this).prop('checked');
                        $('.permission-checkbox').prop('checked', isChecked);
                    });
                },
                error: function(xhr, status, error) {
                   
                    console.log('XHR:', xhr);
            console.log('Status:', status);
            console.log('Error:', error);
                }
            });
        });

        $('#editRoleForm').submit(function(e) {
            e.preventDefault();
            var updateUrl = "{{ route('roles-permissions.update', ':id') }}".replace(':id', $('#roleId').val());
            // Disable the button and show loading text or spinner
            $('#savePermissionsButton').prop('disabled', true).html('<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Saving...');

            $.ajax({
                url: updateUrl,
                method: 'PUT',
                data: $(this).serialize(), // Serialize the form data correctly
                success: function(response) {
                    $('#editRoleModal').modal('hide'); // Close the modal
                    location.reload(); // Reload the page to see the changes (optional)
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


    

@endsection
  