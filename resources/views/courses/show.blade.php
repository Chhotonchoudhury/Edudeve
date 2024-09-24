@extends('layouts/layoutMaster')

@section('title', 'Course Profile')

@section('content')
@php
    use Carbon\Carbon;
@endphp

@if(session('active_tab'))
    @php $activeTab = session('active_tab'); @endphp
@else
    @php $activeTab = 1; @endphp
@endif

<!-- Main Wrapper -->
<div class="wrapper">
    <div class="container-fluid p-0 mt-0">
        <div class="main-content">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center ">
                    <!-- Course Title with Modern Typography -->
                    <h1 class="h4 fw-bold text-primary">Course: {{ $course->title }}</h1>
                    <div>
                        <!-- Advanced Button with Hover Effect -->
                        <button class="btn btn-outline-primary btn-sm px-4 edit-stu" data-status-id="{{ $course->id }}">
                            <i class="fa fa-pencil-alt me-1"></i> Edit Info
                        </button>
                    </div>
                </div>

                <!-- Card with Soft Shadow for Course Details -->
                <div class="card border-0 shadow-sm rounded-lg p-1">
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs custom-tabs" id="studentTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center {{ $activeTab === 1 ? 'active' : '' }}" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">
                                    <i class="fa fa-info-circle me-2"></i> Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center {{ $activeTab === 2 ? 'active' : '' }}" id="requirement-tab" data-bs-toggle="tab" href="#requirement" role="tab" aria-controls="requirement" aria-selected="false">
                                    <i class="fa fa-list-ul me-2"></i> Requirements
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="studentTabContent">
                            <!-- Details Tab -->
                            <div class="tab-pane fade {{ $activeTab === 1 ? 'show active' : '' }} mb-0" id="details" role="tabpanel" aria-labelledby="details-tab">
                                       <!-- Course Title and Key Information -->
                                <!-- Full-width Course Thumbnail Cover -->
                                <div class="course-cover position-relative mb-4">
                                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://ui-avatars.com/api/?name=' . urlencode($course->title) }}" alt="Course Thumbnail" class="img-fluid w-100 rounded" style="object-fit: cover; height: 250px;">
                                </div>

                                <!-- Course Title and Info -->
                                <div class="row mb-5">
                                    <div class="col-md-12 text-center">
                                        <h4 class="fw-bold mb-4">{{ $course->title }}</h4>
                                        <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 text-muted">

                                            <!-- Course Duration -->
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-clock text-primary me-2"></i>
                                                <span><strong>Duration:</strong> {{ $course->duration_value }} {{ $course->duration_type }}</span>
                                            </div>

                                            <!-- Course Category -->
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-tag text-primary me-2"></i>
                                                <span><strong>Category:</strong> {{ $course->category->Category_name }}</span>
                                            </div>

                                            <!-- Course Language -->
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-language text-primary me-2"></i>
                                                <span><strong>Language:</strong> {{ $course->language }}</span>
                                            </div>

                                            <!-- Course Level -->
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-signal text-primary me-2"></i>
                                                <span><strong>Level:</strong> {{ $course->level }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- About Course Section -->

                                <h6 class="h6 mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                    About the Course
                                </h6>
                                <div class="mb-5">
                                    <p class="text-muted" style="line-height: 1.7;">{{ $course->description }}</p>
                                </div>

                                <!-- Innovative Fees Section -->
                                <div class="mb-5">
                                    <h6 class="h6 mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                        Course Fees
                                    </h6>
                                    
                                    <div class="row g-4">
                                        <!-- Admission Fees -->
                                        <div class="col-md-6">
                                            <div class="card border-0 shadow-sm  p-4 fees-box h-100 d-flex flex-column">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fa fa-credit-card text-success fs-4 me-2"></i>
                                                    <h6 class="mb-0"><strong>Admission Fees</strong></h6>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted">Total Cost:</span>
                                                    <span class="text-success fw-bold fs-5">${{ number_format($course->admission_fee, 2) }}</span>
                                                </div>
                                                <div class="text-end mt-auto">
                                                    <small class="text-muted fst-italic">Non-refundable</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Course Fees -->
                                        <div class="col-md-6">
                                            <div class="card border-0 shadow-sm  p-4 fees-box h-100 d-flex flex-column">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fa fa-graduation-cap text-info fs-4 me-2"></i>
                                                    <h6 class="mb-0"><strong>Course Fees</strong></h6>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted">Total Cost:</span>
                                                    <span class="text-info fw-bold fs-5">${{ number_format($course->course_fee, 2) }}</span>
                                                </div>
                                                <div class="text-end mt-auto">
                                                    <small class="text-muted fst-italic">Installments available</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- University Details Section -->
                                <div class="mb-5">
                                    <h6 class="h6 mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                        University Information
                                    </h6>
                                    
                                    <div class="p-4">
                                        <div class="row">
                                            <!-- University Logo -->
                                            <div class="col-md-3 text-center">
                                                <img src="{{ $course->university->logo ? asset('storage/' . $course->university->logo) : 'https://via.placeholder.com/150' }}" alt="University Logo" class="img-fluid rounded-circle" style="height: 150px; width: 150px; object-fit: cover;">
                                                   <!-- Button to University Profile -->
                                            </div>

                                            <!-- University Info -->
                                            <div class="col-md-9">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h5 class="fw-bold">{{ $course->university->name }} ({{ $course->university->acronym }})</h5>
                                                    <!-- Button to University Profile -->
                                                    <a href="{{ route('university.show', $course->university->id) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fa fa-paper-plane me-2"></i> View University
                                                    </a>
                                                </div>
                                                <p class="text-muted mb-2"><i class="fa fa-map-marker-alt text-primary me-2"></i>Location  : {{ $course->university->city }} , {{ $course->university->country }}</p>
                                                <p class="text-muted mb-2"><i class="fa fa-trophy text-warning me-2"></i>Ranking : {{ $course->university->ranking }}</p>
                                                <p class="text-muted mb-2"><i class="fa fa-calendar-alt text-info me-2"></i>Established : {{ $course->university->established_year }}</p>
                                                <p class="text-muted mb-2">
                                                    <i class="fa fa-address-book text-success me-2"></i>
                                                    {{ $course->university->country_code }} {{ $course->university->phone }} | 
                                                    <a href="mailto:{{ $course->university->email }}" class="text-decoration-none">{{ $course->university->email }}</a>
                                                    
                                                </p>
                                                {{-- <p class="text-muted">{{ $course->university->description }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="h6 mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                    Course Brochure
                                </h6>
                                
                                <!-- Download Brochure Section -->
                                @if($course->brochure)
                                    <div class="mb-4 text-center">
                                        <a href="{{ $course->brochure }}" class="btn btn-outline-info btn-lg d-inline-flex align-items-center">
                                            <i class="fa fa-file-pdf me-2"></i> Download Brochure (PDF)
                                        </a>
                                    </div>
                                @else
                                    <div class="mb-4 text-center">
                                        <p class="text-muted">No brochure available for this course.</p>
                                    </div>
                                @endif
                                

                            </div>

                            <!-- Requirements Tab -->
                            <div class="tab-pane fade {{ $activeTab === 2 ? 'show active' : '' }}" id="requirement" role="tabpanel" aria-labelledby="requirement-tab">
                                <div class="requirement-section">
                                    <div class="d-flex justify-content-between align-items-center mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                        <h6 class="h6 mb-0">
                                            Course Requirements
                                        </h6>
                                        <button  id="addRequirement" class="btn btn-primary btn-sm">Add New Requirement</button>
                                    </div>

                                    <ul class="list-unstyled">
                                        @if($courseRequirements->isNotEmpty())
                                            @foreach($courseRequirements as $requirement)
                                                <li class="d-flex align-items-center mb-4" style="font-size: 1.2em;"> <!-- Increased size -->
                                                    <i class="fa fa-check-circle text-success me-3"></i> <!-- Space adjustment -->
                                                    <strong>{{ $requirement->title }}</strong>
                                                    @if($requirement->description)
                                                        <span class="text-muted ms-2">({{ $requirement->description }})</span>
                                                    @endif
                                                    @if($requirement->is_required)
                                                        <span class="badge bg-warning ms-2">Required</span>
                                                    @endif
                                    
                                                    <!-- Edit and Delete Icons -->
                                                    <div class="ms-auto">
                                                        <button type="button"  class="btn btn-link text-primary me-2 edit-req" title="Edit" onclick='openReqOffcanvas({
                                                            id: {{ $requirement->id }},
                                                            title: "{{ $requirement->title }}",
                                                            description: "{{ $requirement->description }}",
                                                            required: "{{ $requirement->is_required }}"
                                                        })'>
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                       
                                                        <button type="button" class="btn btn-link text-danger p-0" title="Delete" onclick='showConfirmDeleteReModal({{ $requirement->id }})'>
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                       
                                                    </div>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="text-muted">No requirements available for this course.</li>
                                        @endif
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

<!---this is the offcanvas for the coure requirements--->
<form action="{{ route('course.requirement') }}" id="ReqForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="offcanvas offcanvas-end" tabindex="-1" id="CourseReqAddOffcanvas" aria-labelledby="offcanvasCourseFormLabel">
        <div class="offcanvas-header border-bottom" style="padding: 2%;">
            <h6 class="offcanvas-title" id="req-title">Course Requirement</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body mx-0 flex-grow-0">
                <input type="hidden" name="courseId" id="courseId" value="{{ $course->id }}">
                <input type="hidden" name="requirementId" id="requirementId" value="{{ old('requirementId') }}">
                <div class="row mb-3">
                        <label for="name" class="form-label">Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Enter Requirement Title" value="{{ old('title') }}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                <div class="row mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter Requirement Description">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_required" name="is_required"  checked>
                    <label class="form-check-label" for="is_required">
                        This requirement is mandatory
                    </label>
                </div>
                <!-- Divider -->
                <hr class="my-4">

                <button type="submit" id="reqsaveButton" class="btn btn-primary me-sm-3 me-1 data-submit">
                    <span id="reqSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                    <span id="reqButtonText">Submit</span>
                </button>

                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            
        </div>
    </div>
</form>
<!---end of the section---->


 <!-- delete confirm  Modal for course requiremens-->
 <div class="modal fade" id="confirmDeleteModalReq" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-4">Are you sure you want to delete this requirement ?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="reqDelForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                  

                    <button type="submit" id="delreqButton" class="btn btn-danger me-sm-3 me-1 data-submit">
                        <span id="delreqSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span id="delreqButtonText">Submit</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
   
<!----end of it ---->

@endsection

@section('scripts')
<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to handle the opening of the offcanvas for both add and update
            function openOffcanvas(isEditMode = false, data = null) {
                const offcanvasElement = document.getElementById('CourseReqAddOffcanvas');
                const offcanvas = new bootstrap.Offcanvas(offcanvasElement);

                // Set the form fields for editing or reset them for adding
                if (isEditMode && data) {
                    // Update existing requirement values
                    document.getElementById('title').value = data.title;
                    document.getElementById('description').value = data.description;
                    document.getElementById('requirementId').value = data.id;
                    document.getElementById('is_required').checked = Boolean(Number(data.required));;

                    // Update the header and button text for editing
                    document.getElementById('req-title').textContent = 'Update Requirement';
                    document.getElementById('reqButtonText').textContent = 'Update Requirement';
                } else {
                    // Clear the form fields for adding a new requirement
                    document.getElementById('title').value = '';
                    document.getElementById('description').value = '';
                    document.getElementById('requirementId').value = '';
                    document.getElementById('is_required').checked = true; // Default is checked for new requirement

                    // Update the header and button text for adding
                    document.getElementById('req-title').textContent = 'Add New Requirement';
                    document.getElementById('reqButtonText').textContent = 'Save Requirement';
                }

                // Show the offcanvas
                offcanvas.show();
            }

            // Event listener for opening the offcanvas in "Add" mode
            document.getElementById('addRequirement').addEventListener('click', function () {
                openOffcanvas(false); // Open in add mode with empty fields
            });

            // Expose the function to open the offcanvas in "Edit" mode
            window.openReqOffcanvas = function (data) {
                openOffcanvas(true, data); // Open in edit mode with existing data
            };
        });

        //this is the buttons of course profile 
        //button for the save button of leads
        document.addEventListener('DOMContentLoaded', function() {
            new FormSubmitHandler('ReqForm', 'reqsaveButton', 'reqButtonText', 'reqSpinner');
            new FormSubmitHandler('reqDelForm', 'delreqButton', 'delreqButtonText', 'delreqSpinner');
        });

        //this is the js content for the edit
        document.querySelectorAll('.edit-stu').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var statusId = this.getAttribute('data-id'); 


                }); 
        });

        //this is the delete model 
        function showConfirmDeleteReModal(id) {
            const form = document.getElementById('reqDelForm');
            form.action = `/course-req-delete/${id}`; // Update with your delete route
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModalReq'));
            modal.show();
        }

</script>

@if (session('show_modal'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var actIdInput = document.getElementById('requirementId');
            var actIdValue = actIdInput ? actIdInput.value : null;
            if (actIdValue) {
                // If the value exists
                document.getElementById('req-title').textContent = 'Update Requirement';
                document.getElementById('reqButtonText').textContent = 'Update Requirement';
            }
            var offcanvasElement = document.getElementById('CourseReqAddOffcanvas');
            var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        });
    </script>
@endif
@endsection
