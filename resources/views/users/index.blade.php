@extends('layouts/layoutMaster')

@section('title', 'Users')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
<style>
  .dt-button.add-new {
    font-size: 0.75rem; /* Smaller font size */
    padding: 0.25rem 0.5rem; /* Reduce padding */
    height: 32px; /* Smaller height */
    display: flex;
    align-items: center;
}

    .header-actions {
    display: flex;
    align-items: center;
    margin-left: auto; /* Align to the right */
    gap: 0.5rem; /* Add space between the search form and button */
}

.search-form .input-group {
    margin-bottom: 0;
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

.input-group .form-control,
.input-group .btn {
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
    font-size: 0.900rem;
    color: #333333; /* Darker text color for better readability */
    background-color: #f0f0f0; /* Light grey background */
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    display: flex;
    align-items: center;
    border: 1px solid #d1d1d1; /* Light border to give button-like appearance */
}

.pagination {
    margin-bottom: 0;
}

</style>
@endsection

@section('content')
<!-- Success Message -->
@if(session('success'))
<div class="alert alert-solid-success alert-dismissible d-flex align-items-center" role="alert">
    <i class="bx bx-xs bx-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-solid-danger alert-dismissible d-flex align-items-center" role="alert">
    <i class="bx bx-xs bx-x-circle me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<!-- Table -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>All</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ $users->count() }} </h4>
              </div>
              <small>Total Users</small>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="bx bx-user bx-sm"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    @foreach($roleCounts as $role => $count)
    <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>{{ $role }}</span>
                <div class="d-flex align-items-end mt-2">
                  <h4 class="mb-0 me-2">{{ $count }}</h4>
                  
                </div>
                <small>Total {{ $role }} </small>
              </div>
              <div class="avatar">
                
                 @if($role == 'Staff')
                 <span class="avatar-initial rounded bg-label-success">
                    <i class="bx bx-group bx-sm"></i>
                 </span>
                 
                 @elseif($role == 'Admin')
                 <span class="avatar-initial rounded bg-label-warning">
                    <i class="bx bx-group bx-sm"></i>
                 </span>
                 @else 
                 <span class="avatar-initial rounded bg-label-danger">
                    <i class="bx bx-group bx-sm"></i>
                 </span>
                  @endif
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

    @endforeach

    
  </div>


  <div class="card m-0 p-0">
    <div class="card-header" style="padding: 1%;">
        <h6 class="card-title mb-0">All Users</h6>
        <!-- Search Form and Add New User Button Container -->
        <div class="header-actions">
            <form method="GET" action="{{ route('users.index') }}" class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search roles or permissions"
                        value="{{ request()->query('search') }}">
                    <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <button class="dt-button add-new btn btn-primary ms-n1" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
                <span><i class="bx bx-plus me-0 me-lg-2"></i><span class="d-none d-lg-inline-block">Add New User</span></span>
            </button>
        </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered mb-0">
        <thead class="table-light">
            <tr>
                <th class="p-2 col-0">Photo</th>
                <th class="p-2 col-2">Name</th>
                <th class="p-2 col-2">Email</th>
                <th class="p-2 col-2">Phone</th>
                <th class="p-2 col-2">Country</th>
                <th class="p-2 col-2">Role</th>
                <th class="p-2 col-1">Status</th>
                <th class="p-2 col-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $row)
            <tr>
              <td class="p-1">
                <img src="{{ $row->profile_photo_path ? asset('storage/' . $row->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($row->name) }}" 
                     alt="{{ $row->name }}" 
                     class="img-fluid rounded-circle"
                     style="width: 40px; height: 40px; object-fit: cover;">
              </td>
                {{-- <td class="p-1">{{ $index + 1 }}</td> --}}
                <td class="p-1">{{ $row->name }}</td>
                <td class="p-1">{{ $row->email }}</td>
                <td class="p-1">{{ $row->phone }}</td>
                <td class="p-1">{{ $row->country }}</td>
                <td class="p-1">
                  @if ($row->roles->isNotEmpty())
                      <span class="badge bg-primary">{{ $row->roles->first()->name }}</span>
                  @else
                      <span class="badge bg-secondary">No Role</span>
                  @endif
              </td>
              
                
              <td class="p-1">
                @if ($row->status == 'Active')
                    <span class="badge bg-success">{{ $row->status }}</span>
                @else
                    <span class="badge bg-danger">{{ $row->status }}</span>
                @endif
            </td>
            
                
              
                <td class="p-1 text-center">

                  
                  <!-- Container for buttons -->
                  <div class="d-flex justify-content-center align-items-center">
                      <!-- Edit Button with Icon -->
                      <a href="{{ route('users.index', ['edit' => $row->id]) }}" class="btn btn-outline-primary mx-1" title="Edit" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                          <i class='bx bx-edit'></i>
                      </a>
                      
                      <!-- Delete Button with Icon -->
                      <button class="btn btn-outline-danger mx-1 delete-btn" data-form-action="{{ route('users.destroy', $row->id) }}" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                        <i class='bx bx-trash'></i>
                      </button>
                  </div>
              </td>
              
              
              
              
              
            </tr>
            @endforeach
        </tbody>
    </table>
    
    </div>
    <div class="card-footer" style="padding: 1%">
        <!-- Total Records -->
        <div class="footer-info">
            Total Records: {{ $users->total() }}
        </div>
        <!-- Pagination -->
        <div class="pagination-container">
            {{ $users->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
  </div>


<!--this is the modal for edit role and permissions--->

<!-- Modal -->

<!-- Updated Modal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel" data-open="{{ session('errors') || isset($user) ? 'true' : 'false' }}">
  <div class="offcanvas-header border-bottom" style="padding: 4%;">
    <h6 id="offcanvasAddUserLabel" class="offcanvas-title"> {{ isset($user) ? 'Edit User' : 'Add New User' }} </h6>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body mx-0 flex-grow-0">
    <!-- Form content -->
    <form class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewUserForm" method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" enctype="multipart/form-data">
      @csrf
      @if(isset($user))
      @method('PUT')
      @endif
      <div class="mb-3">
          <label class="form-label" for="add-user-fullname">Full Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="add-user-fullname" name="name" placeholder="John Doe" value="{{ old('name', $user->name ?? '') }}"   required>
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
          <label class="form-label" for="add-user-email">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="add-user-email" name="email" placeholder="john.doe@example.com" value="{{ old('email', $user->email ?? '') }}" >
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
          <label class="form-label" for="country">Country</label>
          <select id="country" name="country" class="form-select @error('country') is-invalid @enderror select2" >
            <option value="" data-code="">Select Country</option>
            <option value="Andorra" data-code="+376"  {{ (isset($user) && $user->country == 'Andorra') ? 'selected' : '' }}>Andorra</option>
            <option value="United Arab Emirates" data-code="+971" {{ old('country', $user->country ?? '') == "United Arab Emirates" ? 'selected' : '' }}>United Arab Emirates</option>
            <option value="Afghanistan" data-code="+93" {{ old('country', $user->country ?? '') == "Afghanistan" ? 'selected' : '' }}>Afghanistan</option>
            <option value="Antigua and Barbuda" data-code="+1" {{ old('country', $user->country ?? '') == "Antigua and Barbuda" ? 'selected' : '' }}>Antigua and Barbuda</option>
            <option value="Anguilla" data-code="+1" {{ old('country', $user->country ?? '') == "Anguilla" ? 'selected' : '' }}>Anguilla</option>
            <option value="Albania" data-code="+355" {{ old('country', $user->country ?? '') == "Albania" ? 'selected' : '' }}>Albania</option>
            <option value="Armenia" data-code="+374" {{ old('country', $user->country ?? '') == "Armenia" ? 'selected' : '' }}>Armenia</option>
            <option value="Angola" data-code="+244" {{ old('country', $user->country ?? '') == "Angola" ? 'selected' : '' }}>Angola</option>
            <option value="Argentina" data-code="+54" {{ old('country', $user->country ?? '') == "Argentina" ? 'selected' : '' }}>Argentina</option>
            <option value="American Samoa" data-code="+1" {{ old('country', $user->country ?? '') == "American Samoa" ? 'selected' : '' }}>American Samoa</option>
            <option value="Austria" data-code="+43" {{ old('country', $user->country ?? '') == "Austria" ? 'selected' : '' }}>Austria</option>
            <option value="Australia" data-code="+61" {{ old('country', $user->country ?? '') == "Australia" ? 'selected' : '' }}>Australia</option>
            <option value="Aruba" data-code="+297" {{ old('country', $user->country ?? '') == "Aruba" ? 'selected' : '' }}>Aruba</option>
            <option value="Åland Islands" data-code="+358" {{ old('country', $user->country ?? '') == "Åland Islands" ? 'selected' : '' }}>Åland Islands</option>
            <option value="Azerbaijan" data-code="+994" {{ old('country', $user->country ?? '') == "Azerbaijan" ? 'selected' : '' }}>Azerbaijan</option>
            <option value="Bosnia and Herzegovina" data-code="+387" {{ old('country', $user->country ?? '') == "Bosnia and Herzegovina" ? 'selected' : '' }}>Bosnia and Herzegovina</option>
            <option value="Barbados" data-code="+1" {{ old('country', $user->country ?? '') == "Barbados" ? 'selected' : '' }}>Barbados</option>
            <option value="Bangladesh" data-code="+880" {{ old('country', $user->country ?? '') == "Bangladesh" ? 'selected' : '' }}>Bangladesh</option>
            <option value="Belgium" data-code="+32" {{ old('country', $user->country ?? '') == "Belgium" ? 'selected' : '' }}>Belgium</option>
            <option value="Burkina Faso" data-code="+226" {{ old('country', $user->country ?? '') == "Burkina Faso" ? 'selected' : '' }}>Burkina Faso</option>
            <option value="Bulgaria" data-code="+359" {{ old('country', $user->country ?? '') == "Bulgaria" ? 'selected' : '' }}>Bulgaria</option>
            <option value="Bahrain" data-code="+973" {{ old('country', $user->country ?? '') == "Bahrain" ? 'selected' : '' }}>Bahrain</option>
            <option value="Burundi" data-code="+257" {{ old('country', $user->country ?? '') == "Burundi" ? 'selected' : '' }}>Burundi</option>
            <option value="Benin" data-code="+229" {{ old('country', $user->country ?? '') == "Benin" ? 'selected' : '' }}>Benin</option>
            <option value="Saint Barthelemy" data-code="+590" {{ old('country', $user->country ?? '') == "Saint Barthelemy" ? 'selected' : '' }}>Saint Barthelemy</option>
            <option value="Bermuda" data-code="+1" {{ old('country', $user->country ?? '') == "Bermuda" ? 'selected' : '' }}>Bermuda</option>
            <option value="Brunei" data-code="+673" {{ old('country', $user->country ?? '') == "Brunei" ? 'selected' : '' }}>Brunei</option>
            <option value="Bolivia" data-code="+591" {{ old('country', $user->country ?? '') == "Bolivia" ? 'selected' : '' }}>Bolivia</option>
            <option value="Bonaire, Sint Eustatius and Saba" data-code="+599" {{ old('country', $user->country ?? '') == "Bonaire, Sint Eustatius and Saba" ? 'selected' : '' }}>Bonaire, Sint Eustatius and Saba</option>
            <option value="Brazil" data-code="+55" {{ old('country', $user->country ?? '') == "Brazil" ? 'selected' : '' }}>Brazil</option>
            <option value="Bahamas" data-code="+1" {{ old('country', $user->country ?? '') == "Bahamas" ? 'selected' : '' }}>Bahamas</option>
            <option value="Bhutan" data-code="+975" {{ old('country', $user->country ?? '') == "Bhutan" ? 'selected' : '' }}>Bhutan</option>
            <option value="Bouvet Island" data-code="+47" {{ old('country', $user->country ?? '') == "Bouvet Island" ? 'selected' : '' }}>Bouvet Island</option>
            <option value="Botswana" data-code="+267" {{ old('country', $user->country ?? '') == "Botswana" ? 'selected' : '' }}>Botswana</option>
            <option value="Belarus" data-code="+375" {{ old('country', $user->country ?? '') == "Belarus" ? 'selected' : '' }}>Belarus</option>
            <option value="Belize" data-code="+501" {{ old('country', $user->country ?? '') == "Belize" ? 'selected' : '' }}>Belize</option>
            <option value="Canada" data-code="+1" {{ old('country', $user->country ?? '') == "Canada" ? 'selected' : '' }}>Canada</option>
            <option value="Cocos (Keeling) Islands" data-code="+61" {{ old('country', $user->country ?? '') == "Cocos (Keeling) Islands" ? 'selected' : '' }}>Cocos (Keeling) Islands</option>
            <option value="Congo, Democratic Republic of the" data-code="+243" {{ old('country', $user->country ?? '') == "Congo, Democratic Republic of the" ? 'selected' : '' }}>Congo, Democratic Republic of the</option>
            <option value="Central African Republic" data-code="+236" {{ old('country', $user->country ?? '') == "Central African Republic" ? 'selected' : '' }}>Central African Republic</option>
            <option value="Congo, Republic of the" data-code="+242" {{ old('country', $user->country ?? '') == "Congo, Republic of the" ? 'selected' : '' }}>Congo, Republic of the</option>
            <option value="Switzerland" data-code="+41" {{ old('country', $user->country ?? '') == "Switzerland" ? 'selected' : '' }}>Switzerland</option>
            <option value="Ivory Coast" data-code="+225" {{ old('country', $user->country ?? '') == "Ivory Coast" ? 'selected' : '' }}>Ivory Coast</option>
            <option value="Cook Islands" data-code="+682" {{ old('country', $user->country ?? '') == "Cook Islands" ? 'selected' : '' }}>Cook Islands</option>
            <option value="Chile" data-code="+56" {{ old('country', $user->country ?? '') == "Chile" ? 'selected' : '' }}>Chile</option>
            <option value="Cameroon" data-code="+237" {{ old('country', $user->country ?? '') == "Cameroon" ? 'selected' : '' }}>Cameroon</option>
            <option value="China" data-code="+86" {{ old('country', $user->country ?? '') == "China" ? 'selected' : '' }}>China</option>
            <option value="Colombia" data-code="+57" {{ old('country', $user->country ?? '') == "Colombia" ? 'selected' : '' }}>Colombia</option>
            <option value="Costa Rica" data-code="+506" {{ old('country', $user->country ?? '') == "Costa Rica" ? 'selected' : '' }}>Costa Rica</option>
            <option value="Cuba" data-code="+53" {{ old('country', $user->country ?? '') == "Cuba" ? 'selected' : '' }}>Cuba</option>
            <option value="Cape Verde" data-code="+238" {{ old('country', $user->country ?? '') == "Cape Verde" ? 'selected' : '' }}>Cape Verde</option>
            <option value="Curacao" data-code="+599" {{ old('country', $user->country ?? '') == "Curacao" ? 'selected' : '' }}>Curacao</option>
            <option value="Christmas Island" data-code="+61" {{ old('country', $user->country ?? '') == "Christmas Island" ? 'selected' : '' }}>Christmas Island</option>
            <option value="Cyprus" data-code="+357" {{ old('country', $user->country ?? '') == "Cyprus" ? 'selected' : '' }}>Cyprus</option>
            <option value="Czech Republic" data-code="+420" {{ old('country', $user->country ?? '') == "Czech Republic" ? 'selected' : '' }}>Czech Republic</option>
            <option value="Germany" data-code="+49" {{ old('country', $user->country ?? '') == "Germany" ? 'selected' : '' }}>Germany</option>
            <option value="Djibouti" data-code="+253" {{ old('country', $user->country ?? '') == "Djibouti" ? 'selected' : '' }}>Djibouti</option>
            <option value="Denmark" data-code="+45" {{ old('country', $user->country ?? '') == "Denmark" ? 'selected' : '' }}>Denmark</option>
            <option value="Dominica" data-code="+1" {{ old('country', $user->country ?? '') == "Dominica" ? 'selected' : '' }}>Dominica</option>
            <option value="Dominican Republic" data-code="+1" {{ old('country', $user->country ?? '') == "Dominican Republic" ? 'selected' : '' }}>Dominican Republic</option>
            <option value="Algeria" data-code="+213" {{ old('country', $user->country ?? '') == "Algeria" ? 'selected' : '' }}>Algeria</option>
            <option value="Ecuador" data-code="+593" {{ old('country', $user->country ?? '') == "Ecuador" ? 'selected' : '' }}>Ecuador</option>
            <option value="Estonia" data-code="+372" {{ old('country', $user->country ?? '') == "Estonia" ? 'selected' : '' }}>Estonia</option>
            <option value="Egypt" data-code="+20" {{ old('country', $user->country ?? '') == "Egypt" ? 'selected' : '' }}>Egypt</option>
            <option value="Western Sahara" data-code="+212" {{ old('country', $user->country ?? '') == "Western Sahara" ? 'selected' : '' }}>Western Sahara</option>
            <option value="Eritrea" data-code="+291" {{ old('country', $user->country ?? '') == "Eritrea" ? 'selected' : '' }}>Eritrea</option>
            <option value="Spain" data-code="+34" {{ old('country', $user->country ?? '') == "Spain" ? 'selected' : '' }}>Spain</option>
            <option value="Ethiopia" data-code="+251" {{ old('country', $user->country ?? '') == "Ethiopia" ? 'selected' : '' }}>Ethiopia</option>
            <option value="Finland" data-code="+358" {{ old('country', $user->country ?? '') == "Finland" ? 'selected' : '' }}>Finland</option>
            <option value="Fiji" data-code="+679" {{ old('country', $user->country ?? '') == "Fiji" ? 'selected' : '' }}>Fiji</option>
            <option value="Falkland Islands" data-code="+500" {{ old('country', $user->country ?? '') == "Falkland Islands" ? 'selected' : '' }}>Falkland Islands</option>
            <option value="Micronesia" data-code="+691" {{ old('country', $user->country ?? '') == "Micronesia" ? 'selected' : '' }}>Micronesia</option>
            <option value="Faroe Islands" data-code="+298" {{ old('country', $user->country ?? '') == "Faroe Islands" ? 'selected' : '' }}>Faroe Islands</option>
            <option value="France" data-code="+33" {{ old('country', $user->country ?? '') == "France" ? 'selected' : '' }}>France</option>
            <option value="Gabon" data-code="+241" {{ old('country', $user->country ?? '') == "Gabon" ? 'selected' : '' }}>Gabon</option>
            <option value="United Kingdom" data-code="+44" {{ old('country', $user->country ?? '') == "United Kingdom" ? 'selected' : '' }}>United Kingdom</option>
            <option value="Grenada" data-code="+1" {{ old('country', $user->country ?? '') == "Grenada" ? 'selected' : '' }}>Grenada</option>
            <option value="Georgia" data-code="+995" {{ old('country', $user->country ?? '') == "Georgia" ? 'selected' : '' }}>Georgia</option>
            <option value="French Guiana" data-code="+594" {{ old('country', $user->country ?? '') == "French Guiana" ? 'selected' : '' }}>French Guiana</option>
            <option value="Ghana" data-code="+233" {{ old('country', $user->country ?? '') == "Ghana" ? 'selected' : '' }}>Ghana</option>
            <option value="Gibraltar" data-code="+350" {{ old('country', $user->country ?? '') == "Gibraltar" ? 'selected' : '' }}>Gibraltar</option>
            <option value="Greenland" data-code="+299" {{ old('country', $user->country ?? '') == "Greenland" ? 'selected' : '' }}>Greenland</option>
            <option value="Gambia" data-code="+220" {{ old('country', $user->country ?? '') == "Gambia" ? 'selected' : '' }}>Gambia</option>
            <option value="Guinea" data-code="+224" {{ old('country', $user->country ?? '') == "Guinea" ? 'selected' : '' }}>Guinea</option>
            <option value="Guadeloupe" data-code="+590" {{ old('country', $user->country ?? '') == "Guadeloupe" ? 'selected' : '' }}>Guadeloupe</option>
            <option value="Equatorial Guinea" data-code="+240" {{ old('country', $user->country ?? '') == "Equatorial Guinea" ? 'selected' : '' }}>Equatorial Guinea</option>
            <option value="Greece" data-code="+30" {{ old('country', $user->country ?? '') == "Greece" ? 'selected' : '' }}>Greece</option>
            <option value="South Georgia and the South Sandwich Islands" data-code="+500" {{ old('country', $user->country ?? '') == "South Georgia and the South Sandwich Islands" ? 'selected' : '' }}>South Georgia and the South Sandwich Islands</option>
            <option value="Guatemala" data-code="+502" {{ old('country', $user->country ?? '') == "Guatemala" ? 'selected' : '' }}>Guatemala</option>
            <option value="Guam" data-code="+1" {{ old('country', $user->country ?? '') == "Guam" ? 'selected' : '' }}>Guam</option>
            <option value="Guinea-Bissau" data-code="+245" {{ old('country', $user->country ?? '') == "Guinea-Bissau" ? 'selected' : '' }}>Guinea-Bissau</option>
            <option value="Guyana" data-code="+592" {{ old('country', $user->country ?? '') == "Guyana" ? 'selected' : '' }}>Guyana</option>
            <option value="Hong Kong" data-code="+852" {{ old('country', $user->country ?? '') == "Hong Kong" ? 'selected' : '' }}>Hong Kong</option>
            <option value="Heard Island and McDonald Islands" data-code="+672" {{ old('country', $user->country ?? '') == "Heard Island and McDonald Islands" ? 'selected' : '' }}>Heard Island and McDonald Islands</option>
            <option value="Honduras" data-code="+504" {{ old('country', $user->country ?? '') == "Honduras" ? 'selected' : '' }}>Honduras</option>
            <option value="Croatia" data-code="+385" {{ old('country', $user->country ?? '') == "Croatia" ? 'selected' : '' }}>Croatia</option>
            <option value="Haiti" data-code="+509" {{ old('country', $user->country ?? '') == "Haiti" ? 'selected' : '' }}>Haiti</option>
            <option value="Hungary" data-code="+36" {{ old('country', $user->country ?? '') == "Hungary" ? 'selected' : '' }}>Hungary</option>
            <option value="Indonesia" data-code="+62" {{ old('country', $user->country ?? '') == "Indonesia" ? 'selected' : '' }}>Indonesia</option>
            <option value="Ireland" data-code="+353" {{ old('country', $user->country ?? '') == "Ireland" ? 'selected' : '' }}>Ireland</option>
            <option value="Israel" data-code="+972" {{ old('country', $user->country ?? '') == "Israel" ? 'selected' : '' }}>Israel</option>
            <option value="Isle of Man" data-code="+44" {{ old('country', $user->country ?? '') == "Isle of Man" ? 'selected' : '' }}>Isle of Man</option>
            <option value="India" data-code="+91" {{ old('country', $user->country ?? '') == "India" ? 'selected' : '' }}>India</option>
            <option value="British Indian Ocean Territory" data-code="+246" {{ old('country', $user->country ?? '') == "British Indian Ocean Territory" ? 'selected' : '' }}>British Indian Ocean Territory</option>
            <option value="Iraq" data-code="+964" {{ old('country', $user->country ?? '') == "Iraq" ? 'selected' : '' }}>Iraq</option>
            <option value="Iran" data-code="+98" {{ old('country', $user->country ?? '') == "Iran" ? 'selected' : '' }}>Iran</option>
            <option value="Iceland" data-code="+354" {{ old('country', $user->country ?? '') == "Iceland" ? 'selected' : '' }}>Iceland</option>
            <option value="Italy" data-code="+39" {{ old('country', $user->country ?? '') == "Italy" ? 'selected' : '' }}>Italy</option>
            <option value="Jersey" data-code="+44" {{ old('country', $user->country ?? '') == "Jersey" ? 'selected' : '' }}>Jersey</option>
            <option value="Jamaica" data-code="+1" {{ old('country', $user->country ?? '') == "Jamaica" ? 'selected' : '' }}>Jamaica</option>
            <option value="Jordan" data-code="+962" {{ old('country', $user->country ?? '') == "Jordan" ? 'selected' : '' }}>Jordan</option>
            <option value="Japan" data-code="+81" {{ old('country', $user->country ?? '') == "Japan" ? 'selected' : '' }}>Japan</option>
            <option value="Kenya" data-code="+254" {{ old('country', $user->country ?? '') == "Kenya" ? 'selected' : '' }}>Kenya</option>
            <option value="Kyrgyzstan" data-code="+996" {{ old('country', $user->country ?? '') == "Kyrgyzstan" ? 'selected' : '' }}>Kyrgyzstan</option>
            <option value="Cambodia" data-code="+855" {{ old('country', $user->country ?? '') == "Cambodia" ? 'selected' : '' }}>Cambodia</option>
            <option value="Kiribati" data-code="+686" {{ old('country', $user->country ?? '') == "Kiribati" ? 'selected' : '' }}>Kiribati</option>
            <option value="Comoros" data-code="+269" {{ old('country', $user->country ?? '') == "Comoros" ? 'selected' : '' }}>Comoros</option>
            <option value="Saint Kitts and Nevis" data-code="+1" {{ old('country', $user->country ?? '') == "Saint Kitts and Nevis" ? 'selected' : '' }}>Saint Kitts and Nevis</option>
            <option value="North Korea" data-code="+850" {{ old('country', $user->country ?? '') == "North Korea" ? 'selected' : '' }}>North Korea</option>
            <option value="South Korea" data-code="+82" {{ old('country', $user->country ?? '') == "South Korea" ? 'selected' : '' }}>South Korea</option>
            <option value="Kuwait" data-code="+965" {{ old('country', $user->country ?? '') == "Kuwait" ? 'selected' : '' }}>Kuwait</option>
            <option value="Cayman Islands" data-code="+1" {{ old('country', $user->country ?? '') == "Cayman Islands" ? 'selected' : '' }}>Cayman Islands</option>
            <option value="Kazakhstan" data-code="+7" {{ old('country', $user->country ?? '') == "Kazakhstan" ? 'selected' : '' }}>Kazakhstan</option>
            <option value="Lao People's Democratic Republic" data-code="+856" {{ old('country', $user->country ?? '') == "Lao People's Democratic Republic" ? 'selected' : '' }}>Lao People's Democratic Republic</option>
            <option value="Lebanon" data-code="+961" {{ old('country', $user->country ?? '') == "Lebanon" ? 'selected' : '' }}>Lebanon</option>
            <option value="Saint Lucia" data-code="+1" {{ old('country', $user->country ?? '') == "Saint Lucia" ? 'selected' : '' }}>Saint Lucia</option>
            <option value="Liechtenstein" data-code="+423" {{ old('country', $user->country ?? '') == "Liechtenstein" ? 'selected' : '' }}>Liechtenstein</option>
            <option value="Sri Lanka" data-code="+94" {{ old('country', $user->country ?? '') == "Sri Lanka" ? 'selected' : '' }}>Sri Lanka</option>
            <option value="Liberia" data-code="+231" {{ old('country', $user->country ?? '') == "Liberia" ? 'selected' : '' }}>Liberia</option>
            <option value="Lesotho" data-code="+266" {{ old('country', $user->country ?? '') == "Lesotho" ? 'selected' : '' }}>Lesotho</option>
            <option value="Lithuania" data-code="+370" {{ old('country', $user->country ?? '') == "Lithuania" ? 'selected' : '' }}>Lithuania</option>
            <option value="Luxembourg" data-code="+352" {{ old('country', $user->country ?? '') == "Luxembourg" ? 'selected' : '' }}>Luxembourg</option>
            <option value="Latvia" data-code="+371" {{ old('country', $user->country ?? '') == "Latvia" ? 'selected' : '' }}>Latvia</option>
            <option value="Libya" data-code="+218" {{ old('country', $user->country ?? '') == "Libya" ? 'selected' : '' }}>Libya</option>
            <option value="Morocco" data-code="+212" {{ old('country', $user->country ?? '') == "Morocco" ? 'selected' : '' }}>Morocco</option>
            <option value="Monaco" data-code="+377" {{ old('country', $user->country ?? '') == "Monaco" ? 'selected' : '' }}>Monaco</option>
            <option value="Moldova" data-code="+373" {{ old('country', $user->country ?? '') == "Moldova" ? 'selected' : '' }}>Moldova</option>
            <option value="Montenegro" data-code="+382" {{ old('country', $user->country ?? '') == "Montenegro" ? 'selected' : '' }}>Montenegro</option>
            <option value="Saint Martin" data-code="+590" {{ old('country', $user->country ?? '') == "Saint Martin" ? 'selected' : '' }}>Saint Martin</option>
            <option value="Madagascar" data-code="+261" {{ old('country', $user->country ?? '') == "Madagascar" ? 'selected' : '' }}>Madagascar</option>
            <option value="Marshall Islands" data-code="+692" {{ old('country', $user->country ?? '') == "Marshall Islands" ? 'selected' : '' }}>Marshall Islands</option>
            <option value="North Macedonia" data-code="+389" {{ old('country', $user->country ?? '') == "North Macedonia" ? 'selected' : '' }}>North Macedonia</option>
            <option value="Mali" data-code="+223" {{ old('country', $user->country ?? '') == "Mali" ? 'selected' : '' }}>Mali</option>
            <option value="Myanmar" data-code="+95" {{ old('country', $user->country ?? '') == "Myanmar" ? 'selected' : '' }}>Myanmar</option>
            <option value="Mongolia" data-code="+976" {{ old('country', $user->country ?? '') == "Mongolia" ? 'selected' : '' }}>Mongolia</option>
            <option value="Macao" data-code="+853" {{ old('country', $user->country ?? '') == "Macao" ? 'selected' : '' }}>Macao</option>
            <option value="Northern Mariana Islands" data-code="+1" {{ old('country', $user->country ?? '') == "Northern Mariana Islands" ? 'selected' : '' }}>Northern Mariana Islands</option>
            <option value="Martinique" data-code="+596" {{ old('country', $user->country ?? '') == "Martinique" ? 'selected' : '' }}>Martinique</option>
            <option value="Mauritania" data-code="+222" {{ old('country', $user->country ?? '') == "Mauritania" ? 'selected' : '' }}>Mauritania</option>
            <option value="Montserrat" data-code="+1" {{ old('country', $user->country ?? '') == "Montserrat" ? 'selected' : '' }}>Montserrat</option>
            <option value="Malta" data-code="+356" {{ old('country', $user->country ?? '') == "Malta" ? 'selected' : '' }}>Malta</option>
            <option value="Mauritius" data-code="+230" {{ old('country', $user->country ?? '') == "Mauritius" ? 'selected' : '' }}>Mauritius</option>
            <option value="Maldives" data-code="+960" {{ old('country', $user->country ?? '') == "Maldives" ? 'selected' : '' }}>Maldives</option>
            <option value="Malawi" data-code="+265" {{ old('country', $user->country ?? '') == "Malawi" ? 'selected' : '' }}>Malawi</option>
            <option value="Mexico" data-code="+52" {{ old('country', $user->country ?? '') == "Mexico" ? 'selected' : '' }}>Mexico</option>
            <option value="Malaysia" data-code="+60" {{ old('country', $user->country ?? '') == "Malaysia" ? 'selected' : '' }}>Malaysia</option>
            <option value="Mozambique" data-code="+258" {{ old('country', $user->country ?? '') == "Mozambique" ? 'selected' : '' }}>Mozambique</option>
            <option value="Namibia" data-code="+264" {{ old('country', $user->country ?? '') == "Namibia" ? 'selected' : '' }}>Namibia</option>
            <option value="New Caledonia" data-code="+687" {{ old('country', $user->country ?? '') == "New Caledonia" ? 'selected' : '' }}>New Caledonia</option>
            <option value="Niger" data-code="+227" {{ old('country', $user->country ?? '') == "Niger" ? 'selected' : '' }}>Niger</option>
            <option value="Norfolk Island" data-code="+672" {{ old('country', $user->country ?? '') == "Norfolk Island" ? 'selected' : '' }}>Norfolk Island</option>
            <option value="Nigeria" data-code="+234" {{ old('country', $user->country ?? '') == "Nigeria" ? 'selected' : '' }}>Nigeria</option>
            <option value="Nicaragua" data-code="+505" {{ old('country', $user->country ?? '') == "Nicaragua" ? 'selected' : '' }}>Nicaragua</option>
            <option value="Netherlands" data-code="+31" {{ old('country', $user->country ?? '') == "Netherlands" ? 'selected' : '' }}>Netherlands</option>
            <option value="Norway" data-code="+47" {{ old('country', $user->country ?? '') == "Norway" ? 'selected' : '' }}>Norway</option>
            <option value="Nepal" data-code="+977" {{ old('country', $user->country ?? '') == "Nepal" ? 'selected' : '' }}>Nepal</option>
            <option value="Nauru" data-code="+674" {{ old('country', $user->country ?? '') == "Nauru" ? 'selected' : '' }}>Nauru</option>
            <option value="Niue" data-code="+683" {{ old('country', $user->country ?? '') == "Niue" ? 'selected' : '' }}>Niue</option>
            <option value="New Zealand" data-code="+64" {{ old('country', $user->country ?? '') == "New Zealand" ? 'selected' : '' }}>New Zealand</option>
            <option value="Oman" data-code="+968" {{ old('country', $user->country ?? '') == "Oman" ? 'selected' : '' }}>Oman</option>
            <option value="Panama" data-code="+507" {{ old('country', $user->country ?? '') == "Panama" ? 'selected' : '' }}>Panama</option>
            <option value="Peru" data-code="+51" {{ old('country', $user->country ?? '') == "Peru" ? 'selected' : '' }}>Peru</option>
            <option value="French Polynesia" data-code="+689" {{ old('country', $user->country ?? '') == "French Polynesia" ? 'selected' : '' }}>French Polynesia</option>
            <option value="Papua New Guinea" data-code="+675" {{ old('country', $user->country ?? '') == "Papua New Guinea" ? 'selected' : '' }}>Papua New Guinea</option>
            <option value="Philippines" data-code="+63" {{ old('country', $user->country ?? '') == "Philippines" ? 'selected' : '' }}>Philippines</option>
            <option value="Pakistan" data-code="+92" {{ old('country', $user->country ?? '') == "Pakistan" ? 'selected' : '' }}>Pakistan</option>
            <option value="Poland" data-code="+48" {{ old('country', $user->country ?? '') == "Poland" ? 'selected' : '' }}>Poland</option>
            <option value="Saint Pierre and Miquelon" data-code="+508" {{ old('country', $user->country ?? '') == "Saint Pierre and Miquelon" ? 'selected' : '' }}>Saint Pierre and Miquelon</option>
            <option value="Pitcairn" data-code="+64" {{ old('country', $user->country ?? '') == "Pitcairn" ? 'selected' : '' }}>Pitcairn</option>
            <option value="Puerto Rico" data-code="+1" {{ old('country', $user->country ?? '') == "Puerto Rico" ? 'selected' : '' }}>Puerto Rico</option>
            <option value="Palestine, State of" data-code="+970" {{ old('country', $user->country ?? '') == "Palestine, State of" ? 'selected' : '' }}>Palestine, State of</option>
            <option value="Portugal" data-code="+351" {{ old('country', $user->country ?? '') == "Portugal" ? 'selected' : '' }}>Portugal</option>
            <option value="Palau" data-code="+680" {{ old('country', $user->country ?? '') == "Palau" ? 'selected' : '' }}>Palau</option>
            <option value="Paraguay" data-code="+595" {{ old('country', $user->country ?? '') == "Paraguay" ? 'selected' : '' }}>Paraguay</option>
            <option value="Qatar" data-code="+974" {{ old('country', $user->country ?? '') == "Qatar" ? 'selected' : '' }}>Qatar</option>
            <option value="Réunion" data-code="+262" {{ old('country', $user->country ?? '') == "Réunion" ? 'selected' : '' }}>Réunion</option>
            <option value="Romania" data-code="+40" {{ old('country', $user->country ?? '') == "Romania" ? 'selected' : '' }}>Romania</option>
            <option value="Serbia" data-code="+381" {{ old('country', $user->country ?? '') == "Serbia" ? 'selected' : '' }}>Serbia</option>
            <option value="Russian Federation" data-code="+7" {{ old('country', $user->country ?? '') == "Russian Federation" ? 'selected' : '' }}>Russian Federation</option>
            <option value="Rwanda" data-code="+250" {{ old('country', $user->country ?? '') == "Rwanda" ? 'selected' : '' }}>Rwanda</option>
            <option value="Saudi Arabia" data-code="+966" {{ old('country', $user->country ?? '') == "Saudi Arabia" ? 'selected' : '' }}>Saudi Arabia</option>
            <option value="Solomon Islands" data-code="+677" {{ old('country', $user->country ?? '') == "Solomon Islands" ? 'selected' : '' }}>Solomon Islands</option>
            <option value="Seychelles" data-code="+248" {{ old('country', $user->country ?? '') == "Seychelles" ? 'selected' : '' }}>Seychelles</option>
            <option value="Sudan" data-code="+249" {{ old('country', $user->country ?? '') == "Sudan" ? 'selected' : '' }}>Sudan</option>
            <option value="Sweden" data-code="+46" {{ old('country', $user->country ?? '') == "Sweden" ? 'selected' : '' }}>Sweden</option>
            <option value="Singapore" data-code="+65" {{ old('country', $user->country ?? '') == "Singapore" ? 'selected' : '' }}>Singapore</option>
            <option value="Saint Helena, Ascension and Tristan da Cunha" data-code="+290" {{ old('country', $user->country ?? '') == "Saint Helena, Ascension and Tristan da Cunha" ? 'selected' : '' }}>Saint Helena, Ascension and Tristan da Cunha</option>
            <option value="Slovenia" data-code="+386" {{ old('country', $user->country ?? '') == "Slovenia" ? 'selected' : '' }}>Slovenia</option>
            <option value="Svalbard and Jan Mayen" data-code="+47" {{ old('country', $user->country ?? '') == "Svalbard and Jan Mayen" ? 'selected' : '' }}>Svalbard and Jan Mayen</option>
            <option value="Slovakia" data-code="+421" {{ old('country', $user->country ?? '') == "Slovakia" ? 'selected' : '' }}>Slovakia</option>
            <option value="Sierra Leone" data-code="+232" {{ old('country', $user->country ?? '') == "Sierra Leone" ? 'selected' : '' }}>Sierra Leone</option>
            <option value="San Marino" data-code="+378" {{ old('country', $user->country ?? '') == "San Marino" ? 'selected' : '' }}>San Marino</option>
            <option value="Senegal" data-code="+221" {{ old('country', $user->country ?? '') == "Senegal" ? 'selected' : '' }}>Senegal</option>
            <option value="Somalia" data-code="+252" {{ old('country', $user->country ?? '') == "Somalia" ? 'selected' : '' }}>Somalia</option>
            <option value="Suriname" data-code="+597" {{ old('country', $user->country ?? '') == "Suriname" ? 'selected' : '' }}>Suriname</option>
            <option value="South Sudan" data-code="+211" {{ old('country', $user->country ?? '') == "South Sudan" ? 'selected' : '' }}>South Sudan</option>
            <option value="Sao Tome and Principe" data-code="+239" {{ old('country', $user->country ?? '') == "Sao Tome and Principe" ? 'selected' : '' }}>Sao Tome and Principe</option>
            <option value="El Salvador" data-code="+503" {{ old('country', $user->country ?? '') == "El Salvador" ? 'selected' : '' }}>El Salvador</option>
            <option value="Sint Maarten (Dutch part)" data-code="+1" {{ old('country', $user->country ?? '') == "Sint Maarten (Dutch part)" ? 'selected' : '' }}>Sint Maarten (Dutch part)</option>
            <option value="Syrian Arab Republic" data-code="+963" {{ old('country', $user->country ?? '') == "Syrian Arab Republic" ? 'selected' : '' }}>Syrian Arab Republic</option>
            <option value="Swaziland" data-code="+268" {{ old('country', $user->country ?? '') == "Swaziland" ? 'selected' : '' }}>Swaziland</option>
            <option value="Chad" data-code="+235" {{ old('country', $user->country ?? '') == "Chad" ? 'selected' : '' }}>Chad</option>
            <option value="Togo" data-code="+228" {{ old('country', $user->country ?? '') == "Togo" ? 'selected' : '' }}>Togo</option>
            <option value="Thailand" data-code="+66" {{ old('country', $user->country ?? '') == "Thailand" ? 'selected' : '' }}>Thailand</option>
            <option value="Tajikistan" data-code="+992" {{ old('country', $user->country ?? '') == "Tajikistan" ? 'selected' : '' }}>Tajikistan</option>
            <option value="Tokelau" data-code="+690" {{ old('country', $user->country ?? '') == "Tokelau" ? 'selected' : '' }}>Tokelau</option>
            <option value="Turkmenistan" data-code="+993" {{ old('country', $user->country ?? '') == "Turkmenistan" ? 'selected' : '' }}>Turkmenistan</option>
            <option value="Timor-Leste" data-code="+670" {{ old('country', $user->country ?? '') == "Timor-Leste" ? 'selected' : '' }}>Timor-Leste</option>
            <option value="Tonga" data-code="+676" {{ old('country', $user->country ?? '') == "Tonga" ? 'selected' : '' }}>Tonga</option>
            <option value="Trinidad and Tobago" data-code="+1" {{ old('country', $user->country ?? '') == "Trinidad and Tobago" ? 'selected' : '' }}>Trinidad and Tobago</option>
            <option value="Tunisia" data-code="+216" {{ old('country', $user->country ?? '') == "Tunisia" ? 'selected' : '' }}>Tunisia</option>
            <option value="Turkey" data-code="+90" {{ old('country', $user->country ?? '') == "Turkey" ? 'selected' : '' }}>Turkey</option>
            <option value="Tuvalu" data-code="+688" {{ old('country', $user->country ?? '') == "Tuvalu" ? 'selected' : '' }}>Tuvalu</option>
            <option value="Taiwan, Province of China" data-code="+886" {{ old('country', $user->country ?? '') == "Taiwan, Province of China" ? 'selected' : '' }}>Taiwan, Province of China</option>
            <option value="Tanzania, United Republic of" data-code="+255" {{ old('country', $user->country ?? '') == "Tanzania, United Republic of" ? 'selected' : '' }}>Tanzania, United Republic of</option>
            <option value="Ukraine" data-code="+380" {{ old('country', $user->country ?? '') == "Ukraine" ? 'selected' : '' }}>Ukraine</option>
            <option value="Uganda" data-code="+256" {{ old('country', $user->country ?? '') == "Uganda" ? 'selected' : '' }}>Uganda</option>
            <option value="United States" data-code="+1" {{ old('country', $user->country ?? '') == "United States" ? 'selected' : '' }}>United States</option>
            <option value="Uruguay" data-code="+598" {{ old('country', $user->country ?? '') == "Uruguay" ? 'selected' : '' }}>Uruguay</option>
            <option value="Uzbekistan" data-code="+998" {{ old('country', $user->country ?? '') == "Uzbekistan" ? 'selected' : '' }}>Uzbekistan</option>
            <option value="Saint Vincent and the Grenadines" data-code="+1" {{ old('country', $user->country ?? '') == "Saint Vincent and the Grenadines" ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
            <option value="Venezuela, Bolivarian Republic of" data-code="+58" {{ old('country', $user->country ?? '') == "Venezuela, Bolivarian Republic of" ? 'selected' : '' }}>Venezuela, Bolivarian Republic of</option>
            <option value="Viet Nam" data-code="+84" {{ old('country', $user->country ?? '') == "Viet Nam" ? 'selected' : '' }}>Viet Nam</option>
            <option value="Vanuatu" data-code="+678" {{ old('country', $user->country ?? '') == "Vanuatu" ? 'selected' : '' }}>Vanuatu</option>
            <option value="Wallis and Futuna" data-code="+681" {{ old('country', $user->country ?? '') == "Wallis and Futuna" ? 'selected' : '' }}>Wallis and Futuna</option>
            <option value="Samoa" data-code="+685" {{ old('country', $user->country ?? '') == "Samoa" ? 'selected' : '' }}>Samoa</option>
            <option value="Yemen" data-code="+967" {{ old('country', $user->country ?? '') == "Yemen" ? 'selected' : '' }}>Yemen</option>
            <option value="South Africa" data-code="+27" {{ old('country', $user->country ?? '') == "South Africa" ? 'selected' : '' }}>South Africa</option>
            <option value="Zambia" data-code="+260" {{ old('country', $user->country ?? '') == "Zambia" ? 'selected' : '' }}>Zambia</option>
            <option value="Zimbabwe" data-code="+263" {{ old('country', $user->country ?? '') == "Zimbabwe" ? 'selected' : '' }}>Zimbabwe</option>
          </select>

          @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
          <label class="form-label" for="add-user-contact">Phone</label>
          <div class="row g-2">
              <div class="col-sm-3">
                  <input type="text" id="country-code" class="form-control @error('country_code') is-invalid @enderror" name="country_code" placeholder="+1" maxlength="4" value="{{ old('country_code', $user->code ?? '') }}">
                 
              </div>
              <div class="col-sm-9">
                  <input type="text" id="add-user-contact" class="form-control @error('phone') is-invalid @enderror phone-mask" name="phone" placeholder="123-456-7890" value="{{ old('phone', $user->phone ?? '') }}">
                  @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
          </div>
      </div>
      
      <div class="mb-3">
          <label class="form-label" for="city">City</label>
          <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="New York" value="{{ old('city', $user->city ?? '') }}">
          @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
          <label class="form-label" for="address">Address</label>
          <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="123 Main St" value="{{ old('address', $user->address ?? '') }}">
          @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
          <label class="form-label" for="status">Status</label>
          <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" >
            <option value="Active" {{ (old('status', $user->status ?? '') == 'Active') ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ (old('status', $user->status ?? '') == 'Inactive') ? 'selected' : '' }}>Inactive</option>
          </select>
          @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
          <label class="form-label" for="role">Role</label>
          <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" >
            @php
                $roles = ['Admin', 'Staff', 'Agent'];
                $selectedRole = isset($user) ? old('role', $user->roles->first()->name ?? '') : old('role');
            @endphp
        
            @foreach ($roles as $role)
                <option value="{{ $role }}" {{ $selectedRole === $role ? 'selected' : '' }}>
                    {{ $role }}
                </option>
            @endforeach
          </select>
          @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
          <label class="form-label" for="add-user-password">Password</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="add-user-password" name="password" placeholder="********" >
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
          <label class="form-label" for="add-user-confirm-password">Confirm Password</label>
          <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="add-user-confirm-password" name="password_confirmation" placeholder="********" >
          @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label" for="add-user-photo">Profile Photo</label>
        <input type="file" class="form-control @error('profile_photo_path') is-invalid @enderror" id="add-user-photo" name="profile_photo_path">
        @error('profile_photo_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div> 
      @if(isset($user) && $user->profile_photo_path)
      <div class="mb-3">
          <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="img-thumbnail" style="max-width: 150px;">
      </div>
      @endif
  
      <!-- Divider -->
      <hr class="my-4">
  
      <button type="submit" id="saveButton" class="btn btn-primary me-sm-3 me-1 data-submit">
        
        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status">
            <span class="visually-hidden">Loading...</span>
        </span>
        <span id="buttonText">Submit</span>
      </button>
    
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
  </form>
    
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="font-size: 1.25rem;">
        Are you sure you want to delete this user? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <form id="deleteForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          {{-- <button type="submit" class="btn btn-danger">Delete</button> --}}
          <button type="submit" id="deleteButton" class="btn btn-danger me-sm-3 me-1">
        
            <span id="delloadingSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            <span id="delbuttonText">Delete</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>








@endsection

@section('scripts')

<script>
  document.addEventListener('DOMContentLoaded', function() {
      const countrySelect = document.getElementById('country');
      const countryCodeInput = document.getElementById('country-code');
  
      countrySelect.addEventListener('change', function() {
          const selectedOption = countrySelect.options[countrySelect.selectedIndex];
          const countryCode = selectedOption.getAttribute('data-code');
          countryCodeInput.value = countryCode;
      });

      const offcanvas = document.getElementById('offcanvasAddUser');
      const shouldOpen = offcanvas.getAttribute('data-open') === 'true';

      if (shouldOpen) {
          const offcanvasInstance = new bootstrap.Offcanvas(offcanvas);
          offcanvasInstance.show();
      }
  });


  //button submitting 
  document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('addNewUserForm', 'saveButton', 'buttonText', 'loadingSpinner');
        // Add more instances as needed
        // new FormSubmitHandler('anotherFormId', 'anotherButtonId', 'anotherButtonTextId', 'anotherSpinnerId');
  });

  document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('deleteForm', 'deleteButton', 'delbuttonText', 'delloadingSpinner');
        // Add more instances as needed
        // new FormSubmitHandler('anotherFormId', 'anotherButtonId', 'anotherButtonTextId', 'anotherSpinnerId');
  });

  //delete 
  document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        
        const formAction = this.getAttribute('data-form-action');
        
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.setAttribute('action', formAction);
        
        const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        deleteConfirmationModal.show();
      });
    });
  });

  

  </script>
  

@endsection
  