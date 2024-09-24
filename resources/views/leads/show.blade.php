@extends('layouts/layoutMaster')

@section('title', 'University Profile')

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
<div class="wrapper" >
    <div class="container-fluid p-0 mt-0">
        <div class="main-content">  
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center" >
                    <h1 class="h5">Student : John Doe</h1>
                    <div>
                        <button class="btn btn-primary btn-sm me-1 edit-stu" data-status-id="{{ $student->id }}">
                            <i class="fa fa-pencil me-1"></i> Edit Info
                        </button>
                        <button class="btn btn-secondary btn-sm me-1">
                            <i class="fa fa-calendar-check-o"></i> Activity
                        </button>
                        <button class="btn btn-secondary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#emailModal">
                            <i class="fa fa-envelope-o"></i> Email
                        </button>
                        <a href="https://api.whatsapp.com/send?text=Hi&phone=+1234567890" class="btn btn-success btn-sm">
                            <i class="fa fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>

                <div class="card border-0">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-0" id="studentTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 1 ? 'active' : '' }}" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 2 ? 'active' : '' }}" id="activity-tab" data-bs-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Activity</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="status-tab" data-bs-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">Status</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payment-tab" data-bs-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="documents-tab" data-bs-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Documents</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" id="mails-tab" data-bs-toggle="tab" href="#mails" role="tab" aria-controls="mails" aria-selected="false">Mails</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="studentTabContent">
                            <div class="tab-pane fade {{ $activeTab === 1 ? 'show active' : '' }}" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <!-- Student Information Section -->
                                <h6 class="h6 mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                    Student Information
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-lg-3 text-center">
                                        <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}" class="img-fluid" style="width: 140px; height: 150px; object-fit: cover; border: 2px solid #ddd; border-radius: 5%;" alt="Student Photo">
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <p>{{ $student->name }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Mobile</label>
                                                    <p>+{{ $student->country_code }} {{ $student->phone }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <p>{{ $student->email }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>country</label>
                                                    <p>{{ $student->country }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Contact Address</label>
                                                    <p>{{ $student->address }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Dob</label>
                                                    <p>{{ $student->dob }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Passport No</label>
                                                    <p>{{ $student->passport_no }}</p>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Last qulafication</label>
                                                    <p>{{ $student->last_degree }}</p>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>

                                <h6 class="h6 mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                    Qualification Information
                                </h6>
                                <div class="row mb-3">
                                    @foreach($qualifications as $qualification)
                                        <div class="col-lg-4">
                                            <div class="card mb-2 border-0">
                                                <div class="card-body mb-0 p-2">
                                                    <h5 class="card-title">{{ $qualification->degree }}</h5>
                                                    <p class="card-text">
                                                        Passing Year : {{ $qualification->passing_year }}<br>
                                                        CGPA : {{ $qualification->cgpa }}<br>
                                                        University : {{ $qualification->institution }}
                                                    </p>
                                                    <div class="d-flex justify-content-between mt-1 mb-0" style="background-color: #f7f7f7; padding: 5px; border-radius: 5px;">
                                                        <button class="btn btn-sm btn-outline-primary" title="Edit" onclick='openQualificationOffcanvas({
                                                            id: {{ $qualification->id }},
                                                            degree: "{{ $qualification->degree }}",
                                                            passing_year: {{ $qualification->passing_year }},
                                                            cgpa: "{{ $qualification->cgpa }}",
                                                            university: "{{ $qualification->institution }}"
                                                        })'>
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" title="Delete" onclick="showConfirmDeleteModal({{ $qualification->id }})">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                
                                    <div class="col-lg-4">
                                        <div class="card mb-2 border-0 text-center" style="border: 2px dashed #007bff;" >
                                            <div class="card-body">
                                                <h5 class="card-title text-muted">Add New Qualification</h5>
                                                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#addQualificationOffcanvas" aria-controls="addQualificationOffcanvas"> <i class="bx bx-plus" style="font-size: 30px;"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Offcanvas -->
                                    <div class="offcanvas offcanvas-end" tabindex="-1" id="addQualificationOffcanvas" aria-labelledby="addQualificationLabel">
                                        <div class="offcanvas-header border-bottom" style="padding: 2%;">
                                            <h6 class="offcanvas-title" id="lead-title">
                                                Add New Qualification
                                            </h6>
                                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body mx-0 flex-grow-0">
                                            <form class="pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="qualificationForm" action="{{ route('qualifications.save') }}" method="POST">
                                              @csrf  
                                              <input type="hidden" id="student_id" name="student_id" value="{{ $student->id }}">
                                              <input type="hidden" id="qualification_id" name="qualification_id" value="{{ old('qualification_id') }}">
                                                <div class="mb-3">
                                                    <label for="degree" class="form-label">Degree</label>
                                                    <input type="text" class="form-control" id="degree" name="degree" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="passing_year" class="form-label">Passing Year</label>
                                                    <input type="number" class="form-control" id="passing_year" name="passing_year" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cgpa" class="form-label">CGPA</label>
                                                    <input type="text" class="form-control" id="cgpa" name="cgpa" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="university" class="form-label">University</label>
                                                    <input type="text" class="form-control" id="institution" name="institution" required>
                                                </div>
                                                <!-- Divider -->
                                                <hr class="my-4">

                                                <button type="submit" id="QsaveButton" class="btn btn-primary me-sm-3 me-1 data-submit">
                                                    <span id="QSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </span>
                                                    <span id="QButtonText">Submit</span>
                                                </button>

                                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <h6 class="h6 mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                    Student Interest
                                </h6>
                                <div class="row mb-3">
                                    @if($student->interested_course)
                                    <div class="alert alert-warning" role="alert">
                                        {{ $student->interested_course }}
                                    </div>
                                    @endif
                                </div>

                               
                                

                                <!-- Notification Section -->
                                <h6 class="h6 mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; background-color: #f7f7f7;">
                                    Notifications
                                    <button class="btn btn-sm btn-outline-primary float-end mt-0" id="addNotificationBtn" onclick="toggleNotificationInput()">Add</button>
                                </h6>
                                <div class="row mb-3" id="notificationInput" style="display: none;">
                                    <div class="col-lg-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Enter new notification" aria-label="New Notification">
                                            <button class="btn btn-outline-success" type="button" onclick="addNotification()">Send..</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    {{-- <div class="alert alert-success" role="alert">
                                        You have 3 new notifications.
                                    </div> --}}
                                </div>
                                
                                <script>
                                function toggleNotificationInput() {
                                    var inputSection = document.getElementById("notificationInput");
                                    inputSection.style.display = inputSection.style.display === "none" ? "block" : "none";
                                }
                                
                                function addNotification() {
                                    // Logic to add the notification goes here
                                    alert("Notification added! (Implement the functionality)");
                                }
                                </script>
                                
                                
                                
                            </div>

                            <!-- Additional tab content can go here -->
                            <div class="tab-pane fade {{ $activeTab === 2 ? 'show active' : '' }}" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                                

                                <div class="d-flex justify-content-between align-items-center mb-3" style="border-left: 3px solid #1c82e7; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; background-color: #f7f7f7;">
                                    <h6 class="h6 mb-0">
                                        Activity Timeline
                                    </h6>
                                    <button  id="addActivityBtn" class="btn btn-primary btn-sm">Add Activity</button>
                                </div>
                                <ul class="timeline timeline-dashed mt-4">
                                    @foreach ($activities as $activity)
                                        <li class="timeline-item pb-4 timeline-item-{{ getTimelineClass($activity->status) }} border-left-dashed">
                                            <span class="timeline-indicator-advanced timeline-indicator-{{ getTimelineClass($activity->status) }}">
                                                <i class="bx bx-{{ getTimelineIcon($activity->activity_type) }} bx-xs"></i>
                                            </span>
                                            <div class="timeline-event">
                                                <div class="timeline-header border-bottom mb-3 d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-0">{{ ucfirst($activity->activity_type) }} Activity</h6>
                                                        <small class="text-muted">{{ Carbon::parse($activity->activity_date)->format('d M Y') }}</small>
                                                    </div>
                                                    <div>
                                                        <!-- Edit and Delete Icons -->
                                                        <a href="#" class="text-muted mx-2 edit-activity" title="Edit" data-act-id="{{ $activity->id }}">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <a href="#" class="text-muted" title="Delete" onclick="actConfirmDeleteModal({{ $activity->id }})">
                                                            <i class="bx bx-trash"></i>
                                                        </a>
                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                                    <div>
                                                        <span>Direction : {{ ucfirst($activity->direction) }}</span>
                                                        <i class="bx bx-right-arrow-alt scaleX-n1-rtl mx-3"></i>
                                                        <span>Status : {{ ucfirst($activity->status) }}</span>
                                                    </div>
                                                    <div>
                                                        <span>{{ $activity->activity_time ? Carbon::parse($activity->activity_time)->format('h:i A') : 'N/A' }}</span>,
                                                        <span>By : {{ $activity->user->name }} ({{ $activity->user->getRoleNames()->first() }})</span>
                                                    </div>
                                                </div>
                                                <p>{{ $activity->result }}<br>{{ $activity->remarks }}</p>
                                                @if($activity->attachment)
                                                    <a href="{{ asset('storage/'.$activity->attachment) }}">
                                                        <i class="bx bx-link"></i>
                                                        Download Attachment
                                                    </a>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="timeline-end-indicator">
                                        <i class="bx bx-check-circle"></i>
                                    </li>
                                </ul>
                                
                                
                            </div>
                            
                            <div class="tab-pane fade" id="status" role="tabpanel" aria-labelledby="status-tab">Student status content...</div>
                            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">Payment details content...</div>
                            <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">Documents content...</div>
                            <div class="tab-pane fade" id="mails" role="tabpanel" aria-labelledby="mails-tab">Mails content...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-2">
                        <label for="recipientEmail" class="form-label">Recipient</label>
                        <input type="email" class="form-control" id="recipientEmail" placeholder="Recipient's email">
                    </div>
                    <div class="mb-2">
                        <label for="emailSubject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="emailSubject" placeholder="Subject">
                    </div>
                    <div class="mb-2">
                        <label for="emailBody" class="form-label">Message</label>
                        <textarea class="form-control" id="emailBody" rows="3" placeholder="Write your message here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm">Send Email</button>
            </div>
        </div>
    </div>
</div>

<!---delete model for qualifications --->
 <!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-5">Are you sure you want to delete this qualification?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="QdeleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                  

                    <button type="submit" id="delQButton" class="btn btn-danger me-sm-3 me-1 data-submit">
                        <span id="delQSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span id="delQButtonText">Submit</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
   
<!----end of it ---->

<!---this is the offcanvas of the student info---->
<!--this is offcanvas for the course input fields--->
<form action="{{ route('student.update') }}" id="StuForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="StudentAddOffcanvas" aria-labelledby="offcanvasCourseFormLabel">
        <div class="offcanvas-header border-bottom" style="padding: 2%;">
            <h6 class="offcanvas-title" id="lead-title">Student Info</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body mx-0 flex-grow-0">
                <input type="hidden" name="studentId" id="studentId" value="{{ $student->id }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
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
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                    <label for="city" class="form-label">City *</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="City" value="{{ old('city') }}">
                    @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-md-6">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Address" value="{{ old('address') }}">
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" placeholder="Date of Birth" value="{{ old('dob') }}">
                        @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last_degree" class="form-label">Last Degree *</label>
                        <input type="text" class="form-control @error('last_degree') is-invalid @enderror" id="last_degree" name="last_degree" placeholder="Last Degree" value="{{ old('last_degree') }}">
                        @error('last_degree')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">

                    <div class="col-md-6">
                        <label for="interested_course" class="form-label">Student Interested course *</label>
                        <input type="text" class="form-control @error('interested_course') is-invalid @enderror" id="interested_course" name="interested_course" placeholder="Student interested course"  value="{{ old('interested_course') }}">
                        @error('interested_course')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="col-md-6">
                        <label for="active_status" class="form-label">Active Status *</label>
                        <select class="form-select @error('active_status') is-invalid @enderror" id="active_status" name="active_status">
                            <option value="1" {{ old('active_status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('active_status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('active_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

              

                <div class="row mb-3">

                    <div class="col-md-6">
                        <label for="passport_no" class="form-label">Passport No </label>
                        <input type="text" class="form-control @error('passport_no') is-invalid @enderror" id="passport_no" name="passport_no" placeholder="Passport No" value="{{ old('passport_no') }}">
                        @error('passport_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="interested_category" class="form-label">Interested Categories </label>
                        <input type="text" class="form-control @error('interested_category') is-invalid @enderror" id="interested_category" name="interested_category" placeholder="Student Interested in Category" value="{{ old('interested_category') }}">
                        @error('interested_category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                  
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" placeholder="remarks">{{ old('remarks') }}</textarea>
                        @error('remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="photo" class="form-label">Profile Photo</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                        @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="photoPreview" class="mt-2">
                            <img id="PhotoPreview" src="" alt="Profile Photo Preview" style="max-width: 100px; display: none;">
                        </div>
                    </div>
                </div>

                
                

                <!-- Divider -->
                <hr class="my-4">

                <button type="submit" id="LeadsaveButton" class="btn btn-primary me-sm-3 me-1 data-submit">
                    <span id="LeadSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                    <span id="LeadButtonText">Submit</span>
                </button>

                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            
        </div>
    </div>
</form>

<!---end of the offcanvas--->

<!--model for the activity --->
<div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="activityForm" action="{{ route('student.activity') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="activity-title">Log Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                    <input type="hidden" name="activityid" id="ActId" value="{{ old('activityid') }}"> <!-- For update, the activity ID will be populated here -->
                    <input type="hidden" name="student_id" id="stu_id" value="{{ $student->id }}"> <!-- Assuming you're linking to a student -->

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="activity_type" class="form-label">Activity Type *</label>
                            <select class="form-select @error('activity_type') is-invalid @enderror" id="activity_type" name="activity_type" >
                                <option value="" disabled selected>Select Activity Type</option>
                                <option value="Call" {{ old('activity_type') == 'Call' ? 'selected' : '' }}>Call</option>
                                <option value="Message" {{ old('activity_type') == 'Message' ? 'selected' : '' }}>Message</option>
                                <option value="Meeting" {{ old('activity_type') == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                                <option value="Email" {{ old('activity_type') == 'Email' ? 'selected' : '' }}>Email</option>
                                <option value="Contact" {{ old('activity_type') == 'Contact' ? 'selected' : '' }}>Contact</option>
                            </select>
                            @error('activity_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-3">
                            <label for="activity_date" class="form-label">Activity Date *</label>
                            <input type="date" class="form-control @error('activity_date') is-invalid @enderror" id="activity_date" name="activity_date" value="{{ old('activity_date') }}" >
                            @error('activity_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="activity_time" class="form-label">Activity Time</label>
                            <input type="time" class="form-control @error('activity_time') is-invalid @enderror" id="activity_time" name="activity_time" value="{{ old('activity_time') }}">
                            @error('activity_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_person" class="form-label">Contact Person</label>
                            <input type="text" class="form-control @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number') }}">
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="result" class="form-label">Result</label>
                            <input type="text" class="form-control @error('result') is-invalid @enderror" id="result" name="result" value="{{ old('result') }}">
                            @error('result')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="direction" class="form-label">Direction</label>
                            <select class="form-control @error('direction') is-invalid @enderror" id="direction" name="direction" required>
                                <option value="incoming" {{ old('direction') == 'incoming' ? 'selected' : '' }}>Incoming</option>
                                <option value="outgoing" {{ old('direction') == 'outgoing' ? 'selected' : '' }}>Outgoing</option>
                            </select>
                            @error('direction')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" id="Actremarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="attachment" class="form-label">Attachment</label>
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="entry_id" value="{{ auth()->user()->id }}"> <!-- Assuming the logged-in user creates the entry -->
                    <input type="hidden" name="updated_id" value="{{ auth()->user()->id }}"> <!-- Assuming the logged-in user updates the entry -->

               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="ActivitysaveButton" class="btn btn-primary me-sm-3 me-1 data-submit">
                    <span id="ActivitySpinner" class="spinner-border spinner-border-sm d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                    <span id="ActivityButtonText">Save Activity</span>
                </button>
                
            </div>
        </form>
        </div>
    </div>
</div>

<!---end of the model activity--->

 <!-- delete confirm  Modal for activity -->
 <div class="modal fade" id="ActconfirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-4">Are you sure you want to delete this activity ?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="actdeleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                  

                    <button type="submit" id="delactButton" class="btn btn-danger me-sm-3 me-1 data-submit">
                        <span id="delactSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span id="delactButtonText">Submit</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
   
<!----end of it ---->

@endsection

@section('scripts')

<!--validation error handeling --->
@if ($errors->has('name') || $errors->has('email') || $errors->has('country') || $errors->has('country_code') || $errors->has('phone') || $errors->has('city') || $errors->has('address') || $errors->has('password') || $errors->has('last_degree') || $errors->has('active_status') || $errors->has('interested_course'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('StudentAddOffcanvas'));
            offcanvas.show();
        });
    </script>
@endif
<!---validation error handeling--->

@if (session('show_modal'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var actIdInput = document.getElementById('ActId');
            var actIdValue = actIdInput ? actIdInput.value : null;
            if (actIdValue) {
                // If the value exists
                document.getElementById('activity-title').textContent = 'Log Update Activity';
                document.getElementById('ActivityButtonText').textContent = 'Update Activity';
            }
            var activityModal = new bootstrap.Modal(document.getElementById('activityModal'));
            activityModal.show();
        });
    </script>
@endif

<script>

        //Preview uploaded photo
        document.getElementById('photo').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('PhotoPreview');
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

        //this is the js for qualification 
        document.addEventListener("DOMContentLoaded", function () {
            // Function to open the offcanvas and set values
            window.openQualificationOffcanvas = function (qualification) {
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('addQualificationOffcanvas'));

                // Set the form fields if qualification data is provided
                if (qualification) {
                    document.getElementById('qualification_id').value = qualification.id;
                    document.getElementById('degree').value = qualification.degree;
                    document.getElementById('passing_year').value = qualification.passing_year;
                    document.getElementById('cgpa').value = qualification.cgpa;
                    document.getElementById('institution').value = qualification.university; // Changed to 'university' to match your field

                    document.getElementById('lead-title').innerText = "Update Qualification";
                } else {
                    // Reset the form for adding new qualification
                    document.getElementById('qualification_id').value = '';
                    document.getElementById('qualificationForm').reset();
                    document.getElementById('lead-title').innerText = "Add New Qualification";
                }

                offcanvas.show();
            };
        });


        //button for the save button of leads
        document.addEventListener('DOMContentLoaded', function() {
            new FormSubmitHandler('qualificationForm', 'QsaveButton', 'QButtonText', 'QSpinner');
            new FormSubmitHandler('QdeleteForm', 'delQButton', 'delQButtonText', 'delQSpinner');
            new FormSubmitHandler('StuForm', 'LeadsaveButton', 'LeadButtonText', 'LeadSpinner');
            new FormSubmitHandler('activityForm', 'ActivitysaveButton', 'ActivityButtonText', 'ActivitySpinner');
            new FormSubmitHandler('actdeleteForm', 'delactButton', 'delactButtonText', 'delactSpinner');
        });

        //delete qualifications
        function showConfirmDeleteModal(id) {
            const form = document.getElementById('QdeleteForm');
            form.action = `/qualification-delete/${id}`; // Update with your delete route
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }

        //edit student 
         // student list edit part 
        document.querySelectorAll('.edit-stu').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                
                var statusId = this.getAttribute('data-status-id'); // Make sure it's 'data-status-id'
                //console.log('Status ID:', statusId);

                if (statusId) {
                    var url = '/lead-student/' + statusId;
                    //console.log('Fetching data from:', url);

                    // Fetch the data using AJAX
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            // Set the values in the form
                            document.getElementById('studentId').value = data.id;
                            document.getElementById('name').value = data.name;
                            document.getElementById('email').value = data.email;
                            document.getElementById('country').value = data.country;
                            document.getElementById('country-code').value = data.country_code;
                            document.getElementById('phone').value = data.phone;
                            document.getElementById('address').value = data.address;
                            document.getElementById('dob').value = data.dob;
                            document.getElementById('city').value = data.city;
                            document.getElementById('last_degree').value = data.last_degree;
                            document.getElementById('active_status').value = data.active_status;
                            document.getElementById('interested_course').value = data.interested_course;
                            document.getElementById('passport_no').value = data.passport_no;
                            document.getElementById('interested_category').value = data.interested_category;
                            document.getElementById('remarks').textContent = data.remarks;

                            if (data.photo) {
                                document.getElementById('PhotoPreview').src = '/storage/' + data.photo;
                                document.getElementById('PhotoPreview').style.display = 'block';
                            } else {
                                document.getElementById('PhotoPreview').style.display = 'none';
                            }

                            document.getElementById('lead-title').textContent = 'Update Lead Info';
                            document.getElementById('LeadButtonText').textContent = 'Update';

                            // Open the offcanvas
                            var offcanvas = new bootstrap.Offcanvas(document.getElementById('StudentAddOffcanvas'));
                            offcanvas.show();
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    console.error('Invalid Status ID');
                }
            });
        });

        //contry change part 
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('country');
            const countryCodeInput = document.getElementById('country-code');
        
            countrySelect.addEventListener('change', function() {
                const selectedOption = countrySelect.options[countrySelect.selectedIndex];
                const countryCode = selectedOption.getAttribute('data-code');
                countryCodeInput.value = countryCode;
            });

        });

        //add activity model
        document.getElementById('addActivityBtn').addEventListener('click', function() {

            // Clear the form inputs
            document.getElementById('ActId').value = '';
            document.getElementById('activity_type').value = '';
            document.getElementById('activity_date').value = '';
            document.getElementById('activity_time').value = '';
            document.getElementById('contact_person').value = '';
            document.getElementById('contact_number').value = '';
            document.getElementById('result').value = '';
            document.getElementById('status').value = 'Pending'; // Reset to default status
            document.getElementById('attachment').value = '';
            document.getElementById('direction').value = 'incoming'; // Reset to default direction
            document.getElementById('Actremarks').textContent = '';
            
            // Update modal title and button text
            document.getElementById('activity-title').textContent = 'Add New Activity';
            document.getElementById('ActivityButtonText').textContent = 'Save Activity';
            

            var modal = new bootstrap.Modal(document.getElementById('activityModal'));
            modal.show();
        });

        //update activity model edit
        document.querySelectorAll('.edit-activity').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                
                var ActivityId = this.getAttribute('data-act-id'); // Make sure it's 'data-status-id'
                //console.log('Status ID:', statusId);

                if (ActivityId) {
                    var url = '/get-update-activity/' + ActivityId;

                    // Fetch the data using AJAX
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Fetched data:', data);

                            // Set the values in the form
                            document.getElementById('ActId').value = data.id;
                            document.getElementById('activity_type').value = data.activity_type;
                            document.getElementById('activity_date').value = data.activity_date;
                            document.getElementById('activity_time').value = data.activity_time;
                            document.getElementById('contact_person').value = data.contact_person;
                            document.getElementById('contact_number').value = data.contact_number;
                            document.getElementById('result').value = data.result;
                            document.getElementById('status').value = data.status;
                            document.getElementById('direction').value = data.direction;
                            document.getElementById('Actremarks').textContent = data.remarks;
                            document.getElementById('stu_id').value = data.student_id;

                            // Update modal title and button text
                            document.getElementById('activity-title').textContent = 'Log Update Activity';
                            document.getElementById('ActivityButtonText').textContent = 'Update Activity';

                            // Hide the userProfileModal
                        

                            // Initialize activityModal only after hiding the first modal
                            const activityModalElement = document.getElementById('activityModal');
                            const activityModal = new bootstrap.Modal(activityModalElement);

                            // Show activity modal after ensuring the first modal is hidden
                            
                           
                            activityModal.show();
                           
                        })
                        .catch(error => {
                            console.error('Error fetching activity data:', error);
                        });
                }
            });
        });

        //delete activity model
        
        //delete qualifications
        function actConfirmDeleteModal(id) {
            const form = document.getElementById('actdeleteForm');
            form.action = `/student-activity-delete/${id}`; // Update with your delete route
            const modal = new bootstrap.Modal(document.getElementById('ActconfirmDeleteModal'));
            modal.show();
        }

</script>
@endsection
