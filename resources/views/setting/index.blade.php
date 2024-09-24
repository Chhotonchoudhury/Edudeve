@extends('layouts/layoutMaster')

@section('title', 'Roles & Permissions')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('content')
<!-- Success Message -->


{{-- Debugging --}}

<!--company tab--->
@if($errors->has('company_name') || $errors->has('company_moto') || $errors->has('email') || $errors->has('phone') || $errors->has('address') || $errors->has('description'))
@php $cpTab = 1; @endphp
@elseif($errors->has('small_logo') || $errors->has('favicon')||$errors->has('wide_logo'))
@php $cpTab = 2; @endphp
@elseif($errors->has('facebook') || $errors->has('google') || $errors->has('linkedin') || $errors->has('instagram') || $errors->has('twitter') || $errors->has('quora'))
@php $cpTab = 3; @endphp
@elseif(session('cp_tab'))
@php $cpTab = session('cp_tab'); @endphp
@else
@php $cpTab = 1; @endphp
@endif
<!---company tab -->

<!---student tab --->
@if(session('active_tab'))
@php $activeTab = session('active_tab'); @endphp
@elseif($errors->has('smtp_host') || $errors->has('smtp_port') || $errors->has('smtp_user') || $errors->has('smtp_password') || $errors->has('smtp_encryption') || $errors->has('sender_name') || $errors->has('sender_email'))
@php $activeTab = 6; @endphp
@else
@php $activeTab = 1; @endphp
@endif
<!---end tab--->

<!-- Card Container -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center " style="padding: 1%; background-color: #fafafa;">
        <h6 class="card-title mb-0"><i class="bx bx-cog me-2"></i>Settings</h6>
    </div>

    <!-- Sidebar Navigation -->
    <div class="row g-0">
        <div class="col-md-2">
            <ul class="nav nav-pills p-3 border-end" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 1 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#nav-company" role="tab">
                        <i class="bx bx-buildings me-2"></i> <span>Company</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 2 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#nav-messages" role="tab">
                        <i class="bx bx-pie-chart-alt-2  me-2"></i> <span>All Status</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 3 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#nav-category" role="tab">
                        <i class="bx bx-category-alt me-2"></i> <span>Categories</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 4 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#nav-lead" role="tab">
                        <i class="bx bx-share-alt me-2"></i> <span>Lead Source</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 5 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#activity-status" role="tab">
                        <i class="bx bx-task me-2"></i> <span>Activity Status</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 6 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#email-setup" role="tab">
                        <i class="bx bx-mail-send me-2"></i> <span>Email Setup</span>
                    </button>
                </li>
            </ul>
            
            
            
            
            
            
            
            
        </div>

        <!-- Tab Content -->
        <div class="col-md-10">
            <div class="tab-content p-2">
                <!--this is first company tab--->
                <div class="tab-pane fade {{ $activeTab === 1 ? 'show active' : '' }}" id="nav-company" role="tabpanel">
                    <div class="card mb-0">
                        <div class="card-header border-bottom">
                          <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link {{ $cpTab === 1 ? 'active' : '' }}  " data-bs-toggle="tab" data-bs-target="#form-tabs-personal" role="tab" aria-selected="true">
                                General Info
                              </button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link {{ $cpTab === 2 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#form-tabs-account" role="tab" aria-selected="false" tabindex="-1">
                                Logos
                              </button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link {{ $cpTab === 3 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#form-tabs-social" role="tab" aria-selected="false" tabindex="-1">
                                Social Links
                              </button>
                            </li>
                          </ul>
                        </div>
    
                        <div class="tab-content">
                          <div class="tab-pane fade {{ $cpTab === 1 ? 'active show' : '' }}" id="form-tabs-personal" role="tabpanel">
                            <form method="POST" id="infoForm" action="{{ route('settings.company.info') }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="formtabs-first-name">Company Name</label>
                                        <input type="text" id="formtabs-first-name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Company Name" value="{{ old('company_name', $companyInfo->company_name ?? '') }}">
                                        @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="formtabs-last-name">Company Moto / Slogan</label>
                                        <input type="text" id="formtabs-last-name" name="company_moto" class="form-control @error('company_moto') is-invalid @enderror" placeholder="Company Moto" value="{{ old('company_moto', $companyInfo->company_moto ?? '') }}">
                                        @error('company_moto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="formtabs-birthdate">Email Address</label>
                                        <input type="email" id="formtabs-birthdate" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="company@mail.com" value="{{ old('email', $companyInfo->email ?? '') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="formtabs-phone">Phone No</label>
                                        <input type="text" id="formtabs-phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+1 658 799 8941" value="{{ old('phone', $companyInfo->phone ?? '') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="basic-default-message">Address / Location</label>
                                        <textarea id="basic-default-message" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Company Address / Location">{{ old('address', $companyInfo->address ?? '') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="basic-default-message">Company Description</label>
                                        <textarea id="basic-default-message" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Tell us about your company">{{ old('description', $companyInfo->description ?? '') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" id="btnInfo" class="btn btn-primary me-sm-3 me-1">
                                        <span id="loadingSpinnerInfo" class="spinner-border spinner-border-sm d-none" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </span>
                                        <span id="buttonTextInfo">Update</span>
                                    </button>
                                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                </div>
                            </form>
                            
                          </div>
                          <div class="tab-pane fade {{ $cpTab === 2 ? 'active show' : '' }} " id="form-tabs-account" role="tabpanel">
                            <form action="{{ route('setting.company.upload.logos') }}" id="LogoForm" method="POST" enctype="multipart/form-data">
                                @csrf
                              <div class="row g-3">
                                           <!-- Small Logo Upload -->
                                <div class="col-md-4 text-center">
                                    <div class="mb-2">
                                        <img id="small_logo_preview" src=" {{ $companyInfo->small_logo ? asset('storage/' . $companyInfo->small_logo) : asset('assets/img/logos/logo2.png') }}" alt="Small Logo" class="img-fluid border rounded p-1" style="width: 120px; height: 120px; object-fit: cover;">
                                    </div>
                                </div>  
                                
                                <div class="col-md-4 text-center">
                                    <div class="mb-2">
                                        <img id="wide_logo_preview" src="{{ $companyInfo->wide_logo ? asset('storage/' . $companyInfo->wide_logo) : asset('assets/img/logos/logo2.png') }}" alt="Wide Logo" class="img-fluid border rounded p-1" style="width: 220px; height: 100px; object-fit: cover;">
                                    </div>
                                </div>  

                                <div class="col-md-4 text-center">
                                    <div class="mb-2">
                                            <img id="favicon_preview" src="{{ $companyInfo->favicon ? asset('storage/' . $companyInfo->favicon) : asset('assets/img/logos/logo2.png') }}" alt="Favicon" class="img-fluid border rounded p-1" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                </div>  

                                <div class="col-md-4 text-center">
                                    
                                    <input type="file" id="small_logo" name="small_logo" class="form-control @error('small_logo') is-invalid @enderror" accept="image/*">
                                    <label for="small_logo" class="form-label mt-2">Small Logo</label>

                                    @error('small_logo') is-invalid @enderror
                                </div>

                                <!-- Wide Logo Upload -->
                                <div class="col-md-4 text-center">
                                    
                                    <input type="file" id="wide_logo" name="wide_logo" class="form-control @error('wide_logo') is-invalid @enderror" accept="image/*">
                                    <label for="wide_logo" class="form-label mt-2">Wide Logo</label>
                                    @error('wide_logo') is-invalid @enderror
                                </div>

                                    <!-- Favicon Upload -->
                                    <div class="col-md-4 text-center">
                                        
                                        <input type="file" id="favicon" name="favicon" class="form-control @error('favicon') is-invalid @enderror" accept="image/*">
                                        <label for="favicon" class="form-label mt-2">Favicon</label>
                                        @error('favicon') is-invalid @enderror
                                    </div>
                              </div>
                              <div class="pt-4">
                                <button type="submit" id="btnLogo" class="btn btn-primary me-sm-3 me-1">
                                    <span id="loadingSpinnerLogo" class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </span>
                                    <span id="buttonTextLogo">Update</span>
                                </button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                              </div>
                            </form>
                          </div>
                          <div class="tab-pane fade {{ $cpTab === 3 ? 'active show' : '' }} " id="form-tabs-social" role="tabpanel">
                            <form id="LinksForm" action="{{ route('update.social.links') }}" method="POST">
                                @csrf

                                
                              <div class="row g-3">
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-twitter">Twitter</label>
                                  <input type="text" name="twitter" id="formtabs-twitter" class="form-control @error('twitter') is-invalid @enderror" placeholder="https://twitter.com/abc" value="{{ old('twitter', $companyInfo->social_links['twitter'] ?? '')  }}">
                                  @error('twitter')
                                  <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-facebook">Facebook</label>
                                  <input type="text" name="facebook" id="formtabs-facebook" class="form-control @error('facebook') is-invalid @enderror" placeholder="https://facebook.com/abc" value="{{ old('facebook', $companyInfo->social_links['facebook'] ?? '')  }}">
                                   @error('facebook')
                                  <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                  
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-google">Google+</label>
                                  <input type="text" name="google" id="formtabs-google" class="form-control @error('google') is-invalid @enderror" placeholder="https://plus.google.com/abc" value="{{ old('google', $companyInfo->social_links['google'] ?? '')  }}">
                                   @error('google')
                                  <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror

                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-linkedin">Linkedin</label>
                                  <input type="text" name="linkedin" id="formtabs-linkedin" class="form-control @error('linkedin') is-invalid @enderror" placeholder="https://linkedin.com/abc" value="{{ old('linkedin', $companyInfo->social_links['linkedin'] ?? '')  }}">
                                   @error('linkedin')
                                  <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-instagram">Instagram</label>
                                  <input type="text" name="instagram" id="formtabs-instagram" class="form-control @error('instagram') is-invalid @enderror" placeholder="https://instagram.com/abc" value="{{ old('instagram', $companyInfo->social_links['instagram'] ?? '')  }}">
                                   @error('instagram')
                                  <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-quora">Quora</label>
                                  <input type="text" name="quora" id="formtabs-quora" class="form-control @error('quora') is-invalid @enderror" placeholder="https://quora.com/abc" value="{{ old('quora', $companyInfo->social_links['quora'] ?? '')  }}">
                                   @error('quora')
                                  <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>
                              <div class="pt-4">
                                <button type="submit" id="btnLink" class="btn btn-primary me-sm-3 me-1">
                                    <span id="loadingSpinnerLink" class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </span>
                                    <span id="buttonTextLink">Update</span>
                                </button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                              </div>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
                <!--this is the second status tab --->
                <div class="tab-pane fade {{ $activeTab === 2 ? 'show active' : '' }}" id="nav-messages" role="tabpanel">
                        <!-- Upgraded Card Design -->
                    <div class=" p-2 mb-3" style="border-left: 4px solid #007bff;background-color: #f7f7f7;">
                        <h6 class="mb-0" style=" color: #000000;">Enquiry Status</h6>
                    </div>
                    <div class="row g-2">
                    @foreach($EnqStatus as $status)
                    <div class="col-lg-2 col-md-6 col-sm-6 mb-3">
                        <div class="card">
                            <div class="card-body py-1 px-1">
                                <div class="d-flex justify-content-between align-items-center" style="position: relative;">
                                    <div class="d-flex align-items-center gap-1">
                                        <div class="card-info">
                                            <h6 class="card-title mb-1" style="font-size: 0.875rem;">{{ $status->status_name }}</h6>
                                            <small class="text-muted" style="font-size: 0.75rem;">{{ $status->status_description }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Edit Icon -->
                                        <a href="#" class="text-primary me-2 edit-status" data-status-id="{{ $status->id }}" title="Edit">
                                            <i class="bx bx-edit" ></i>
                                        </a>
                                        <!-- Delete Icon -->
                                        <a href="#" class="text-danger delete-btn" data-form-action="{{ route('enquiry-status.delete', $status->id) }}" title="Delete">
                                            <i class="bx bx-trash" ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endforeach
                   

                    <!--add new card --->
                    <!-- Add New offcanvas button section -->
                    <div class="col-lg-2 col-md-6 col-sm-6 mb-3">
                        <a href="#" id="openAddStatusBtn">
                        <div class="card text-center hover-effect">
                            <div class="card-body py-1 px-1" >
                                <span class="fs-3 text-primary" style="">
                                    <i class="bx bx-plus" style="font-size: 2rem;"></i>
                                </span>
                            </div>
                        </div></a>
                    </div>
                    <!---end of the card --->
                   </div>

                   <!--this is the view of the Emgs status sections-->
                   <div class=" p-2 mb-3" style="border-left: 4px solid #007bff;background-color: #f7f7f7;">
                    <h6 class="mb-0" style=" color: #000000;">EMGS Status</h6>
                   </div>

                   <div class="row g-2">
                   @foreach($EMGSStatus as $status)
                   <div class="col-lg-2 col-md-6 col-sm-6 mb-3">
                       <div class="card " >
                           <div class="card-body py-1 px-1">
                               <div class="d-flex justify-content-between align-items-center" style="position: relative;">
                                   <div class="d-flex align-items-center gap-1">
                                     
                                       <div class="card-info">
                                           <h6 class="card-title mb-1" style="font-size: 0.875rem;">{{ $status->EMGstatus_name }}</h6>
                                           <small class="text-muted" style="font-size: 0.75rem;">{{ $status->EMGstatus_description }}</small>
                                       </div>
                                   </div>
                                   <div>
                                       <!-- Edit Icon -->
                                       <a href="#" class="text-primary me-2 emg-edit-status" data-status-id="{{ $status->id }}" title="Edit">
                                           <i class="bx bx-edit"></i>
                                       </a>
                                       <!-- Delete Icon -->
                                       <a href="#" class="text-danger emgs-delete-btn" data-form-action="{{ route('emgs-status.delete', $status->id) }}" title="Delete">
                                           <i class="bx bx-trash"></i>
                                       </a>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   @endforeach

                    <!-- Add New offcanvas button section -->
                    <div class="col-lg-2 col-md-6 col-sm-6 mb-3">
                        <a href="#" id="openEmgsStatusBtn">
                        <div class="card text-center hover-effect">
                            <div class="card-body py-1 px-1" >
                                <span class="fs-3 text-primary" style="">
                                    <i class="bx bx-plus" style="font-size: 2rem;"></i>
                                </span>
                            </div>
                        </div></a>
                    </div>
                    <!---end of the card --->
                   </div>

                   <!--this is the view sections for the payment status parts--->

                   <div class=" p-2 mb-3" style="border-left: 4px solid #007bff;background-color: #f7f7f7;">
                    <h6 class="mb-0" style=" color: #000000;">Payment Status</h6>
                   </div>

                   <div class="row g-2">
                        @foreach($PaymentStatus as $status)
                            <div class="col-lg-2 col-md-6 col-sm-6 mb-3">
                                <div class="card">
                                    <div class="card-body py-1 px-1">
                                        <div class="d-flex justify-content-between align-items-center" style="position: relative;">
                                            <div class="d-flex align-items-center gap-1">
                                                <div class="card-info">
                                                    <h6 class="card-title mb-1" style="font-size: 0.875rem;">{{ $status->Paystatus_name }}</h6>
                                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $status->Paystatus_description }}</small>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- Edit Icon -->
                                                <a href="#" class="text-primary me-2 payment-edit-status" data-status-id="{{ $status->id }}" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <!-- Delete Icon -->
                                                <a href="#" class="text-danger payment-delete-btn" data-form-action="{{ route('payment-status.delete', $status->id) }}" title="Delete">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Add New offcanvas button section -->
                        <div class="col-lg-2 col-md-6 col-sm-6 mb-3">
                            <a href="#" id="openPaymentStatusBtn">
                                <div class="card text-center hover-effect">
                                    <div class="card-body py-1 px-1">
                                        <span class="fs-3 text-primary">
                                            <i class="bx bx-plus" style="font-size: 2rem;"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                   </div>

                   <!---this is the view part of the processing status part --->
                    <div class=" p-2 mb-3" style="border-left: 4px solid #007bff;background-color: #f7f7f7;;">
                        <h6 class="mb-0" style=" color: #000000;">Process Status</h6>
                    </div>

                    <div class="row g-2">
                        @foreach($processStatuses as $status)
                        <div class="col-lg-2 col-md-6 col-sm-6 mb-3">
                            <div class="card">
                                <div class="card-body py-1 px-1">
                                    <div class="d-flex justify-content-between" style="position: relative;">
                                        <div class="d-flex align-items-center gap-1">
                                            <div class="card-info">
                                                <h6 class="card-title mb-1" style="font-size: 0.875rem;">{{ $status->Pstatus_name }}</h6>
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ $status->Pstatus_description }}</small>
                                            </div>
                                        </div>
                                        <div>
                                            <!-- Edit Icon -->
                                            <a href="#" class="text-primary me-2 process-edit-status" data-status-id="{{ $status->id }}" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <!-- Delete Icon -->
                                            <a href="#" class="text-danger process-delete-btn" data-form-action="{{ route('process-status.delete', $status->id) }}" title="Delete">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Add New offcanvas button section -->
                        <div class="col-lg-2 col-md-6 col-sm-6 mb-3">
                            <a href="#" id="openProcessStatusBtn">
                                <div class="card text-center hover-effect">
                                    <div class="card-body py-1 px-1">
                                        <span class="fs-3 text-primary">
                                            <i class="bx bx-plus" style="font-size: 2rem;"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
                <!---this is the category tab -->
                <div class="tab-pane fade {{ $activeTab === 3 ? 'show active' : '' }}" id="nav-category" role="tabpanel">
                  <!---this is the content of the tb-->
                  <div class="card m-0 p-0">
                    <div class="card-header d-flex justify-content-between align-items-center" style="padding: 1%;">
                        <!-- Course Category Title -->
                        <h6 class="card-title mb-0" style="font-size: 0.8rem;">Course Category</h6>
                        <!-- Add New Category Button -->
                        <button class="dt-button add-new btn btn-outline-primary btn-sm ms-n1" tabindex="0" aria-controls="DataTables_Table_0" type="button" id="openCourseCategoryBtn">
                            <span><i class="bx bx-plus me-0 me-lg-2"></i><span class="d-none d-lg-inline-block">Add New Category</span></span>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-2 col-0">#</th>
                                    <th class="p-2 col-1">Photo</th>
                                    <th class="p-2 col-2">Category Name</th>
                                    <th class="p-2 col-6">Description</th>
                                    <th class="p-2 col-1">Status</th>
                                    <th class="p-2 col-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courseCategory as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="p-1">
                                        <img src="{{ $row->profile_photo_path ? asset('storage/' . $row->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($row->Category_name) }}" 
                                             alt="{{ $row->Category_name }}" 
                                             class="img-fluid rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td class="p-1">{{ $row->Category_name }}</td>
                                    <td class="p-1">{{ $row->Category_description }}</td>
                                    <td class="p-1">
                                        @if ($row->status == 'Active')
                                            <span class="badge bg-success">{{ $row->status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $row->status }}</span>
                                        @endif
                                    </td>
                                    <td class="p-1 text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <!-- Edit Button -->
                                            <a href="#" class="btn btn-outline-primary  mx-1 course-edit-category" title="Edit" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;" data-category-id="{{$row->id}}">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                            <!-- Delete Button -->
                                            <button class="btn btn-outline-danger  mx-1 course-delete-btn" data-form-action="{{ route('course-category.delete', $row->id) }}" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center" style="padding: 1%;">
                        <!-- Total Records Button Style -->
                        <span class="btn btn-light btn-sm" style="cursor: default;">Total Records: {{ $courseCategory->count() }}</span>
                    </div>
                  </div>
                  <!---End of the tab content --->
                </div>

                <div class="tab-pane fade {{ $activeTab === 4 ? 'show active' : '' }}" id="nav-lead" role="tabpanel">
                    <div class="card m-0 p-0">
                        <div class="card-header d-flex justify-content-between align-items-center" style="padding: 1%;">
                            <!-- Lead Source Title -->
                            <h6 class="card-title mb-0" style="font-size: 0.8rem;">Lead Source</h6>
                            <!-- Add New Source Button -->
                            <button class="dt-button add-new btn btn-outline-primary btn-sm ms-n1" tabindex="0" aria-controls="DataTables_Table_0" type="button" id="openLeadSourceBtn">
                                <span><i class="bx bx-plus me-0 me-lg-2"></i><span class="d-none d-lg-inline-block">Add New Source</span></span>
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="p-2 col-0">#</th>
                                        <th class="p-2 col-2">Source Name</th>
                                        <th class="p-2 col-6">Description</th>
                                        <th class="p-2 col-1">Status</th>
                                        <th class="p-2 col-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leadSources as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="p-1">{{ $row->Source_name }}</td>
                                        <td class="p-1">{{ $row->Source_description }}</td>
                                        <td class="p-1">
                                            @if ($row->status == 'Active')
                                                <span class="badge bg-success">{{ $row->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $row->status }}</span>
                                            @endif
                                        </td>
                                        <td class="p-1 text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <!-- Edit Button -->
                                                <a href="#" class="btn btn-outline-primary mx-1 lead-source-edit" title="Edit" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;" data-source-id="{{ $row->id }}">
                                                    <i class='bx bx-edit'></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <button class="btn btn-outline-danger mx-1 lead-source-delete-btn" data-form-action="{{ route('lead-source.delete', $row->id) }}" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center" style="padding: 1%;">
                            <!-- Total Records Button Style -->
                            <span class="btn btn-light btn-sm" style="cursor: default;">Total Records: {{ $leadSources->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade {{ $activeTab === 5 ? 'show active' : '' }}" id="activity-status" role="tabpanel">
                    <div class="card m-0 p-0">
                        <div class="card-header d-flex justify-content-between align-items-center" style="padding: 1%;">
                            <!-- Activity Status Title -->
                            <h6 class="card-title mb-0" style="font-size: 0.8rem;">Activity Status</h6>
                            <!-- Add New Status Button -->
                            <button class="dt-button add-new btn btn-outline-primary btn-sm ms-n1" tabindex="0" aria-controls="DataTables_Table_0" type="button" id="openActivityStatusBtn">
                                <span><i class="bx bx-plus me-0 me-lg-2"></i><span class="d-none d-lg-inline-block">Add New Status</span></span>
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="p-2 col-0">#</th>
                                        <th class="p-2 col-2">Activity Name</th>
                                        <th class="p-2 col-6">Description</th>
                                        <th class="p-2 col-1">Status</th>
                                        <th class="p-2 col-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activityStatuses as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="p-1">{{ $row->Activity_name }}</td>
                                        <td class="p-1">{{ $row->Activity_description }}</td>
                                        <td class="p-1">
                                            @if ($row->status == 'Active')
                                                <span class="badge bg-success">{{ $row->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $row->status }}</span>
                                            @endif
                                        </td>
                                        <td class="p-1 text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <!-- Edit Button -->
                                                <a href="#" class="btn btn-outline-primary mx-1 activity-edit-status" title="Edit" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;" data-status-id="{{$row->id}}">
                                                    <i class='bx bx-edit'></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <button class="btn btn-outline-danger mx-1 activity-delete-btn" data-form-action="{{ route('activity-status.delete', $row->id) }}" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center" style="padding: 1%;">
                            <!-- Total Records Button Style -->
                            <span class="btn btn-light btn-sm" style="cursor: default;">Total Records: {{ $activityStatuses->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade {{ $activeTab === 6 ? 'show active' : '' }}" id="email-setup" role="tabpanel">
                    <div class="row">
                        <!-- Email Settings Form Card -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <h6 class="card-header bg-secondary text-white">Configure Email</h6>
                                <div class="card-body">
                                    <form id="emailSetup" action="{{ route('email-settings.update') }}" method="POST">
                                        @csrf
                
                                        <!-- SMTP Host -->
                                        <div class="mb-3">
                                            <label for="smtp_host" class="form-label">SMTP Host</label>
                                            <input type="text" class="form-control @error('smtp_host') is-invalid @enderror" id="smtp_host" name="smtp_host" value="{{ old('smtp_host', $emails->smtp_host ?? '') }}" placeholder="e.g., smtp.yourdomain.com">
                                            @error('smtp_host')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                
                                        <!-- SMTP Port -->
                                        <div class="mb-3">
                                            <label for="smtp_port" class="form-label">SMTP Port</label>
                                            <input type="text" class="form-control @error('smtp_port') is-invalid @enderror" id="smtp_port" name="smtp_port" value="{{ old('smtp_port', $emails->smtp_port ?? '') }}" placeholder="e.g., 587">
                                            @error('smtp_port')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                
                                        <!-- SMTP User -->
                                        <div class="mb-3">
                                            <label for="smtp_user" class="form-label">SMTP User</label>
                                            <input type="text" class="form-control @error('smtp_user') is-invalid @enderror" id="smtp_user" name="smtp_user" value="{{ old('smtp_user', $emails->smtp_user ?? '') }}" placeholder="e.g., your.email@yourdomain.com">
                                            @error('smtp_user')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                
                                        <!-- SMTP Password -->
                                        <div class="mb-3">
                                            <label for="smtp_password" class="form-label">SMTP Password</label>
                                            <input type="password" class="form-control @error('smtp_password') is-invalid @enderror" id="smtp_password" name="smtp_password" value="{{ old('smtp_password', $emails->smtp_password ?? '') }}" placeholder="Enter your SMTP password">
                                            @error('smtp_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                
                                        <!-- SMTP Encryption -->
                                        <div class="mb-3">
                                            <label for="smtp_encryption" class="form-label">SMTP Encryption</label>
                                            <input type="text" class="form-control @error('smtp_encryption') is-invalid @enderror" id="smtp_encryption" name="smtp_encryption" value="{{ old('smtp_encryption', $emails->smtp_encryption ?? '') }}" placeholder="e.g., tls">
                                            @error('smtp_encryption')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                
                                        <!-- Sender Name -->
                                        <div class="mb-3">
                                            <label for="sender_name" class="form-label">Sender Name</label>
                                            <input type="text" class="form-control @error('sender_name') is-invalid @enderror" id="sender_name" name="sender_name" value="{{ old('sender_name', $emails->sender_name ?? '') }}" placeholder="e.g., John Doe">
                                            @error('sender_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                
                                        <!-- Sender Email -->
                                        <div class="mb-3">
                                            <label for="sender_email" class="form-label">Sender Email</label>
                                            <input type="email" class="form-control @error('sender_email') is-invalid @enderror" id="sender_email" name="sender_email" value="{{ old('sender_email', $emails->sender_email ?? '') }}" placeholder="e.g., john.doe@yourdomain.com">
                                            @error('sender_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                
                                        

                                        <button type="submit" id="btnEmail" class="btn btn-primary me-sm-3 me-1 data-submit">
        
                                            <span id="loadingSpinnerEmail" class="spinner-border spinner-border-sm d-none" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </span>
                                            <span id="buttonTextEmg">Save Changes</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                
                        <!-- Email Information Card -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Transform Your Email Management</h5>
                                    <p class="card-text">Connect your email inbox and enhance your sales process with the following features:</p>
                                    <table class="table table-borderless table-sm mx-auto">
                                        <tbody>
                                            <tr>
                                                <td class="text-center" style="padding:0 10px;">
                                                    <img src="{{ asset('assets/img/emails/e1.png') }}" height="97" alt="Image 1"><br>
                                                    Access your customer emails with holistic CRM information
                                                </td>
                                                <td class="text-center" style="padding:0 10px;">
                                                    <img src="{{ asset('assets/img/emails/e2.png') }}" height="97" alt="Image 2"><br>
                                                    Send and receive mails from inside CRM records
                                                </td>
                                                <td class="text-center" style="padding:0 10px;">
                                                    <img src="{{ asset('assets/img/emails/e3.png') }}" height="97" alt="Image 3"><br>
                                                    Synchronize your email inbox
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-4 p-3 bg-light text-start">
                                        <strong>Recommended Settings:</strong>
                                        <ul class="list-unstyled mt-2 mb-0">
                                            <li><strong>SMTP Server Address:</strong> smtp.yourdomain.com</li>
                                            <li><strong>SMTP Username:</strong> Your full yourdomain.com email address</li>
                                            <li><strong>SMTP Password:</strong> Your yourdomain.com password</li>
                                            <li><strong>SMTP Port:</strong> 587 (alternatives: 465 and 25)</li>
                                            <li><strong>SMTP TLS/SSL Required:</strong> Yes (No can be used as an alternative)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>




<!-- Offcanvas for enquiry -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addNewStatusOffcanvas" aria-labelledby="addNewStatusOffcanvasLabel">
    <div class="offcanvas-header border-bottom" style="padding: 4%;">
        <h6 class="offcanvas-title " id="status-title">
            Add Enquiry Status  
        </h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="EnqStatusForm" action="{{ route('enquiry-status.save') }}" method="POST">
            @csrf
            <input type="hidden" name="statusId" id="statusId" value="{{ old('statusId') }}">
            <div class="mb-3">
                <label for="statusName" class="form-label">Status Name</label>
                <input type="text" class="form-control @error('statusName') is-invalid @enderror" id="statusName" name="statusName" placeholder="Status Name" required>
                @error('statusName')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="statusDescription" class="form-label">Description</label>
                <input type="text" class="form-control @error('statusDescription') is-invalid @enderror" id="statusDescription" name="statusDescription" placeholder="Short Description"  required>
                @error('statusDescription')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
          
             <!-- Divider -->
             <hr class="my-4">

            <button type="submit" id="btnEnq" class="btn btn-primary me-sm-3 me-1 data-submit">
        
                <span id="loadingSpinnerEnq" class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span id="buttonText">Submit</span>
            </button>
            
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
<!--end of the enquiry offcanvas-->

<!--delete modal for enq status--->
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
        <form id="DelEnqStatusForm" method="POST" action="">
            @csrf
            
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            {{-- <button type="submit" class="btn btn-danger">Delete</button> --}}
            <button type="submit" id="btnDelEnq" class="btn btn-danger me-sm-3 me-1">
        
            <span id="loadingSpinnerDelEnq" class="spinner-border spinner-border-sm d-none" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            <span id="buttonTextdelEnq">Delete</span>
            </button>
        </form>
        </div>
    </div>
    </div>
</div>
<!---end of the enq delete modal -->

<!--this is offcanavas for the emgs status-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addNewEMGStatusOffcanvas" aria-labelledby="addNewEMGStatusOffcanvasLabel">
    <div class="offcanvas-header border-bottom" style="padding: 4%;">
        <h6 class="offcanvas-title " id="emgs-status-title">
            EMGS Status  
        </h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="EmgsStatusForm" action="{{ route('emgs-status.save') }}" method="POST">
            @csrf
            <input type="hidden" name="statusEMGId" id="statusEMGId" value="{{ old('statusEMGId') }}">
            <div class="mb-3">
                <label for="EMGSstatusName" class="form-label">Status Name</label>
                <input type="text" class="form-control @error('EMGSstatusName') is-invalid @enderror" id="EMGSstatusName" name="EMGSstatusName" placeholder="Status Name" >
                @error('EMGSstatusName')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="EMGSstatusDescription" class="form-label">Description</label>
                <input type="text" class="form-control @error('EMGSstatusDescription') is-invalid @enderror" id="EMGSstatusDescription" name="EMGSstatusDescription" placeholder="Short Description"  >
                @error('EMGSstatusDescription')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
          
             <!-- Divider -->
             <hr class="my-4">

            <button type="submit" id="btnEmg" class="btn btn-primary me-sm-3 me-1 data-submit">
        
                <span id="loadingSpinnerEmg" class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span id="buttonTextEmg">Submit</span>
            </button>
            
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
<!---end of the offcanvas for the emgs status-->

<!--delete modal for emgs status--->
<div class="modal fade" id="deleteConfirmationModal1" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
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
        <form id="DelEmgStatusForm" method="POST" action="">
            @csrf
            
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            {{-- <button type="submit" class="btn btn-danger">Delete</button> --}}
            <button type="submit" id="btnDelEmg" class="btn btn-danger me-sm-3 me-1">
        
            <span id="loadingSpinnerDelEmg" class="spinner-border spinner-border-sm d-none" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            <span id="buttonTextdelEmg">Delete</span>
            </button>
        </form>
        </div>
    </div>
    </div>
</div>
<!---end of the enq delete modal -->

<!-- Offcanvas Form for PaymentStatus -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addNewPaymentStatusOffcanvas" aria-labelledby="addNewPaymentStatusOffcanvasLabel">
    <div class="offcanvas-header border-bottom" style="padding: 4%;">
        <h6 class="offcanvas-title" id="payment-status-title">
            Payment Status
        </h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form id="PaymentStatusForm" action="{{ route('payment-status.save') }}" method="POST">
            @csrf
            <input type="hidden" name="statusPayId" id="statusPayId" value="{{ old('statusPayId') }}">
            <div class="mb-3">
                <label for="PaystatusName" class="form-label">Status Name</label>
                <input type="text" class="form-control @error('PaystatusName') is-invalid @enderror" id="PaystatusName" name="PaystatusName" placeholder="Status Name">
                @error('PaystatusName')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="PaystatusDescription" class="form-label">Description</label>
                <input type="text" class="form-control @error('PaystatusDescription') is-invalid @enderror" id="PaystatusDescription" name="PaystatusDescription" placeholder="Short Description">
                @error('PaystatusDescription')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Divider -->
            <hr class="my-4">

            <button type="submit" id="btnPay" class="btn btn-primary me-sm-3 me-1 data-submit">
                <span id="loadingSpinnerPay" class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span id="buttonTextPay">Submit</span>
            </button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
<!-- Delete modal for PaymentStatus -->
<div class="modal fade" id="deleteConfirmationModalPaymentStatus" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: 1.25rem;">
                Are you sure you want to delete this payment status? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <form id="DelPaymentStatusForm" method="POST" action="">
                    @csrf
                   
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnDelPay" class="btn btn-danger me-sm-3 me-1">
                        <span id="loadingSpinnerDelPay" class="spinner-border spinner-border-sm d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span id="buttonTextDelPay">Delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of PaymentStatus delete modal -->

<!--this is offcanvas for the process status-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addNewProcessStatusOffcanvas" aria-labelledby="addNewProcessStatusOffcanvasLabel">
    <div class="offcanvas-header border-bottom" style="padding: 4%;">
        <h6 class="offcanvas-title" id="process-status-title">
            Process Status
        </h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="ProcessStatusForm" action="{{ route('process-status.save') }}" method="POST">
            @csrf
            <input type="hidden" name="statusProcessId" id="statusProcessId" value="{{ old('statusProcessId') }}">
            <div class="mb-3">
                <label for="ProcessStatusName" class="form-label">Status Name</label>
                <input type="text" class="form-control @error('ProcessStatusName') is-invalid @enderror" id="ProcessStatusName" name="ProcessStatusName" placeholder="Status Name">
                @error('ProcessStatusName')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ProcessStatusDescription" class="form-label">Description</label>
                <input type="text" class="form-control @error('ProcessStatusDescription') is-invalid @enderror" id="ProcessStatusDescription" name="ProcessStatusDescription" placeholder="Short Description">
                @error('ProcessStatusDescription')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Divider -->
            <hr class="my-4">

            <button type="submit" id="btnProcess" class="btn btn-primary me-sm-3 me-1 data-submit">
                <span id="loadingSpinnerProcess" class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span id="buttonTextProcess">Submit</span>
            </button>

            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
<!---end of the offcanvas for the process status-->

<!--delete modal for process status-->
<div class="modal fade" id="deleteConfirmationModalProcess" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: 1.25rem;">
                Are you sure you want to delete this status? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <form id="DelProcessStatusForm" method="POST" action="">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnDelProcess" class="btn btn-danger me-sm-3 me-1">
                        <span id="loadingSpinnerDelProcess" class="spinner-border spinner-border-sm d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span id="buttonTextDelProcess">Delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!---end of the delete modal -->

<!-- offcanvas for the modal of the insert for the course category --->

<!-- Offcanvas for the Course Category -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addNewCourseCategoryOffcanvas" aria-labelledby="addNewCourseCategoryOffcanvasLabel">
    <div class="offcanvas-header border-bottom" style="padding: 4%;">
        <h6 class="offcanvas-title" id="course-category-title">
            Course Category
        </h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form class="add-new-course-category pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="CourseCategoryForm" action="{{ route('course-category.save') }}"  method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="categoryId" id="categoryId" value="{{ old('categoryId') }}">
            <div class="mb-3">
                <label for="CategoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control @error('CategoryName') is-invalid @enderror" id="CategoryName" name="CategoryName" placeholder="Category Name">
                @error('CategoryName')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="CategoryDescription" class="form-label">Description</label>
                <input type="text" class="form-control @error('CategoryDescription') is-invalid @enderror" id="CategoryDescription" name="CategoryDescription" placeholder="Short Description">
                @error('CategoryDescription')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="CategoryStatus" class="form-label">Status</label>
                <select class="form-select @error('CategoryStatus') is-invalid @enderror" id="CategoryStatus" name="CategoryStatus">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                @error('CategoryStatus')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="profilePhoto" class="form-label">Profile Photo</label>
                <input type="file" class="form-control @error('profilePhoto') is-invalid @enderror" id="profilePhoto" name="profilePhoto">
                @error('profilePhoto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="photoPreview" class="mt-2">
                    <img id="categoryPhotoPreview" src="" alt="Profile Photo Preview" style="max-width: 100px; display: none;">
                </div>
            </div>

            <!-- Divider -->
            <hr class="my-4">

            <button type="submit" id="btnCategory" class="btn btn-primary me-sm-3 me-1 data-submit">
                <span id="loadingSpinnerCategory" class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span id="buttonTextCategory">Submit</span>
            </button>

            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
<!-- End of offcanvas for Course Category -->

<!-- end of the modal course category --->
<!-- Delete modal for Course Category -->
<div class="modal fade" id="deleteConfirmationModalCategory" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: 1.25rem;">
                Are you sure you want to delete this category? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <form id="DelCategoryForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnDelCategory" class="btn btn-danger me-sm-3 me-1">
                        <span id="loadingSpinnerDelCategory" class="spinner-border spinner-border-sm d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span id="buttonTextDelCategory">Delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of delete modal -->

<!-- Offcanvas for Adding/Editing Lead Source -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addNewLeadSourceOffcanvas" aria-labelledby="addNewLeadSourceOffcanvasLabel">
    <div class="offcanvas-header border-bottom" style="padding: 4%;">
        <h6 class="offcanvas-title" id="lead-source-title">Add Lead Source</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form id="LeadSourceForm" method="POST" action="{{ route('lead-source.save') }}">
            @csrf
            <input type="hidden" name="sourceId" id="sourceId" value="">
            <div class="mb-3">
                <label for="SourceName" class="form-label">Source Name</label>
                <input type="text" class="form-control @error('SourceName') is-invalid @enderror" id="SourceName" name="SourceName" value="{{ old('SourceName') }}" placeholder="Source Name" required>
                @error('SourceName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="SourceDescription" class="form-label">Description</label>
                <textarea class="form-control @error('SourceDescription') is-invalid @enderror" id="SourceDescription" placeholder="Source Descriptions" name="SourceDescription" rows="3">{{ old('SourceDescription') }}</textarea>
                @error('SourceDescription')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="SourceStatus" class="form-label">Status</label>
                <select class="form-select @error('SourceStatus') is-invalid @enderror" id="SourceStatus" name="SourceStatus" required>
                    <option value="Active" {{ old('SourceStatus') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('SourceStatus') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('SourceStatus')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Divider -->
            <hr class="my-4">

            <button type="submit" id="btnSource" class="btn btn-primary me-sm-3 me-1">
                <span id="buttonTextSource">Submit</span>
                <span id="loadingSpinnerSource" class="spinner-border spinner-border-sm d-none" role="status"><span class="visually-hidden">Loading...</span></span>
            </button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModalSource" tabindex="-1" aria-labelledby="deleteConfirmationModalSourceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalSourceLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this lead source?
            </div>
            <div class="modal-footer">
                <form id="DelSourceForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnDelSource" class="btn btn-danger">
                        <span id="buttonTextDelSource">Delete</span>
                        <span id="loadingSpinnerDelSource" class="spinner-border spinner-border-sm d-none" role="status"><span class="visually-hidden">Loading...</span></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Offcanvas for Add/Edit Activity Status -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addNewActivityStatusOffcanvas" aria-labelledby="addNewActivityStatusOffcanvasLabel">
    <div class="offcanvas-header border-bottom" style="padding: 4%;">
        <h6 class="offcanvas-title" id="activity-status-title">Add Activity Status</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="ActivityStatusForm" action="{{ route('activity-status.save') }}" method="POST">
            @csrf
            <input type="hidden" name="ActivitystatusId" id="ActivitystatusId" value="{{ old('ActivitystatusId') }}">
            <div class="mb-3">
                <label for="ActivityName" class="form-label">Activity Name</label>
                <input type="text" class="form-control" id="ActivityName" name="ActivityName" required placeholder="Activity Name" value="{{ old('ActivityName') }}">
                @error('ActivityName')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ActivityDescription" class="form-label">Description</label>
                <textarea class="form-control" id="ActivityDescription" name="ActivityDescription" placeholder="Activity Description">{{ old('ActivityDescription') }}</textarea>
                @error('ActivityDescription')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ActivityStatus" class="form-label">Status</label>
                <select class="form-select" id="ActivityStatus" name="ActivityStatus" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                @error('ActivityStatus')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
             <!-- Divider -->
             <hr class="my-4">

             <button type="submit" id="btnActivityStatus" class="btn btn-primary me-sm-3 me-1">
                 <span id="buttonTextActivityStatus">Submit</span>
                 <span id="loadingSpinnerActivityStatus" class="spinner-border spinner-border-sm d-none" role="status"><span class="visually-hidden">Loading...</span></span>
             </button>
             <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>

<!-- Modal for Confirm Delete -->
<div class="modal fade" id="DelActivityStatusForm" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this activity status?
            </div>
            <div class="modal-footer">
                <form id="DelStatusForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnDelActivityStatus" class="btn btn-danger">
                        <span id="buttonTextDelActivityStatus">Delete</span>
                        <span id="loadingSpinnerDelActivityStatus" class="spinner-border spinner-border-sm d-none" role="status"><span class="visually-hidden">Loading...</span></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('small_logo').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('small_logo_preview').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    document.getElementById('wide_logo').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('wide_logo_preview').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    document.getElementById('favicon').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('favicon_preview').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
<!--validation error handeling --->
@if ($errors->has('CategoryName') || $errors->has('CategoryDescription') || $errors->has('CategoryStatus') || $errors->has('profilePhoto'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewCourseCategoryOffcanvas'));
            offcanvas.show();
        });
    </script>
@endif
<!---validation error handeling--->

<!-- Validation error handling -->
@if ($errors->has('SourceDescription') || $errors->has('SourceDescription') || $errors->has('SourceStatus'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var offcanvasElement = document.getElementById('addNewLeadSourceOffcanvas');
            if (offcanvasElement) {
                var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                offcanvas.show();
            }
        });
    </script>
@endif

<!-- Validation error handling -->
@if ($errors->has('ActivityName') || $errors->has('ActivityDescription') || $errors->has('ActivityStatus'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var offcanvasElement = document.getElementById('addNewActivityStatusOffcanvas');
            if (offcanvasElement) {
                var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                offcanvas.show();
            }
        });
    </script>
@endif


<script>
     //button submitting 
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('LinksForm', 'btnLink', 'buttonTextLink', 'loadingSpinnerLink');
        // Add more instances as needed
        // new FormSubmitHandler('anotherFormId', 'anotherButtonId', 'anotherButtonTextId', 'anotherSpinnerId');
    });
      //button submitting 
   document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('LogoForm', 'btnLogo', 'buttonTextLogo', 'loadingSpinnerLogo');
        // Add more instances as needed
        // new FormSubmitHandler('anotherFormId', 'anotherButtonId', 'anotherButtonTextId', 'anotherSpinnerId');
    });

      //button submitting 
   document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('infoForm', 'btnInfo', 'buttonTextInfo', 'loadingSpinnerInfo');
        // Add more instances as needed
        // new FormSubmitHandler('anotherFormId', 'anotherButtonId', 'anotherButtonTextId', 'anotherSpinnerId');
    });

   //button submitting for enq status

    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('EnqStatusForm', 'btnEnq', 'buttonText', 'loadingSpinnerEnq');
        // Add more instances as needed
        // new FormSubmitHandler('anotherFormId', 'anotherButtonId', 'anotherButtonTextId', 'anotherSpinnerId');
    });
    //delete button submittings
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('DelEnqStatusForm', 'btnDelEnq', 'buttonTextdelEnq', 'loadingSpinnerDelEnq');
        // Add more instances as needed
        // new FormSubmitHandler('anotherFormId', 'anotherButtonId', 'anotherButtonTextId', 'anotherSpinnerId');
    });

     //button submitting for emgs status
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('EmgsStatusForm', 'btnEmg', 'buttonTextEmg', 'loadingSpinnerEmg');
        new FormSubmitHandler('DelEmgStatusForm', 'btnDelEmg', 'buttonTextdelEmg', 'loadingSpinnerDelEmg');
        // Add more instances as needed
        // new FormSubmitHandler('anotherFormId', 'anotherButtonId', 'anotherButtonTextId', 'anotherSpinnerId');
    });

    // Button submitting for PaymentStatus form
    document.addEventListener('DOMContentLoaded', function() {
        // Form handler for adding/updating PaymentStatus
        new FormSubmitHandler('PaymentStatusForm', 'btnPay', 'buttonTextPay', 'loadingSpinnerPay');
        
        // Form handler for deleting PaymentStatus
        new FormSubmitHandler('DelPaymentStatusForm', 'btnDelPay', 'buttonTextDelPay', 'loadingSpinnerDelPay');
    });

    // Button submitting for process status
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('ProcessStatusForm', 'btnProcess', 'buttonTextProcess', 'loadingSpinnerProcess');
        new FormSubmitHandler('DelProcessStatusForm', 'btnDelProcess', 'buttonTextDelProcess', 'loadingSpinnerDelProcess');
    });


    // Button submitting for course category
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('CourseCategoryForm', 'btnCategory', 'buttonTextCategory', 'loadingSpinnerCategory');
        new FormSubmitHandler('DelCategoryForm', 'btnDelCategory', 'buttonTextDelCategory', 'loadingSpinnerDelCategory');
    });

    //Button submitting for lead 
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('LeadSourceForm', 'btnSource', 'buttonTextSource', 'loadingSpinnerSource');
        new FormSubmitHandler('DelSourceForm', 'btnDelSource', 'buttonTextDelSource', 'loadingSpinnerDelSource');
    });

    // Initialize FormSubmitHandler for Activity Status forms
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('ActivityStatusForm', 'btnActivityStatus', 'buttonTextActivityStatus', 'loadingSpinnerActivityStatus');
        new FormSubmitHandler('DelActivityStatusForm', 'btnDelActivityStatus', 'buttonTextDelActivityStatus', 'loadingSpinnerDelActivityStatus');

        //for email submit form 
        new FormSubmitHandler('emailSetup', 'btnEmail', 'buttonTextEmg', 'loadingSpinnerEmail');
    });

</script>




<script>
    //fetch data and show into the form
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-status').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                
                var statusId = this.getAttribute('data-status-id');
                var url = '/enquiry-status/' + statusId;

                // Fetch the data using AJAX
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Set the values in the form
                        document.getElementById('statusId').value = data.id;
                        document.getElementById('statusName').value = data.status_name;
                        document.getElementById('statusDescription').value = data.status_description;
                        document.getElementById('status-title').textContent = 'Update Enquiry Status';
                        document.getElementById('buttonText').textContent = 'Update';

                        // Open the offcanvas
                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewStatusOffcanvas'));
                        offcanvas.show();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });
    //open modal and set valu empty
    document.getElementById('openAddStatusBtn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default anchor behavior

        // Reset the input fields
        document.getElementById('statusId').value = '';
        document.getElementById('statusName').value = '';
        document.getElementById('statusDescription').value = '';

        // Update the title of the offcanvas
        document.getElementById('status-title').textContent = 'Add Enquiry Status';
        document.getElementById('buttonText').textContent = 'Submit';
        // Open the offcanvas
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewStatusOffcanvas'));
        offcanvas.show();
    });

    //delete 
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            
            const formAction = this.getAttribute('data-form-action');
            
            const deleteForm = document.getElementById('DelEnqStatusForm');
            deleteForm.setAttribute('action', formAction);
            
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        });
        });
    });

    //open modal for the emgs 
    document.getElementById('openEmgsStatusBtn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default anchor behavior

        // Reset the input fields
        document.getElementById('statusEMGId').value = '';
        document.getElementById('EMGSstatusName').value = '';
        document.getElementById('EMGSstatusDescription').value = '';

        // Update the title of the offcanvas
        document.getElementById('emgs-status-title').textContent = 'Add EMGS Status';
        document.getElementById('buttonTextEmg').textContent = 'Submit';
        // Open the offcanvas
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewEMGStatusOffcanvas'));
        offcanvas.show();
    });

     //fetch data and show into the form
     document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.emg-edit-status').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                
                var statusId = this.getAttribute('data-status-id');
                var url = '/emgs-status/' + statusId;

                // Fetch the data using AJAX
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Set the values in the form
                        document.getElementById('statusEMGId').value = data.id;
                        document.getElementById('EMGSstatusName').value = data.EMGstatus_name;
                        document.getElementById('EMGSstatusDescription').value = data.EMGstatus_description;
                        document.getElementById('emgs-status-title').textContent = 'Update EMGS Status';
                        document.getElementById('buttonTextEmg').textContent = 'Update';

                        // Open the offcanvas
                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewEMGStatusOffcanvas'));
                        offcanvas.show();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });

    //delete EMgs
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.emgs-delete-btn');
        
        deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            
            const formAction = this.getAttribute('data-form-action');
            
            const deleteForm = document.getElementById('DelEmgStatusForm');
            deleteForm.setAttribute('action', formAction);
            
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal1'));
            deleteConfirmationModal.show();
        });
        });
    });

    // Open Modal for Payment Status
    document.getElementById('openPaymentStatusBtn').addEventListener('click', function(event) {
        event.preventDefault(); 

        // Reset the input fields
        document.getElementById('statusPayId').value = '';
        document.getElementById('PaystatusName').value = '';
        document.getElementById('PaystatusDescription').value = '';

        // Update the title of the offcanvas
        document.getElementById('payment-status-title').textContent = 'Add Payment Status';
        document.getElementById('buttonTextPay').textContent = 'Submit';
        
        // Open the offcanvas
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewPaymentStatusOffcanvas'));
        offcanvas.show();
    });

    // Fetch Data and Show into the Form
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.payment-edit-status').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                
                var statusId = this.getAttribute('data-status-id');
                var url = '/payment-status/' + statusId;

                // Fetch the data using AJAX
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Set the values in the form
                        document.getElementById('statusPayId').value = data.id;
                        document.getElementById('PaystatusName').value = data.Paystatus_name;
                        document.getElementById('PaystatusDescription').value = data.Paystatus_description;
                        document.getElementById('payment-status-title').textContent = 'Update Payment Status';
                        document.getElementById('buttonTextPay').textContent = 'Update';

                        // Open the offcanvas
                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewPaymentStatusOffcanvas'));
                        offcanvas.show();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });

    // Delete Payment Status
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.payment-delete-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                
                const formAction = this.getAttribute('data-form-action');
                
                const deleteForm = document.getElementById('DelPaymentStatusForm');
                deleteForm.setAttribute('action', formAction);
                
                const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModalPaymentStatus'));
                deleteConfirmationModal.show();
            });
        });
    });

    // Open modal for the process
    document.getElementById('openProcessStatusBtn').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('statusProcessId').value = '';
        document.getElementById('ProcessStatusName').value = '';
        document.getElementById('ProcessStatusDescription').value = '';
        document.getElementById('process-status-title').textContent = 'Add Process Status';
        document.getElementById('buttonTextProcess').textContent = 'Submit';
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewProcessStatusOffcanvas'));
        offcanvas.show();
    });

    // Fetch data and show into the form
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.process-edit-status').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var statusId = this.getAttribute('data-status-id');
                var url = '/process-status/' + statusId;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('statusProcessId').value = data.id;
                        document.getElementById('ProcessStatusName').value = data.Pstatus_name;
                        document.getElementById('ProcessStatusDescription').value = data.Pstatus_description;
                        document.getElementById('process-status-title').textContent = 'Update Process Status';
                        document.getElementById('buttonTextProcess').textContent = 'Update';
                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewProcessStatusOffcanvas'));
                        offcanvas.show();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });

    // Delete process status
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.process-delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const formAction = this.getAttribute('data-form-action');
                const deleteForm = document.getElementById('DelProcessStatusForm');
                deleteForm.setAttribute('action', formAction);
                const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModalProcess'));
                deleteConfirmationModal.show();
            });
        });
    });

    // scripts for the course category 
    // Open modal for the course category
    document.getElementById('openCourseCategoryBtn').addEventListener('click', function(event) {
        event.preventDefault();
        
        // Clear the form inputs
        document.getElementById('categoryId').value = '';
        document.getElementById('CategoryName').value = '';
        document.getElementById('CategoryDescription').value = '';
        document.getElementById('CategoryStatus').value = 'Active';
        
        // Reset the profile photo input and preview
        document.getElementById('profilePhoto').value = '';
        document.getElementById('categoryPhotoPreview').src = '';
        document.getElementById('categoryPhotoPreview').style.display = 'none';
        
        // Update modal title and button text
        document.getElementById('course-category-title').textContent = 'Add Course Category';
        document.getElementById('buttonTextCategory').textContent = 'Submit';
        
        // Show the offcanvas
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewCourseCategoryOffcanvas'));
        offcanvas.show();
    });

    // Preview uploaded photo
    document.getElementById('profilePhoto').addEventListener('change', function(event) {
        const input = event.target;
        const preview = document.getElementById('categoryPhotoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    });

    // Fetch data and show into the form, including profile photo
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.course-edit-category').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var categoryId = this.getAttribute('data-category-id');
                var url = '/course-category/' + categoryId;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('categoryId').value = data.id;
                        document.getElementById('CategoryName').value = data.Category_name;
                        document.getElementById('CategoryDescription').value = data.Category_description;
                        document.getElementById('CategoryStatus').value = data.status;

                        if (data.profile_photo_path) {
                            document.getElementById('categoryPhotoPreview').src = '/storage/' + data.profile_photo_path;
                            document.getElementById('categoryPhotoPreview').style.display = 'block';
                        } else {
                            document.getElementById('categoryPhotoPreview').style.display = 'none';
                        }

                        document.getElementById('course-category-title').textContent = 'Update Course Category';
                        document.getElementById('buttonTextCategory').textContent = 'Update';
                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewCourseCategoryOffcanvas'));
                        offcanvas.show();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });

    // Delete course category
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.course-delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const formAction = this.getAttribute('data-form-action');
                const deleteForm = document.getElementById('DelCategoryForm');
                deleteForm.setAttribute('action', formAction);
                const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModalCategory'));
                deleteConfirmationModal.show();
            });
        });
    });

    //this is the code of the lead source sections

    // Open modal for the lead source
    document.getElementById('openLeadSourceBtn').addEventListener('click', function(event) {
        event.preventDefault();
        
        // Clear the form inputs
        document.getElementById('sourceId').value = '';
        document.getElementById('SourceName').value = '';
        document.getElementById('SourceDescription').value = '';
        document.getElementById('SourceStatus').value = 'Active';
        
        // Update modal title and button text
        document.getElementById('lead-source-title').textContent = 'Add Lead Source';
        document.getElementById('buttonTextSource').textContent = 'Submit';
        
        // Show the offcanvas
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewLeadSourceOffcanvas'));
        offcanvas.show();
    });

    // Fetch data and show into the form
    
    document.querySelectorAll('.lead-source-edit').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var sourceId = this.getAttribute('data-source-id');
            var url = '/lead-source/' + sourceId;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('sourceId').value = data.id;
                    document.getElementById('SourceName').value = data.Source_name;
                    document.getElementById('SourceDescription').value = data.Source_description;
                    document.getElementById('SourceStatus').value = data.status;

                    document.getElementById('lead-source-title').textContent = 'Update Lead Source';
                    document.getElementById('buttonTextSource').textContent = 'Update';
                    var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewLeadSourceOffcanvas'));
                    offcanvas.show();
                })
                .catch(error => console.error('Error:', error));
        });
    });
   


    // Delete lead source
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.lead-source-delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const formAction = this.getAttribute('data-form-action');
                const deleteForm = document.getElementById('DelSourceForm');
                deleteForm.setAttribute('action', formAction);
                const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModalSource'));
                deleteConfirmationModal.show();
            });
        });
    });

    // Open modal for activity status
    document.getElementById('openActivityStatusBtn').addEventListener('click', function(event) {
        event.preventDefault();
        
        // Clear the form inputs
        document.getElementById('ActivitystatusId').value = '';
        document.getElementById('ActivityName').value = '';
        document.getElementById('ActivityDescription').value = '';
        document.getElementById('ActivityStatus').value = 'Active';
        
        // Update modal title and button text
        document.getElementById('activity-status-title').textContent = 'Add Activity Status';
        document.getElementById('buttonTextActivityStatus').textContent = 'Submit';
        
        // Show the offcanvas
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewActivityStatusOffcanvas'));
        offcanvas.show();
    });

    // Fetch data and show into the form
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.activity-edit-status').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var statusId = this.getAttribute('data-status-id');
                var url = '/activity-status/' + statusId;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('ActivitystatusId').value = data.id;
                        document.getElementById('ActivityName').value = data.Activity_name;
                        document.getElementById('ActivityDescription').value = data.Activity_description;
                        document.getElementById('ActivityStatus').value = data.status;
                        
                        document.getElementById('activity-status-title').textContent = 'Update Activity Status';
                        document.getElementById('buttonTextActivityStatus').textContent = 'Update';
                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('addNewActivityStatusOffcanvas'));
                        offcanvas.show();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });

    // Delete activity status
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.activity-delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const formAction = this.getAttribute('data-form-action');
                document.getElementById('DelStatusForm').setAttribute('action', formAction);
                var myModal = new bootstrap.Modal(document.getElementById('DelActivityStatusForm'));
                myModal.show();
            });
        });
    });


</script>



@endsection
