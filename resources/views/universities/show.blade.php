@extends('layouts/layoutMaster')

@section('title', 'University Profile')

@section('content')
<style>
    /* Custom styles to reduce padding and margins */
    .tab-content {
        padding: 0 !important;
    }

    .tab-pane {
        padding: 0 !important;
        margin: 0 !important;
    }

    .card {
        margin-bottom: 1rem; /* Adjust spacing between cards */
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <!-- Banner Section -->
            <div class="user-profile-header-banner">
                @if($university->banner)
                <img src="{{ asset('storage/' . $university->banner) }}" alt="Banner image" class="img-fluid w-100 rounded-top" style="height: 250px; object-fit: cover;">
                @else
                <img src="{{'https://ui-avatars.com/api/?name=' . urlencode($university->name) }}" alt="Banner image" class="img-fluid w-100 rounded-top" style="height: 250px; object-fit: cover;">
                @endif
            </div>

            <!-- Profile Section -->
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <!-- Logo Section -->
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    @if($university->logo)
                    <img src="{{ asset('storage/' . $university->logo) }}" alt="University logo" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                    <img src="{{'https://ui-avatars.com/api/?name=' . urlencode($university->acronym) }}" alt="University logo" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                    @endif
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4>{{ $university->name }}</h4>
                            <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item fw-medium"><i class="bx bx-envelope"></i> {{ $university->email }}</li>
                                <li class="list-inline-item fw-medium"><i class="bx bx-phone"></i>{{ $university->country_code }} {{ $university->phone }}</li>
                                <li class="list-inline-item fw-medium"><i class="bx bx-map"></i> {{ $university->country }} , {{ $university->city }}</li>
                            </ul>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm text-nowrap">
                            <i class="bx bx-user-check me-1"></i>Connected
                        </a>
                        <a href="javascript:history.back()" class="btn btn-secondary btn-sm text-nowrap">
                            <i class="bx bx-arrow-back me-1"></i>Back
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Section -->
<ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses" type="button" role="tab" aria-controls="courses" aria-selected="false">Courses</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
    </li>
  </ul>
  
  <!-- Tab Content -->
  <div class="tab-content" id="profileTabsContent">
    <!-- Overview Tab with General University Details -->
    <!-- Overview Tab with Comprehensive University Details -->
    <div class="tab-pane fade show active " id="overview" role="tabpanel" aria-labelledby="overview-tab">
        <div class="row g-1">
            <!-- General Information -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 mb-2">
                    <div class="card-header p-0">
                        <h6 class="mb-0">General Information</h6>
                        <hr>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-building-house fs-4 me-2"></i>
                                <div>
                                    <strong>University Name:</strong>
                                    <span class="ms-2">{{ $university->name }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-globe fs-4 me-2"></i>
                                <div>
                                    <strong>country:</strong>
                                    <span class="ms-2">{{ $university->founded_year }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-map fs-4 me-2"></i>
                                <div>
                                    <strong>Location:</strong>
                                    <span class="ms-2">{{ $university->location }}</span>
                                </div>
                            </li>
                            
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-envelope fs-4 me-2"></i>
                                <div>
                                    <strong>Email:</strong>
                                    <a href="mailto:{{ $university->email }}" class="ms-2 text-decoration-none">{{ $university->email }}</a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-phone fs-4 me-2"></i>
                                <div>
                                    <strong>Phone:</strong>
                                    <a href="tel:{{ $university->phone }}" class="ms-2 text-decoration-none">{{ $university->phone }}</a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-globe fs-4 me-2"></i>
                                <div>
                                    <strong>Website:</strong>
                                    <a href="{{ $university->website }}" target="_blank" class="ms-2 text-decoration-none">{{ $university->website }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    
            <!-- About the University -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 mb-2">
                    <div class="card-header  m-0">
                        <h6 class="mb-0">About the University</h6>
                        <hr>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $university->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row g-1">
            <!-- Mission -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Mission</h6>
                        <hr>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $university->mission }}</p>
                    </div>
                </div>
            </div>
    
            <!-- Vision -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Vision</h6>
                        <hr>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $university->vision }}</p>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row g-1">
            <!-- Additional Details -->
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-3 ">
                    <div class="card-header ">
                        <h6 class="mb-0">Additional Details</h6>
                        <hr>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-award fs-4 me-2"></i>
                                <div>
                                    <strong>Accreditation :</strong>
                                    <span class="ms-2">{{ $university->accreditation }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-group fs-4 me-2"></i>
                                <div>
                                    <strong>Number of Students :</strong>
                                    <span class="ms-2">{{ $university->student_count }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-building-house fs-4 me-2"></i>
                                <div>
                                    <strong>Campus Size :</strong>
                                    <span class="ms-2">{{ $university->campus_size }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-archive fs-4 me-2"></i>
                                <div>
                                    <strong>Departments :</strong>
                                    <span class="ms-2">{{ $university->departments }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

    <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab">
      <p>Courses content goes here...</p>
    </div>
    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
      <p>Reviews content goes here...</p>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
      <p>Contact information goes here...</p>
    </div>
  </div>

@endsection

@section('scripts')
@endsection
