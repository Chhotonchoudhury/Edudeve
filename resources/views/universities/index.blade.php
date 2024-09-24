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

<div class="card m-0 p-0">
    <div class="card-header" style="padding: 1%;">
        <h6 class="card-title mb-0">All Universities</h6>
        <!-- Search Form and Add New User Button Container -->
        <div class="header-actions">
            <form method="GET" action="{{ route('university.index') }}" class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search.."
                        value="{{ request()->query('search') }}">
                    <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <button class="dt-button add-new btn btn-primary ms-n1" tabindex="0" aria-controls="DataTables_Table_0" type="button" id="AddUniversity">
                <span><i class="bx bx-plus me-0 me-lg-2"></i><span class="d-none d-lg-inline-block">Add New University</span></span>
            </button>
        </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered mb-0">
        <thead class="table-light">
            <tr>
                <th class="p-2 col-0">Logo</th>
                <th class="p-2 col-3">Name</th>
                <th class="p-2 col-1">Acronym</th>
                <th class="p-2 col-2">Email</th>
                <th class="p-2 col-2">Phone</th>
                <th class="p-2 col-2">Country</th>
                <th class="p-2 col-1">Status</th>
                <th class="p-2 col-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            
          @if ($universities->isEmpty())
          <tr>
            <td colspan="8" class="text-center">
            <div class="text-center p-4 bg-light rounded">
                <img src="{{ asset('assets/img/hotImg/NoData.gif') }}" alt="No Data" class="img-fluid" style=" height: auto;">
                {{-- <h6 class="mt-2  text-danger">No students found.</h6> --}}
            </div>
            </td>
          </tr>
          @else

          @foreach($universities as $index => $row)
          <tr>
            <td class="p-1">
              <img src="{{ $row->logo ? asset('storage/' . $row->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($row->acronym) }}" 
                   alt="{{ $row->acronym }}" 
                   class="img-fluid rounded-circle"
                   style="width: 50px; height: 50px; object-fit: cover;">
            </td>
            <td class="p-1">{{ $row->name }}</td>
            <td class="p-1">{{ $row->acronym }}</td>
            <td class="p-1">{{ $row->email }}</td>
            <td class="p-1">{{ $row->phone }}</td>
            <td class="p-1">{{ $row->country }}</td>
            <td class="p-1">
                @if ($row->is_active == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">InActive</span>
                @endif
            </td>

            <td class="p-1 text-center">
                <!-- Container for buttons -->
                <div class="d-flex justify-content-center align-items-center">
                    <!-- Edit Button with Icon -->
                    <button class="btn btn-outline-primary mx-1 edit-button" data-id="{{ $row->id }}" title="Edit" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                        <i class='bx bx-edit'></i>
                    </button>
                    <!-- Delete Button with Icon -->
                    <a href="{{ route('university.show', $row->id) }}"><button class="btn btn-outline-primary mx-1 view-profile-btn" title="Profile" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                        <i class='bx bx-chevron-right'></i> <!-- Right Arrow Icon -->
                    </button></a>
                    <!-- Delete Button with Icon -->
                    <button class="btn btn-outline-danger mx-1 delete-btn" data-form-action="{{ route('university.delete', $row->id) }}" title="delete"  style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                      <i class='bx bx-trash'></i>
                    </button>
                </div>
            </td>
          </tr>
          @endforeach


          @endif
        </tbody>
      </table>
    
    </div>
    <div class="card-footer" style="padding: 1%">
        <!-- Total Records -->
        <div class="footer-info">
            Total Records: {{ $universities->total() }}
        </div>
        <!-- Pagination -->
        <div class="pagination-container">
            {{ $universities->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>


  <!---this is the for the offcanvas for the university ---->
  <form  action="{{ route('university.store') }}" id="UniForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="offcanvasUniversityForm" aria-labelledby="offcanvasUniversityFormLabel">
        <div class="offcanvas-header border-bottom" style="padding: 2%;">
            <h6 class="offcanvas-title"  id="offcanvasUniversityFormLabel">University Form</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <input type="hidden"  name="editId" id="editId" value="{{ old('editId') }}">
            <!-- University Name -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">University Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="University Name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="acronym" class="form-label">Acronym</label>
                    <input type="text" class="form-control @error('acronym') is-invalid @enderror" id="acronym" name="acronym" placeholder="Acronym" value="{{ old('acronym') }}">
                    @error('acronym')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="row mb-3">

                 <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="country">Country *</label>
                    <select id="country" name="country" class="form-select @error('country') is-invalid @enderror select2"  >
                      <option value="" data-code="">Select Country</option>
                      <option value="Andorra" data-code="+376"  {{ old('country') == "Andorra" ? 'selected' : '' }}>Andorra</option>
                      <option value="United Arab Emirates" data-code="+971" {{ old('country') == "United Arab Emirates" ? 'selected' : '' }}>United Arab Emirates</option>
                      <option value="Afghanistan" data-code="+93" {{ old('country') == "Afghanistan" ? 'selected' : '' }}>Afghanistan</option>
                      <option value="Antigua and Barbuda" data-code="+1" {{ old('country') == "Antigua and Barbuda" ? 'selected' : '' }}>Antigua and Barbuda</option>
                      <option value="Anguilla" data-code="+1" {{ old('country') == "Anguilla" ? 'selected' : '' }}>Anguilla</option>
                      <option value="Albania" data-code="+355" {{ old('country') == "Albania" ? 'selected' : '' }}>Albania</option>
                      <option value="Armenia" data-code="+374" {{ old('country') == "Armenia" ? 'selected' : '' }}>Armenia</option>
                      <option value="Angola" data-code="+244" {{ old('country') == "Angola" ? 'selected' : '' }}>Angola</option>
                      <option value="Argentina" data-code="+54" {{ old('country') == "Argentina" ? 'selected' : '' }}>Argentina</option>
                      <option value="American Samoa" data-code="+1" {{ old('country') == "American Samoa" ? 'selected' : '' }}>American Samoa</option>
                      <option value="Austria" data-code="+43" {{ old('country') == "Austria" ? 'selected' : '' }}>Austria</option>
                      <option value="Australia" data-code="+61" {{ old('country') == "Australia" ? 'selected' : '' }}>Australia</option>
                      <option value="Aruba" data-code="+297" {{ old('country') == "Aruba" ? 'selected' : '' }}>Aruba</option>
                      <option value="Åland Islands" data-code="+358" {{ old('country') == "Åland Islands" ? 'selected' : '' }}>Åland Islands</option>
                      <option value="Azerbaijan" data-code="+994" {{ old('country') == "Azerbaijan" ? 'selected' : '' }}>Azerbaijan</option>
                      <option value="Bosnia and Herzegovina" data-code="+387" {{ old('country') == "Bosnia and Herzegovina" ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                      <option value="Barbados" data-code="+1" {{ old('country') == "Barbados" ? 'selected' : '' }}>Barbados</option>
                      <option value="Bangladesh" data-code="+880" {{ old('country') == "Bangladesh" ? 'selected' : '' }}>Bangladesh</option>
                      <option value="Belgium" data-code="+32" {{ old('country') == "Belgium" ? 'selected' : '' }}>Belgium</option>
                      <option value="Burkina Faso" data-code="+226" {{ old('country') == "Burkina Faso" ? 'selected' : '' }}>Burkina Faso</option>
                      <option value="Bulgaria" data-code="+359" {{ old('country') == "Bulgaria" ? 'selected' : '' }}>Bulgaria</option>
                      <option value="Bahrain" data-code="+973" {{ old('country') == "Bahrain" ? 'selected' : '' }}>Bahrain</option>
                      <option value="Burundi" data-code="+257" {{ old('country') == "Burundi" ? 'selected' : '' }}>Burundi</option>
                      <option value="Benin" data-code="+229" {{ old('country') == "Benin" ? 'selected' : '' }}>Benin</option>
                      <option value="Saint Barthelemy" data-code="+590" {{ old('country') == "Saint Barthelemy" ? 'selected' : '' }}>Saint Barthelemy</option>
                      <option value="Bermuda" data-code="+1" {{ old('country') == "Bermuda" ? 'selected' : '' }}>Bermuda</option>
                      <option value="Brunei" data-code="+673" {{ old('country') == "Brunei" ? 'selected' : '' }}>Brunei</option>
                      <option value="Bolivia" data-code="+591" {{ old('country') == "Bolivia" ? 'selected' : '' }}>Bolivia</option>
                      <option value="Bonaire, Sint Eustatius and Saba" data-code="+599" {{ old('country') == "Bonaire, Sint Eustatius and Saba" ? 'selected' : '' }}>Bonaire, Sint Eustatius and Saba</option>
                      <option value="Brazil" data-code="+55" {{ old('country') == "Brazil" ? 'selected' : '' }}>Brazil</option>
                      <option value="Bahamas" data-code="+1" {{ old('country') == "Bahamas" ? 'selected' : '' }}>Bahamas</option>
                      <option value="Bhutan" data-code="+975" {{ old('country') == "Bhutan" ? 'selected' : '' }}>Bhutan</option>
                      <option value="Bouvet Island" data-code="+47" {{ old('country') == "Bouvet Island" ? 'selected' : '' }}>Bouvet Island</option>
                      <option value="Botswana" data-code="+267" {{ old('country') == "Botswana" ? 'selected' : '' }}>Botswana</option>
                      <option value="Belarus" data-code="+375" {{ old('country') == "Belarus" ? 'selected' : '' }}>Belarus</option>
                      <option value="Belize" data-code="+501" {{ old('country') == "Belize" ? 'selected' : '' }}>Belize</option>
                      <option value="Canada" data-code="+1" {{ old('country') == "Canada" ? 'selected' : '' }}>Canada</option>
                      <option value="Cocos (Keeling) Islands" data-code="+61" {{ old('country') == "Cocos (Keeling) Islands" ? 'selected' : '' }}>Cocos (Keeling) Islands</option>
                      <option value="Congo, Democratic Republic of the" data-code="+243" {{ old('country') == "Congo, Democratic Republic of the" ? 'selected' : '' }}>Congo, Democratic Republic of the</option>
                      <option value="Central African Republic" data-code="+236" {{ old('country') == "Central African Republic" ? 'selected' : '' }}>Central African Republic</option>
                      <option value="Congo, Republic of the" data-code="+242" {{ old('country') == "Congo, Republic of the" ? 'selected' : '' }}>Congo, Republic of the</option>
                      <option value="Switzerland" data-code="+41" {{ old('country') == "Switzerland" ? 'selected' : '' }}>Switzerland</option>
                      <option value="Ivory Coast" data-code="+225" {{ old('country') == "Ivory Coast" ? 'selected' : '' }}>Ivory Coast</option>
                      <option value="Cook Islands" data-code="+682" {{ old('country') == "Cook Islands" ? 'selected' : '' }}>Cook Islands</option>
                      <option value="Chile" data-code="+56" {{ old('country') == "Chile" ? 'selected' : '' }}>Chile</option>
                      <option value="Cameroon" data-code="+237" {{ old('country') == "Cameroon" ? 'selected' : '' }}>Cameroon</option>
                      <option value="China" data-code="+86" {{ old('country') == "China" ? 'selected' : '' }}>China</option>
                      <option value="Colombia" data-code="+57" {{ old('country') == "Colombia" ? 'selected' : '' }}>Colombia</option>
                      <option value="Costa Rica" data-code="+506" {{ old('country') == "Costa Rica" ? 'selected' : '' }}>Costa Rica</option>
                      <option value="Cuba" data-code="+53" {{ old('country') == "Cuba" ? 'selected' : '' }}>Cuba</option>
                      <option value="Cape Verde" data-code="+238" {{ old('country') == "Cape Verde" ? 'selected' : '' }}>Cape Verde</option>
                      <option value="Curacao" data-code="+599" {{ old('country') == "Curacao" ? 'selected' : '' }}>Curacao</option>
                      <option value="Christmas Island" data-code="+61" {{ old('country') == "Christmas Island" ? 'selected' : '' }}>Christmas Island</option>
                      <option value="Cyprus" data-code="+357" {{ old('country') == "Cyprus" ? 'selected' : '' }}>Cyprus</option>
                      <option value="Czech Republic" data-code="+420" {{ old('country') == "Czech Republic" ? 'selected' : '' }}>Czech Republic</option>
                      <option value="Germany" data-code="+49" {{ old('country') == "Germany" ? 'selected' : '' }}>Germany</option>
                      <option value="Djibouti" data-code="+253" {{ old('country') == "Djibouti" ? 'selected' : '' }}>Djibouti</option>
                      <option value="Denmark" data-code="+45" {{ old('country') == "Denmark" ? 'selected' : '' }}>Denmark</option>
                      <option value="Dominica" data-code="+1" {{ old('country') == "Dominica" ? 'selected' : '' }}>Dominica</option>
                      <option value="Dominican Republic" data-code="+1" {{ old('country') == "Dominican Republic" ? 'selected' : '' }}>Dominican Republic</option>
                      <option value="Algeria" data-code="+213" {{ old('country') == "Algeria" ? 'selected' : '' }}>Algeria</option>
                      <option value="Ecuador" data-code="+593" {{ old('country') == "Ecuador" ? 'selected' : '' }}>Ecuador</option>
                      <option value="Estonia" data-code="+372" {{ old('country') == "Estonia" ? 'selected' : '' }}>Estonia</option>
                      <option value="Egypt" data-code="+20" {{ old('country') == "Egypt" ? 'selected' : '' }}>Egypt</option>
                      <option value="Western Sahara" data-code="+212" {{ old('country') == "Western Sahara" ? 'selected' : '' }}>Western Sahara</option>
                      <option value="Eritrea" data-code="+291" {{ old('country') == "Eritrea" ? 'selected' : '' }}>Eritrea</option>
                      <option value="Spain" data-code="+34" {{ old('country') == "Spain" ? 'selected' : '' }}>Spain</option>
                      <option value="Ethiopia" data-code="+251" {{ old('country') == "Ethiopia" ? 'selected' : '' }}>Ethiopia</option>
                      <option value="Finland" data-code="+358" {{ old('country') == "Finland" ? 'selected' : '' }}>Finland</option>
                      <option value="Fiji" data-code="+679" {{ old('country') == "Fiji" ? 'selected' : '' }}>Fiji</option>
                      <option value="Falkland Islands" data-code="+500" {{ old('country') == "Falkland Islands" ? 'selected' : '' }}>Falkland Islands</option>
                      <option value="Micronesia" data-code="+691" {{ old('country') == "Micronesia" ? 'selected' : '' }}>Micronesia</option>
                      <option value="Faroe Islands" data-code="+298" {{ old('country') == "Faroe Islands" ? 'selected' : '' }}>Faroe Islands</option>
                      <option value="France" data-code="+33" {{ old('country') == "France" ? 'selected' : '' }}>France</option>
                      <option value="Gabon" data-code="+241" {{ old('country') == "Gabon" ? 'selected' : '' }}>Gabon</option>
                      <option value="United Kingdom" data-code="+44" {{ old('country') == "United Kingdom" ? 'selected' : '' }}>United Kingdom</option>
                      <option value="Grenada" data-code="+1" {{ old('country') == "Grenada" ? 'selected' : '' }}>Grenada</option>
                      <option value="Georgia" data-code="+995" {{ old('country') == "Georgia" ? 'selected' : '' }}>Georgia</option>
                      <option value="French Guiana" data-code="+594" {{ old('country') == "French Guiana" ? 'selected' : '' }}>French Guiana</option>
                      <option value="Ghana" data-code="+233" {{ old('country') == "Ghana" ? 'selected' : '' }}>Ghana</option>
                      <option value="Gibraltar" data-code="+350" {{ old('country') == "Gibraltar" ? 'selected' : '' }}>Gibraltar</option>
                      <option value="Greenland" data-code="+299" {{ old('country') == "Greenland" ? 'selected' : '' }}>Greenland</option>
                      <option value="Gambia" data-code="+220" {{ old('country') == "Gambia" ? 'selected' : '' }}>Gambia</option>
                      <option value="Guinea" data-code="+224" {{ old('country') == "Guinea" ? 'selected' : '' }}>Guinea</option>
                      <option value="Guadeloupe" data-code="+590" {{ old('country') == "Guadeloupe" ? 'selected' : '' }}>Guadeloupe</option>
                      <option value="Equatorial Guinea" data-code="+240" {{ old('country') == "Equatorial Guinea" ? 'selected' : '' }}>Equatorial Guinea</option>
                      <option value="Greece" data-code="+30" {{ old('country') == "Greece" ? 'selected' : '' }}>Greece</option>
                      <option value="South Georgia and the South Sandwich Islands" data-code="+500" {{ old('country') == "South Georgia and the South Sandwich Islands" ? 'selected' : '' }}>South Georgia and the South Sandwich Islands</option>
                      <option value="Guatemala" data-code="+502" {{ old('country') == "Guatemala" ? 'selected' : '' }}>Guatemala</option>
                      <option value="Guam" data-code="+1" {{ old('country') == "Guam" ? 'selected' : '' }}>Guam</option>
                      <option value="Guinea-Bissau" data-code="+245" {{ old('country') == "Guinea-Bissau" ? 'selected' : '' }}>Guinea-Bissau</option>
                      <option value="Guyana" data-code="+592" {{ old('country') == "Guyana" ? 'selected' : '' }}>Guyana</option>
                      <option value="Hong Kong" data-code="+852" {{ old('country') == "Hong Kong" ? 'selected' : '' }}>Hong Kong</option>
                      <option value="Heard Island and McDonald Islands" data-code="+672" {{ old('country') == "Heard Island and McDonald Islands" ? 'selected' : '' }}>Heard Island and McDonald Islands</option>
                      <option value="Honduras" data-code="+504" {{ old('country') == "Honduras" ? 'selected' : '' }}>Honduras</option>
                      <option value="Croatia" data-code="+385" {{ old('country') == "Croatia" ? 'selected' : '' }}>Croatia</option>
                      <option value="Haiti" data-code="+509" {{ old('country') == "Haiti" ? 'selected' : '' }}>Haiti</option>
                      <option value="Hungary" data-code="+36" {{ old('country') == "Hungary" ? 'selected' : '' }}>Hungary</option>
                      <option value="Indonesia" data-code="+62" {{ old('country') == "Indonesia" ? 'selected' : '' }}>Indonesia</option>
                      <option value="Ireland" data-code="+353" {{ old('country') == "Ireland" ? 'selected' : '' }}>Ireland</option>
                      <option value="Israel" data-code="+972" {{ old('country') == "Israel" ? 'selected' : '' }}>Israel</option>
                      <option value="Isle of Man" data-code="+44" {{ old('country') == "Isle of Man" ? 'selected' : '' }}>Isle of Man</option>
                      <option value="India" data-code="+91" {{ old('country') == "India" ? 'selected' : '' }}>India</option>
                      <option value="British Indian Ocean Territory" data-code="+246" {{ old('country') == "British Indian Ocean Territory" ? 'selected' : '' }}>British Indian Ocean Territory</option>
                      <option value="Iraq" data-code="+964" {{ old('country') == "Iraq" ? 'selected' : '' }}>Iraq</option>
                      <option value="Iran" data-code="+98" {{ old('country') == "Iran" ? 'selected' : '' }}>Iran</option>
                      <option value="Iceland" data-code="+354" {{ old('country') == "Iceland" ? 'selected' : '' }}>Iceland</option>
                      <option value="Italy" data-code="+39" {{ old('country') == "Italy" ? 'selected' : '' }}>Italy</option>
                      <option value="Jersey" data-code="+44" {{ old('country') == "Jersey" ? 'selected' : '' }}>Jersey</option>
                      <option value="Jamaica" data-code="+1" {{ old('country') == "Jamaica" ? 'selected' : '' }}>Jamaica</option>
                      <option value="Jordan" data-code="+962" {{ old('country') == "Jordan" ? 'selected' : '' }}>Jordan</option>
                      <option value="Japan" data-code="+81" {{ old('country') == "Japan" ? 'selected' : '' }}>Japan</option>
                      <option value="Kenya" data-code="+254" {{ old('country') == "Kenya" ? 'selected' : '' }}>Kenya</option>
                      <option value="Kyrgyzstan" data-code="+996" {{ old('country') == "Kyrgyzstan" ? 'selected' : '' }}>Kyrgyzstan</option>
                      <option value="Cambodia" data-code="+855" {{ old('country') == "Cambodia" ? 'selected' : '' }}>Cambodia</option>
                      <option value="Kiribati" data-code="+686" {{ old('country') == "Kiribati" ? 'selected' : '' }}>Kiribati</option>
                      <option value="Comoros" data-code="+269" {{ old('country') == "Comoros" ? 'selected' : '' }}>Comoros</option>
                      <option value="Saint Kitts and Nevis" data-code="+1" {{ old('country') == "Saint Kitts and Nevis" ? 'selected' : '' }}>Saint Kitts and Nevis</option>
                      <option value="North Korea" data-code="+850" {{ old('country') == "North Korea" ? 'selected' : '' }}>North Korea</option>
                      <option value="South Korea" data-code="+82" {{ old('country') == "South Korea" ? 'selected' : '' }}>South Korea</option>
                      <option value="Kuwait" data-code="+965" {{ old('country') == "Kuwait" ? 'selected' : '' }}>Kuwait</option>
                      <option value="Cayman Islands" data-code="+1" {{ old('country') == "Cayman Islands" ? 'selected' : '' }}>Cayman Islands</option>
                      <option value="Kazakhstan" data-code="+7" {{ old('country') == "Kazakhstan" ? 'selected' : '' }}>Kazakhstan</option>
                      <option value="Lao People's Democratic Republic" data-code="+856" {{ old('country') == "Lao People's Democratic Republic" ? 'selected' : '' }}>Lao People's Democratic Republic</option>
                      <option value="Lebanon" data-code="+961" {{ old('country') == "Lebanon" ? 'selected' : '' }}>Lebanon</option>
                      <option value="Saint Lucia" data-code="+1" {{ old('country') == "Saint Lucia" ? 'selected' : '' }}>Saint Lucia</option>
                      <option value="Liechtenstein" data-code="+423" {{ old('country') == "Liechtenstein" ? 'selected' : '' }}>Liechtenstein</option>
                      <option value="Sri Lanka" data-code="+94" {{ old('country') == "Sri Lanka" ? 'selected' : '' }}>Sri Lanka</option>
                      <option value="Liberia" data-code="+231" {{ old('country') == "Liberia" ? 'selected' : '' }}>Liberia</option>
                      <option value="Lesotho" data-code="+266" {{ old('country') == "Lesotho" ? 'selected' : '' }}>Lesotho</option>
                      <option value="Lithuania" data-code="+370" {{ old('country') == "Lithuania" ? 'selected' : '' }}>Lithuania</option>
                      <option value="Luxembourg" data-code="+352" {{ old('country') == "Luxembourg" ? 'selected' : '' }}>Luxembourg</option>
                      <option value="Latvia" data-code="+371" {{ old('country') == "Latvia" ? 'selected' : '' }}>Latvia</option>
                      <option value="Libya" data-code="+218" {{ old('country') == "Libya" ? 'selected' : '' }}>Libya</option>
                      <option value="Morocco" data-code="+212" {{ old('country') == "Morocco" ? 'selected' : '' }}>Morocco</option>
                      <option value="Monaco" data-code="+377" {{ old('country') == "Monaco" ? 'selected' : '' }}>Monaco</option>
                      <option value="Moldova" data-code="+373" {{ old('country') == "Moldova" ? 'selected' : '' }}>Moldova</option>
                      <option value="Montenegro" data-code="+382" {{ old('country') == "Montenegro" ? 'selected' : '' }}>Montenegro</option>
                      <option value="Saint Martin" data-code="+590" {{ old('country') == "Saint Martin" ? 'selected' : '' }}>Saint Martin</option>
                      <option value="Madagascar" data-code="+261" {{ old('country') == "Madagascar" ? 'selected' : '' }}>Madagascar</option>
                      <option value="Marshall Islands" data-code="+692" {{ old('country') == "Marshall Islands" ? 'selected' : '' }}>Marshall Islands</option>
                      <option value="North Macedonia" data-code="+389" {{ old('country') == "North Macedonia" ? 'selected' : '' }}>North Macedonia</option>
                      <option value="Mali" data-code="+223" {{ old('country') == "Mali" ? 'selected' : '' }}>Mali</option>
                      <option value="Myanmar" data-code="+95" {{ old('country') == "Myanmar" ? 'selected' : '' }}>Myanmar</option>
                      <option value="Mongolia" data-code="+976" {{ old('country') == "Mongolia" ? 'selected' : '' }}>Mongolia</option>
                      <option value="Macao" data-code="+853" {{ old('country') == "Macao" ? 'selected' : '' }}>Macao</option>
                      <option value="Northern Mariana Islands" data-code="+1" {{ old('country') == "Northern Mariana Islands" ? 'selected' : '' }}>Northern Mariana Islands</option>
                      <option value="Martinique" data-code="+596" {{ old('country') == "Martinique" ? 'selected' : '' }}>Martinique</option>
                      <option value="Mauritania" data-code="+222" {{ old('country') == "Mauritania" ? 'selected' : '' }}>Mauritania</option>
                      <option value="Montserrat" data-code="+1" {{ old('country') == "Montserrat" ? 'selected' : '' }}>Montserrat</option>
                      <option value="Malta" data-code="+356" {{ old('country') == "Malta" ? 'selected' : '' }}>Malta</option>
                      <option value="Mauritius" data-code="+230" {{ old('country') == "Mauritius" ? 'selected' : '' }}>Mauritius</option>
                      <option value="Maldives" data-code="+960" {{ old('country') == "Maldives" ? 'selected' : '' }}>Maldives</option>
                      <option value="Malawi" data-code="+265" {{ old('country') == "Malawi" ? 'selected' : '' }}>Malawi</option>
                      <option value="Mexico" data-code="+52" {{ old('country') == "Mexico" ? 'selected' : '' }}>Mexico</option>
                      <option value="Malaysia" data-code="+60" {{ old('country') == "Malaysia" ? 'selected' : '' }}>Malaysia</option>
                      <option value="Mozambique" data-code="+258" {{ old('country') == "Mozambique" ? 'selected' : '' }}>Mozambique</option>
                      <option value="Namibia" data-code="+264" {{ old('country') == "Namibia" ? 'selected' : '' }}>Namibia</option>
                      <option value="New Caledonia" data-code="+687" {{ old('country') == "New Caledonia" ? 'selected' : '' }}>New Caledonia</option>
                      <option value="Niger" data-code="+227" {{ old('country') == "Niger" ? 'selected' : '' }}>Niger</option>
                      <option value="Norfolk Island" data-code="+672" {{ old('country') == "Norfolk Island" ? 'selected' : '' }}>Norfolk Island</option>
                      <option value="Nigeria" data-code="+234" {{ old('country') == "Nigeria" ? 'selected' : '' }}>Nigeria</option>
                      <option value="Nicaragua" data-code="+505" {{ old('country') == "Nicaragua" ? 'selected' : '' }}>Nicaragua</option>
                      <option value="Netherlands" data-code="+31" {{ old('country') == "Netherlands" ? 'selected' : '' }}>Netherlands</option>
                      <option value="Norway" data-code="+47" {{ old('country') == "Norway" ? 'selected' : '' }}>Norway</option>
                      <option value="Nepal" data-code="+977" {{ old('country') == "Nepal" ? 'selected' : '' }}>Nepal</option>
                      <option value="Nauru" data-code="+674" {{ old('country') == "Nauru" ? 'selected' : '' }}>Nauru</option>
                      <option value="Niue" data-code="+683" {{ old('country') == "Niue" ? 'selected' : '' }}>Niue</option>
                      <option value="New Zealand" data-code="+64" {{ old('country') == "New Zealand" ? 'selected' : '' }}>New Zealand</option>
                      <option value="Oman" data-code="+968" {{ old('country') == "Oman" ? 'selected' : '' }}>Oman</option>
                      <option value="Panama" data-code="+507" {{ old('country') == "Panama" ? 'selected' : '' }}>Panama</option>
                      <option value="Peru" data-code="+51" {{ old('country') == "Peru" ? 'selected' : '' }}>Peru</option>
                      <option value="French Polynesia" data-code="+689" {{ old('country') == "French Polynesia" ? 'selected' : '' }}>French Polynesia</option>
                      <option value="Papua New Guinea" data-code="+675" {{ old('country') == "Papua New Guinea" ? 'selected' : '' }}>Papua New Guinea</option>
                      <option value="Philippines" data-code="+63" {{ old('country') == "Philippines" ? 'selected' : '' }}>Philippines</option>
                      <option value="Pakistan" data-code="+92" {{ old('country') == "Pakistan" ? 'selected' : '' }}>Pakistan</option>
                      <option value="Poland" data-code="+48" {{ old('country') == "Poland" ? 'selected' : '' }}>Poland</option>
                      <option value="Saint Pierre and Miquelon" data-code="+508" {{ old('country') == "Saint Pierre and Miquelon" ? 'selected' : '' }}>Saint Pierre and Miquelon</option>
                      <option value="Pitcairn" data-code="+64" {{ old('country') == "Pitcairn" ? 'selected' : '' }}>Pitcairn</option>
                      <option value="Puerto Rico" data-code="+1" {{ old('country') == "Puerto Rico" ? 'selected' : '' }}>Puerto Rico</option>
                      <option value="Palestine, State of" data-code="+970" {{ old('country') == "Palestine, State of" ? 'selected' : '' }}>Palestine, State of</option>
                      <option value="Portugal" data-code="+351" {{ old('country') == "Portugal" ? 'selected' : '' }}>Portugal</option>
                      <option value="Palau" data-code="+680" {{ old('country') == "Palau" ? 'selected' : '' }}>Palau</option>
                      <option value="Paraguay" data-code="+595" {{ old('country') == "Paraguay" ? 'selected' : '' }}>Paraguay</option>
                      <option value="Qatar" data-code="+974" {{ old('country') == "Qatar" ? 'selected' : '' }}>Qatar</option>
                      <option value="Réunion" data-code="+262" {{ old('country') == "Réunion" ? 'selected' : '' }}>Réunion</option>
                      <option value="Romania" data-code="+40" {{ old('country') == "Romania" ? 'selected' : '' }}>Romania</option>
                      <option value="Serbia" data-code="+381" {{ old('country') == "Serbia" ? 'selected' : '' }}>Serbia</option>
                      <option value="Russian Federation" data-code="+7" {{ old('country') == "Russian Federation" ? 'selected' : '' }}>Russian Federation</option>
                      <option value="Rwanda" data-code="+250" {{ old('country') == "Rwanda" ? 'selected' : '' }}>Rwanda</option>
                      <option value="Saudi Arabia" data-code="+966" {{ old('country') == "Saudi Arabia" ? 'selected' : '' }}>Saudi Arabia</option>
                      <option value="Solomon Islands" data-code="+677" {{ old('country') == "Solomon Islands" ? 'selected' : '' }}>Solomon Islands</option>
                      <option value="Seychelles" data-code="+248" {{ old('country') == "Seychelles" ? 'selected' : '' }}>Seychelles</option>
                      <option value="Sudan" data-code="+249" {{ old('country') == "Sudan" ? 'selected' : '' }}>Sudan</option>
                      <option value="Sweden" data-code="+46" {{ old('country') == "Sweden" ? 'selected' : '' }}>Sweden</option>
                      <option value="Singapore" data-code="+65" {{ old('country') == "Singapore" ? 'selected' : '' }}>Singapore</option>
                      <option value="Saint Helena, Ascension and Tristan da Cunha" data-code="+290" {{ old('country') == "Saint Helena, Ascension and Tristan da Cunha" ? 'selected' : '' }}>Saint Helena, Ascension and Tristan da Cunha</option>
                      <option value="Slovenia" data-code="+386" {{ old('country') == "Slovenia" ? 'selected' : '' }}>Slovenia</option>
                      <option value="Svalbard and Jan Mayen" data-code="+47" {{ old('country') == "Svalbard and Jan Mayen" ? 'selected' : '' }}>Svalbard and Jan Mayen</option>
                      <option value="Slovakia" data-code="+421" {{ old('country') == "Slovakia" ? 'selected' : '' }}>Slovakia</option>
                      <option value="Sierra Leone" data-code="+232" {{ old('country') == "Sierra Leone" ? 'selected' : '' }}>Sierra Leone</option>
                      <option value="San Marino" data-code="+378" {{ old('country') == "San Marino" ? 'selected' : '' }}>San Marino</option>
                      <option value="Senegal" data-code="+221" {{ old('country') == "Senegal" ? 'selected' : '' }}>Senegal</option>
                      <option value="Somalia" data-code="+252" {{ old('country') == "Somalia" ? 'selected' : '' }}>Somalia</option>
                      <option value="Suriname" data-code="+597" {{ old('country') == "Suriname" ? 'selected' : '' }}>Suriname</option>
                      <option value="South Sudan" data-code="+211" {{ old('country') == "South Sudan" ? 'selected' : '' }}>South Sudan</option>
                      <option value="Sao Tome and Principe" data-code="+239" {{ old('country') == "Sao Tome and Principe" ? 'selected' : '' }}>Sao Tome and Principe</option>
                      <option value="El Salvador" data-code="+503" {{ old('country') == "El Salvador" ? 'selected' : '' }}>El Salvador</option>
                      <option value="Sint Maarten (Dutch part)" data-code="+1" {{ old('country') == "Sint Maarten (Dutch part)" ? 'selected' : '' }}>Sint Maarten (Dutch part)</option>
                      <option value="Syrian Arab Republic" data-code="+963" {{ old('country') == "Syrian Arab Republic" ? 'selected' : '' }}>Syrian Arab Republic</option>
                      <option value="Swaziland" data-code="+268" {{ old('country') == "Swaziland" ? 'selected' : '' }}>Swaziland</option>
                      <option value="Chad" data-code="+235" {{ old('country') == "Chad" ? 'selected' : '' }}>Chad</option>
                      <option value="Togo" data-code="+228" {{ old('country') == "Togo" ? 'selected' : '' }}>Togo</option>
                      <option value="Thailand" data-code="+66" {{ old('country') == "Thailand" ? 'selected' : '' }}>Thailand</option>
                      <option value="Tajikistan" data-code="+992" {{ old('country') == "Tajikistan" ? 'selected' : '' }}>Tajikistan</option>
                      <option value="Tokelau" data-code="+690" {{ old('country') == "Tokelau" ? 'selected' : '' }}>Tokelau</option>
                      <option value="Turkmenistan" data-code="+993" {{ old('country') == "Turkmenistan" ? 'selected' : '' }}>Turkmenistan</option>
                      <option value="Timor-Leste" data-code="+670" {{ old('country') == "Timor-Leste" ? 'selected' : '' }}>Timor-Leste</option>
                      <option value="Tonga" data-code="+676" {{ old('country') == "Tonga" ? 'selected' : '' }}>Tonga</option>
                      <option value="Trinidad and Tobago" data-code="+1" {{ old('country') == "Trinidad and Tobago" ? 'selected' : '' }}>Trinidad and Tobago</option>
                      <option value="Tunisia" data-code="+216" {{ old('country') == "Tunisia" ? 'selected' : '' }}>Tunisia</option>
                      <option value="Turkey" data-code="+90" {{ old('country') == "Turkey" ? 'selected' : '' }}>Turkey</option>
                      <option value="Tuvalu" data-code="+688" {{ old('country') == "Tuvalu" ? 'selected' : '' }}>Tuvalu</option>
                      <option value="Taiwan, Province of China" data-code="+886" {{ old('country') == "Taiwan, Province of China" ? 'selected' : '' }}>Taiwan, Province of China</option>
                      <option value="Tanzania, United Republic of" data-code="+255" {{ old('country') == "Tanzania, United Republic of" ? 'selected' : '' }}>Tanzania, United Republic of</option>
                      <option value="Ukraine" data-code="+380" {{ old('country') == "Ukraine" ? 'selected' : '' }}>Ukraine</option>
                      <option value="Uganda" data-code="+256" {{ old('country') == "Uganda" ? 'selected' : '' }}>Uganda</option>
                      <option value="United States" data-code="+1" {{ old('country') == "United States" ? 'selected' : '' }}>United States</option>
                      <option value="Uruguay" data-code="+598" {{ old('country') == "Uruguay" ? 'selected' : '' }}>Uruguay</option>
                      <option value="Uzbekistan" data-code="+998" {{ old('country') == "Uzbekistan" ? 'selected' : '' }}>Uzbekistan</option>
                      <option value="Saint Vincent and the Grenadines" data-code="+1" {{ old('country') == "Saint Vincent and the Grenadines" ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
                      <option value="Venezuela, Bolivarian Republic of" data-code="+58" {{ old('country') == "Venezuela, Bolivarian Republic of" ? 'selected' : '' }}>Venezuela, Bolivarian Republic of</option>
                      <option value="Viet Nam" data-code="+84" {{ old('country') == "Viet Nam" ? 'selected' : '' }}>Viet Nam</option>
                      <option value="Vanuatu" data-code="+678" {{ old('country') == "Vanuatu" ? 'selected' : '' }}>Vanuatu</option>
                      <option value="Wallis and Futuna" data-code="+681" {{ old('country') == "Wallis and Futuna" ? 'selected' : '' }}>Wallis and Futuna</option>
                      <option value="Samoa" data-code="+685" {{ old('country') == "Samoa" ? 'selected' : '' }}>Samoa</option>
                      <option value="Yemen" data-code="+967" {{ old('country') == "Yemen" ? 'selected' : '' }}>Yemen</option>
                      <option value="South Africa" data-code="+27" {{ old('country') == "South Africa" ? 'selected' : '' }}>South Africa</option>
                      <option value="Zambia" data-code="+260" {{ old('country') == "Zambia" ? 'selected' : '' }}>Zambia</option>
                      <option value="Zimbabwe" data-code="+263" {{ old('country') == "Zimbabwe" ? 'selected' : '' }}>Zimbabwe</option>
                    </select>
                    @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">
                    <label class="form-label" for="add-user-contact">Phone *</label>
                    <div class="row g-2">
                        <div class="col-sm-3">
                            <input type="text" id="country-code" class="form-control @error('country_code') is-invalid @enderror" name="country_code" placeholder="+1" maxlength="4" value="{{ old('country_code', $user->code ?? '') }}">
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror phone-mask" name="phone" placeholder="123-456-7890" value="{{ old('phone', $user->phone ?? '') }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="city" class="form-label">City *</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="City" value="{{ old('city') }}">
                    @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Acronym -->
            <div class="row mb-3">
                 <!-- State -->
                 <div class="col-md-6">
                    <label for="state" class="form-label">State *</label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="State" value="{{ old('state') }}">
                    @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Postal Code -->
                <div class="col-md-6">
                    <label for="postal_code" class="form-label">Postal Code *</label>
                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" placeholder="Postal Code" value="{{ old('postal_code') }}">
                    @error('postal_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <!-- City -->
           
            
            <div class="row mb-3">
                 <!-- Address -->
                 <div class="col-md-6">
                    <label for="address" class="form-label">Address *</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Address" >{{ old('address') }}</textarea>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                 <!-- Mission Statement -->
                <div class="col-md-6">
                    <label for="mission_statement" class="form-label">Mission Statement</label>
                    <textarea class="form-control @error('mission_statement') is-invalid @enderror" id="mission_statement" name="mission_statement" placeholder="Mission Statement">{{ old('mission_statement') }}</textarea>
                    @error('mission_statement')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Vision Statement -->
                <div class="col-md-6">
                    <label for="vision_statement" class="form-label">Vision Statement</label>
                    <textarea class="form-control @error('vision_statement') is-invalid @enderror" id="vision_statement" name="vision_statement" placeholder="Vision Statement">{{ old('vision_statement') }}</textarea>
                    @error('vision_statement')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <!-- Website -->
                <div class="col-md-6">
                    <label for="website" class="form-label">Website</label>
                    <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name="website" placeholder="Website" value="{{ old('website') }}">
                    @error('website')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                 <!-- Active Status -->
                <div class="col-md-6">
                    <label for="is_active" class="form-label">Active Status *</label>
                    <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            
            <div class="row mb-3">

                 <!-- Logo -->
                <div class="col-md-6">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*"  onchange="previewImage(this, 'LogoPreview')">
                    @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="logoPreview" class="mt-2">
                        <img id="LogoPreview" src="" alt="Logo Preview" style="max-width: 100px; display: none;">
                    </div>
                </div>

                <!-- Banner -->
                <div class="col-md-6">
                    <label for="banner" class="form-label">Banner</label>
                    <input type="file" class="form-control @error('banner') is-invalid @enderror" id="banner" name="banner" accept="image/*" onchange="previewImage(this, 'BannerPreview')">
                    @error('banner')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="bannerPreview" class="mt-2">
                        <img id="BannerPreview" src="" alt="Banner Preview" style="max-width: 300px; max-height: 100px; display: none;">
                    </div>
                </div>

            </div>

            <!-- Divider -->
            <hr class="my-4">

            <!-- Submit Button -->
            <button type="submit" id="UnisaveButton" class="btn btn-primary me-sm-3 me-1 data-submit">
                <span id="UniSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span id="UniversityButtonText">Submit</span>
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </div>
  </form>
  <!---end of the offcanvas ---->

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="font-size: 1.25rem;">
          Are you sure you want to delete the university? This action cannot be undone.
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
  <!--- Delete confirmation model end --->

@endsection

@section('scripts')

@if (session('show_modal'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editIdInput = document.getElementById('editId');
            var actIdValue = editIdInput ? editIdInput.value : null;
            if (actIdValue) {
                // If the value exists
                document.getElementById('offcanvasUniversityFormLabel').textContent = 'Update University';
                document.getElementById('UniversityButtonText').textContent = 'Update';
            }
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasUniversityForm'));
            offcanvas.show();
        });
    </script>
@endif

<script>
    document.getElementById('AddUniversity').addEventListener('click', function(event) {
        event.preventDefault();
        
        // Clear the form inputs
        document.getElementById('editId').value = '';
        document.getElementById('name').value = '';
        document.getElementById('acronym').value = '';
        document.getElementById('email').value = '';
        document.getElementById('country').value = '';
        document.getElementById('country-code').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('city').value = '';
        document.getElementById('state').value = '';
        document.getElementById('postal_code').value = '';
        document.getElementById('address').value = '';
        document.getElementById('description').value = '';
        document.getElementById('mission_statement').value = '';
        document.getElementById('vision_statement').value = '';
        document.getElementById('website').value = '';
        document.getElementById('is_active').value = '1'; // Set default to Active
        // Hide the previews if any
        document.getElementById('logo').value = ''; // Clear file input
        document.getElementById('banner').value = ''; // Clear file input
        document.getElementById('LogoPreview').style.display = 'none';
        document.getElementById('BannerPreview').style.display = 'none';
        // Update modal title and button text
        document.getElementById('offcanvasUniversityFormLabel').textContent = 'Add New University';
        document.getElementById('UniversityButtonText').textContent = 'Submit';
        
        // Show the offcanvas
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasUniversityForm'));
        offcanvas.show();
    });
    //contry on change set the phone code
    document.addEventListener('DOMContentLoaded', function() {
        const countrySelect = document.getElementById('country');
        const countryCodeInput = document.getElementById('country-code');
    
        countrySelect.addEventListener('change', function() {
            const selectedOption = countrySelect.options[countrySelect.selectedIndex];
            const countryCode = selectedOption.getAttribute('data-code');
            countryCodeInput.value = countryCode;
        });

    });
    //function for the image preview 
    function previewImage(input, previewId) {
        const previewElement = document.getElementById(previewId);
        
        // Check if a file was selected
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]); // Convert the image file into base64 data
        } else {
            previewElement.src = '';
            previewElement.style.display = 'none';
        }
    }

    //this is the function for the fetching the records from the backend and show the model case 
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to edit buttons
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const universityId = this.dataset.id; // Get the university ID from the data attribute
                fetchUniversityData(universityId);
            });
        });

        function fetchUniversityData(id) {
            fetch(`/university/${id}`)
                .then(response => response.json())
                .then(data => {
                    // Populate the form with the fetched data
                    document.getElementById('name').value = data.name;
                    document.getElementById('acronym').value = data.acronym;
                    document.getElementById('email').value = data.email;
                    document.getElementById('country').value = data.country;
                    document.getElementById('country-code').value = data.country_code;
                    document.getElementById('phone').value = data.phone;
                    document.getElementById('city').value = data.city;
                    document.getElementById('state').value = data.state;
                    document.getElementById('postal_code').value = data.postal_code;
                    document.getElementById('address').value = data.address;
                    document.getElementById('description').value = data.description;
                    document.getElementById('mission_statement').value = data.mission_statement;
                    document.getElementById('vision_statement').value = data.vision_statement;
                    document.getElementById('website').value = data.website;
                    document.getElementById('is_active').value = data.is_active;
                    if (data.logo) {
                        document.getElementById('LogoPreview').src = `/storage/${data.logo}`;
                        document.getElementById('LogoPreview').style.display = 'block';
                    }
                    if (data.banner) {
                        document.getElementById('BannerPreview').src = `/storage/${data.banner}`;
                        document.getElementById('BannerPreview').style.display = 'block';
                    }
                    document.getElementById('editId').value = data.id;
                    document.getElementById('offcanvasUniversityFormLabel').textContent = 'Update University';
                    document.getElementById('UniversityButtonText').textContent = 'Update';
                    // Show the offcanvas form
                    var myOffcanvas = document.getElementById('offcanvasUniversityForm');
                    var offcanvas = new bootstrap.Offcanvas(myOffcanvas);
                    offcanvas.show();
                })
                .catch(error => console.error('Error:', error));
        }
    });

    //this function for the deletation case 
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

    //button for the save button of leads
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('UniForm', 'UnisaveButton', 'UniversityButtonText', 'UniSpinner');
        // Add more instances as needed
        new FormSubmitHandler('deleteForm', 'deleteButton', 'delbuttonText', 'delloadingSpinner');
    });


</script>

@endsection