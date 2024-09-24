@extends('layouts/layoutMaster')

@section('title', 'Roles & Permissions')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('content')
<style>
    .card {
        border-color: #e3e3e3; /* Light border color for the card */
        border-radius: 0.5rem; /* Rounded corners for the card */
        transition: border-color 0.3s ease; /* Smooth transition */
    }

    .card:hover {
        border-color: #007bff; /* Blue border color on hover */
        border-width: 1px; /* Slightly thicker border on hover */
    }

    .card-body {
        padding: 1rem; /* Standard padding */
    }
    .btn-sm {
        padding: 0.2rem 0.5rem;
        font-size: 0.75rem; /* Smaller text size for the buttons */
    }
    .text-muted {
    color: #6c757d !important; /* Standard muted text color */
    }

    .bg-light {
        background-color: #f8f9fa !important; /* Light gray background for rows */
    }

    .querytabslead {
        margin-bottom: 0;
        padding: 2px;
        padding-right: 5px;
        overflow-x: auto; /* Allow horizontal scrolling */
    }

    .status-container {
        display: flex;
        flex-wrap: nowrap; /* Prevent wrapping to the next line */
        gap: 5px; /* Space between cards */
    }

    .statusbox:hover {
        color: #fff; /* Maintain text color */
        /* Add any other hover effects if needed */
    }

    .statusbox {
        padding: 8px;
        text-align: center;
        font-size: 13px; /* Adjust as needed */
        color: #fff;
        border-radius: 4px;
        text-transform: uppercase;
        width: 150px; /* Adjust width as needed */
        /* height: 70px;  */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-decoration: none; /* Remove underline */
    }

  
    /* Remove any hover effect on <a> inside .statusbox */

    .bg-black {
        background-color: #000;
    }

    .status-number {
        margin-bottom: 0;
        font-size: 18px; /* Adjust as needed */
        line-height: 24px; /* Adjust line height */
    }

    .status-badge {
        padding: 0;
        background-color: transparent;
        font-size: 10px; /* Adjust as needed */
    }

    /* Badge colors */
    .badge-primary { background-color: transparent; }
    .badge-secondary { background-color: transparent; }
    .badge-dark { background-color: transparent; }
    .badge-warning { background-color: transparent; }
    .badge-blue { background-color: transparent; }
    .badge-success { background-color: transparent; }
    .badge-danger { background-color: transparent; }

   /* Customize the scrollbar for WebKit browsers (Chrome, Safari) */
    .querytabslead::-webkit-scrollbar {
        height: 2px; /* Thinner scrollbar */
    }

    .querytabslead::-webkit-scrollbar-thumb {
        background-color: #007bff; /* Primary color */
        border-radius: 10px; /* Rounded corners */
    }

    .querytabslead::-webkit-scrollbar-track {
        background-color: #f1f1f1; /* Background color of the scrollbar track */
    }

    /* Customize the scrollbar for Firefox */
    .querytabslead {
        scrollbar-width: thin; /* Thin scrollbar */
        scrollbar-color: #007bff #e9ecef; /* Thumb and track colors */
    }

      /* Custom styles for the statusbox link */
   
    /* Remove hover effects that change text color */

            /* Ripple effect styles */
    .ripple {
        position: relative;
        overflow: hidden;
    }

    /* Ripple effect element */
    .ripple .ripple-effect {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 253, 253, 0.3); /* Ripple color */
        border-radius: 10%;
        transform: translate(-50%, -50%) scale(0);
        pointer-events: none; /* Ensure it doesn’t interfere with clicks */
        z-index: 1; /* Ensure it’s behind the content */
        animation: rippleEffect 1s infinite; /* Animation for the ripple effect */
    }

    /* Ripple animation */
    @keyframes rippleEffect {
        0% {
            transform: translate(-50%, -50%) scale(0); /* Start from the center */
            opacity: 1;
        }
        
        100% {
            transform: translate(-50%, -50%) scale(4); /* Expand further */
            opacity: 0;
        }
    }

    /* Add more background colors as needed for other statuses */

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

    
</style>


    <!-- Button to trigger offcanvas -->
    <div class="bg-light p-2 rounded shadow-sm mb-1">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Title on the left side -->
            <h6 class="mb-0">Leads</h6>
            
            <!-- Button on the right side -->
            <button class="btn btn-primary btn-sm" type="button" id="AddLead" >
                <i class="fa fa-plus"></i>&nbsp; Add New 
            </button>
        </div>
    </div>
    
    
    
    <!-- Bootstrap 5 Card -->
    <div class="querytabslead">
        <div class="status-container">
            <!-- Card 1: All Enquiries -->
           
            <a href="{{ route('leads.index') }}" class="statusbox bg-black " >
              <div class="ripple">
                <div class="status-number">
                    {{ $totalstu }}
                </div>
                <span class="status-badge badge-primary">all</span>
                @if (!request()->route('id'))
                <div class="ripple-effect"></div>
                @endif
              </div>
            </a>

            @foreach ($statuses as $status)
            @php
                // Get the color for this status
                $color = $statusColors[$status->status_name] ?? '#cccccc'; // Default to a grey color if not found
                 // Check if the current status is the one being viewed
                $isActive = request()->route('id') == $status->id;
            @endphp

            <a href="{{ route('leads.show', ['id' => $status->id]) }}" class="statusbox" style="background-color: {{ $color }};">
             <div class="ripple">
                <div class="status-number">
                    <!-- Display the count or number related to this status, if any -->
                    {{ $status->students_count }} <!-- Replace with actual count if needed -->
                </div>
                <span class="status-badge badge-primary">{{ ucfirst($status->status_name) }}</span>
                @if($isActive) <div class="ripple-effect"></div> @endif 
              </div> 
            </a>
            @endforeach
            
        </div>
    </div>
    

    <div class="my-1">
        <!-- Compact and Professional Card -->
          <!-- Check if there are students -->
        @if ($students->isEmpty())
            <div class="text-center p-4 bg-light rounded">
                <img src="{{ asset('assets/img/hotImg/NoData.gif') }}" alt="No Data" class="img-fluid" style=" height: auto;">
                {{-- <h6 class="mt-2  text-danger">No students found.</h6> --}}
            </div>
        @else
        @foreach ($students as $student)
            <div class="card shadow-sm bg-white rounded mb-2">
                <div class="card-body p-2">
                    <!-- General Information Row 1 -->
                    <div class="d-flex align-items-start mb-0">
                        <!-- Checkbox and ID -->
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" id="assignqury-{{ $student->id }}" value="{{ $student->id }}" onclick="selectedfun();" style="width: 16px; height: 16px;">
                        </div>
        
                        <!-- Information Section -->
                        <div class="flex-grow-1">
                            <!-- Title and Info -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="">
                                    <a href="" class="text-decoration-none text-dark">{{ $student->student_id }}</a>
                                    <p><span class="badge bg-danger">{{ $student->enqstatus->status_name ?? 'Unknown' }}</span></p>
                                </div>
                                
                                <div class="">
                                    <p class="text-muted small mb-1"><i class="fa fa-user me-1"></i> {{ $student->name }}</p>
                                    <p class="text-muted small mb-1"><i class="fa fa-globe me-1"></i> {{ $student->country }}</p>
                                </div>
        
                                <div class="">
                                    <p class="text-muted small mb-1"><i class="fa fa-envelope me-1"></i> {{ $student->email }}</p>
                                    <p class="text-muted small mb-1"><i class="fa fa-phone me-1"></i> +{{ $student->country_code }} {{ $student->phone }}</p>
                                </div>
        
                                <div class="">
                                    <p class="text-muted small mb-1"><i class="fa fa-map-marker me-1"></i> Address:</p>
                                    <p class="mb-0" style="font-size: 0.875rem;">{{ $student->address }}</p>
                                </div>
        
                                <div>
                                    <button type="button" class="btn btn-outline-success btn-sm LogActivityButton" data-stu-id="{{ $student->id }}" title="Log Activity">
                                        <i class="fa fa-comments"></i> <!-- History icon -->
                                    </button>
                                    
                                    
                                    <button class="btn btn-outline-primary btn-sm btn-view-profile" data-user-id="{{ $student->id }}" title="View">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#composeMailModal" title="Compose Mail">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm edit-lead" data-status-id="{{ $student->id }}" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    
                                </div>
                            </div>
                            <!-- Button Group -->
                        </div>
                    </div>
        
                    <!-- General Information Row 2 -->
                    <div class="d-flex justify-content-between flex-wrap mt-2 bg-light p-2 rounded-3">
                        <div class="">
                            <p class="text-muted small mb-1"><i class="fa fa-tachometer me-1"></i> Priority :
                                @if($student->priority == 0)
                                <span class="badge bg-dark" style="font-size: 0.65rem;">General</span>
                                @else
                                <img src="{{ asset('assets/img/hotImg/hot.gif') }}" alt="Image Description" class="img-fluid rounded" style="width: 32px; height: 23px;">
                                @endif
                                
                            </p>
                        </div>
                        <div class="">
                            <p class="text-muted small mb-1"> <i class="fa fa-check-circle me-1"></i> Verified :
                                <img src="{{ asset($student->verify ? 'assets/img/hotImg/verify.gif' : 'assets/img/hotImg/cross.gif') }}" alt="Verification Status" class="img-fluid rounded" style="width: 25px; height: 25px;">
                            </p>
                        </div>
        
                        <div class="">
                            <form method="POST" action="{{ route('students.updateReferTo', $student->id) }}">
                                    @csrf
                                    @method('PUT') <!-- Use PUT method to update -->
                                <p class="text-muted small mb-1 d-flex align-items-center">
                                    <select name="refer_to" class="form-control form-control-sm me-1" style="width: auto;">
                                        <option>Assign to</option>
                                        
                                        @foreach ($users as $user)
                                            @php
                                                $isSelected = $user->id === $student->refer_to;
                                            @endphp
                                            @if ($user->id === $currentUser->id)
                                                <option value="{{ $user->id }}" {{ $isSelected ? 'selected' : '' }}>You ({{ $user->roles->pluck('name')->join(', ') }})</option>
                                            @else
                                                <option value="{{ $user->id }}" {{ $isSelected ? 'selected' : '' }}>{{ $user->name }} ({{ $user->roles->pluck('name')->join(', ') }})</option>
                                            @endif
                                        @endforeach

                                    
                                    </select>
                                    <!-- Small "OK" Button -->
                                    <button class="btn btn-outline-primary btn-sm" type="submit">
                                        <i class="fa fa-paper-plane"></i> <!-- Submit icon -->
                                    </button>
                                </p>
                            </form>
                        </div>
        
                        <div class="">
                            <p class="text-muted small mb-1"><i class="fa fa-calendar me-1"></i> Created At : {{ $student->created_at->format('d F Y') }}</p>
                        </div>
        
                        <div class="">
                            <p class="text-muted small mb-1"><i class="fa fa-sticky-note me-1" style="color:#ffa500;"></i> Notes: {{ $student->remarks ?: 'No Notes...' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>

    <div class="card-footer" style="padding: 1%; display: flex; justify-content: space-between; align-items: center;">
        <!-- Total Records -->
        <div class="footer-info">
            Total Records: {{ $students->total() }}
        </div>
        <!-- Pagination -->
        <div class="pagination-container">
            {{ $students->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="activityForm" action="{{ route('leads.activity') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="activity-title">Log Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                        <input type="hidden" name="activityid" id="ActId" value="{{ old('activityid') }}"> <!-- For update, the activity ID will be populated here -->
                        <input type="hidden" name="student_id" id="stu_id" value="{{ old('student_id') }}"> <!-- Assuming you're linking to a student -->

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
                                <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
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

    <!--MODEL FOR PROFILE --->
    <style>
        .progress-wrapper {
            position: relative;
        }
        .progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 6px;
            position: relative;
            margin-bottom: 1rem;
        }
        .progress-bar {
            height: 8px;
            background-color: #007bff;
            border-radius: 6px;
            position: absolute;
            top: 0;
            left: 0;
            transition: width 0.4s ease;
        }
        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .step {
            text-align: center;
            position: relative;
        }
        .step-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            background-color: #6c757d;
            margin-bottom: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .step-text {
            display: block;
            font-size: 0.875rem;
            color: #495057;
        }
        .step.active .step-icon {
            background-color: #28a745;
            color: #fff;
        }
        .step.active .step-text {
            color: #28a745;
        }
        .step:not(.active) .step-text {
            color: #6c757d;
        }
        .progress-wrapper .btn {
            width: 100%;
            max-width: 200px;
        }

        /*activity icons*/
        .student-photo-container {
            position: relative;
            display: inline-block;
        }
        .student-photo {
            max-height: 180px;
            width: 180px;
            object-fit: cover;
            border-radius: 50%;
        }
        .verification-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: white;
            border-radius: 50%;
            padding: 5px;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px #ffffff;
        }

    </style>
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="studentProfileModal" tabindex="-1" aria-labelledby="studentProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered"> 

            <div class="modal-content"  >
                <div class="modal-header">
                    <h5 class="modal-title" id="studentProfileModalLabel">Student Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="loadingSpinner" class="d-none d-flex justify-content-center align-items-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-body d-none" id="modalContent">
                    <!-- Profile Information -->
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <!-- Student Photo -->
                            <div class="student-photo-container">
                                <img src="https://via.placeholder.com/180" alt="Student Photo" class="img-fluid student-photo">
                                <!-- Verification Badge -->
                                <div class="verification-badge">
                                    <i class="fa fa-check-circle text-success" style="font-size: 24px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-3" id="studentName">John Doe</h5>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-envelope me-2 text-primary"></i>
                                <p class="mb-0"><strong>Email:</strong> <span id="studentEmail">john.doe@example.com</span></p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-globe me-2 text-primary"></i>
                                <p class="mb-0"><strong>Country:</strong> <span id="studentCountry">USA</span></p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-city me-2 text-primary"></i>
                                <p class="mb-0"><strong>City:</strong> <span id="studentCity">New York</span></p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-phone me-2 text-primary"></i>
                                <p class="mb-0"><strong>Phone:</strong> <span id="studentPhone">123-456-7890</span></p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-calendar me-2 text-primary"></i>
                                <p class="mb-0"><strong>Create Time:</strong> <span id="createTime">September 1, 2024, 10:00 AM</span></p>
                            </div>
                            <div class="action-buttons d-flex">
                                <button class="btn btn-outline-success btn-sm btn-verify"><i class="fa fa-check-circle me-2"></i>Verify this lead</button>

                                <button class="btn btn-outline-primary btn-sm btn-send-to-student-list"><i class="fa fa-paper-plane me-2"></i>Send to Student List</button>
                                {{-- <a href="#" class="btn btn-outline-info btn-sm"><i class="fa fa-eye me-2"></i>View</a>
                                <a href="#" class="btn btn-outline-success btn-sm"><i class="fa fa-envelope me-2"></i>Contact</a> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="activities-tab" data-bs-toggle="tab" href="#activities" role="tab" aria-controls="activities" aria-selected="false">Activities</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="contacts-tab" data-bs-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="false">Mails</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="profileTabsContent">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class=" ">
                                <h6 class="mb-3">Overview Information</h6>
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-graduation-cap fa-2x me-2 text-primary"></i>
                                            <div>
                                                <p class="mb-0"><strong>Last Qualifications:</strong></p>
                                                <p id="studentQualifications" class="mb-0">Bachelor's in Computer Science, Master's in Data Science</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt fa-2x me-2 text-primary"></i>
                                            <div>
                                                <p class="mb-0"><strong>Address:</strong></p>
                                                <p id="studentAddress" class="mb-0">123 Main St, Springfield, IL</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Created At -->
                                    {{-- <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt fa-2x me-2 text-primary"></i>
                                            <div>
                                                <p class="mb-0"><strong>Created At:</strong></p>
                                                <p id="createdAt" class="mb-0">September 1, 2024, 10:00 AM</p>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <!-- Student Interests -->
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-star fa-2x me-2 text-primary"></i>
                                            <div>
                                                <p class="mb-0"><strong>Interests:</strong></p>
                                                <p id="studentInterests" class="mb-0">Photography, Traveling, Coding</p>
                                            </div>
                                        </div>
                                    </div>

                                   
                                    <!-- Remarks -->
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-comments fa-2x me-2 text-primary"></i>
                                            <div>
                                                <p class="mb-0"><strong>Remarks:</strong></p>
                                                <p id="Sturemarks" class="mb-0">Excellent progress in recent months. Keep up the good work!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Progress Tracker -->
                            <div class="progress-wrapper mt-4">
                                <div class="progress">
                                    <!-- Progress steps -->
                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <ul class="list-unstyled progress-steps mt-3">
                                   
                                </ul>
                                <hr class="diveder">
                                <input type="hidden" id="eq-user-id" value="">
                                <p class="text-muted small mb-1 d-flex align-items-center">
                                    <select class="form-control eq-list me-1">
                                        <option>Change Enquiry Status</option>
                                        <option>One</option>
                                        <option>Two</option>
                                    </select>
                                    <!-- Small "OK" Button -->

                                    <button id="update-status-btn" class="btn btn-outline-primary d-flex align-items-center" type="button">
                                        <span class="loading-spinner-eq spinner-border spinner-border-sm me-1 d-none" role="status" aria-hidden="true"></span>
                                        <i class="fa fa-paper-plane icon"></i> <!-- Submit icon -->
                                    </button>
                                    
                                
                                    {{-- <button id="update-status-btn" class="btn btn-outline-primary" type="button">
                                        <i class="fa fa-paper-plane icon"></i> <!-- Submit icon -->
                                    </button> --}}
                                    
                                </p>
                      
                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-tab">
                            <h6 class="mb-4">Recent Activities</h6>
                            <ul class="list-group" id="activities-list">
                                <!-- Activity Item -->
                                <li class="list-group-item d-flex align-items-start border-0 rounded-3 shadow-sm mb-3">
                                    <div class="d-flex flex-shrink-0 me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-calendar-check"></i> <!-- Icon indicating the activity -->
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Activity 1: Meeting with Client</h6>
                                        <p class="mb-1"><i class="fas fa-calendar-day me-2"></i><strong>Date:</strong> 2024-09-01</p>
                                        <p class="mb-1"><i class="fas fa-clock me-2"></i><strong>Time:</strong> 10:00 AM</p>
                                        <p class="mb-1"><i class="fas fa-user me-2"></i><strong>Contact Person:</strong> Jane Doe</p>
                                        <p class="mb-1"><i class="fas fa-phone me-2"></i><strong>Contact Number:</strong> 555-1234</p>
                                        <p class="mb-1"><i class="fas fa-check-circle me-2"></i><strong>Result:</strong> Successful</p>
                                        <p class="mb-1"><i class="fas fa-tachometer-alt me-2"></i><strong>Status:</strong> Completed</p>
                                        <p class="mb-1"><i class="fas fa-comment-dots me-2"></i><strong>Remarks:</strong> Meeting went well and the project is on track.</p>
                                        
                                        <!-- Buttons for Edit and Delete -->
                                        <div class="d-flex justify-content-end mt-2">
                                            <a href="#" class="btn btn-outline-secondary btn-sm me-2">
                                                <i class="fas fa-edit"></i> &nbsp;&nbsp;Edit
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="fas fa-trash-alt"></i> &nbsp;&nbsp;Delete
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <!-- Repeat activity items as needed -->
                                
                                <!-- Add more activities as needed -->
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                            <h6 class="mt-3">Mails</h6>
                            <ul class="list-group">
                                <li class="list-group-item">Contact 1: Details...</li>
                                <li class="list-group-item">Contact 2: Details...</li>
                                <!-- Add more contacts as needed -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add this CSS to your stylesheet or within a <style> tag -->
   
    <!-- Offcanvas for the Course Category -->
    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="LeadAddOffcanvas" aria-labelledby="LeadAddOffcanvas">
        <div class="offcanvas-header border-bottom" style="padding: 2%;">
            <h6 class="offcanvas-title" id="lead-title">
                Add New Lead
            </h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form class="add-new-course-category pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="LeadForm" action="{{ route('leads.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="studentId" id="studentId" value="{{ old('studentId') }}">
                <input type="hidden" name="activityid" id="ActId" value="{{ old('activityid') }}">
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
                        <label for="lead_source" class="form-label">Lead Source *</label>
                        <select class="form-select @error('lead_source') is-invalid @enderror" id="lead_source" name="lead_source">
                            <option value="">Select Lead Source</option>
                            @foreach($leadSources as $row)
                            <option value="{{$row->id }}" {{ old('lead_source') == $row->Source_name ? 'selected' : '' }}>{{ $row->Source_name }}</option>
                            @endforeach
                            
                            <!-- Add more options as needed -->
                        </select>
                        @error('lead_source')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col-md-6">
                        <label for="last_degree" class="form-label">Last Degree *</label>
                        <input type="text" class="form-control @error('last_degree') is-invalid @enderror" id="last_degree" name="last_degree" placeholder="Last Degree" value="{{ old('last_degree') }}">
                        @error('last_degree')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                        @error('password_confirmation')
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
                        <label for="Priority" class="form-label">Priority *</label>
                        <select class="form-select @error('Priority') is-invalid @enderror" id="Priority" name="Priority">
                            <option value="0" >General</option>
                            <option value="1" >Hot</option>
                        </select>
                        @error('Priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="interested_course" class="form-label">Student Interested course *</label>
                        <input type="text" class="form-control @error('interested_course') is-invalid @enderror" id="interested_course" name="interested_course" placeholder="Student interested course"  value="{{ old('interested_course') }}">
                        @error('interested_course')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
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

                    <div class="col-md-6">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" placeholder="remarks">{{ old('remarks') }}</textarea>
                        @error('remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
            </form>
        </div>
    </div>
    <!-- End of offcanvas for Course Category -->

    <!---this is the activity delete model --->
    <div class="modal fade" id="deleteActConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: 1.25rem;">
              Are you sure you want to delete this Lead's Activity ? This action cannot be undone.
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

    <!---End of the activity model ---->

    <!---Lead Verify Model ---->
    <div class="modal fade" id="VerifyconfirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 fs-3">Are you sure you want to verify this lead?</p>
                </div>
                <div class="modal-footer">
                    <form id="verifyForm" method="POST" action="">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelButton">Cancel</button>
                        <button type="submit" id="verifyButton" class="btn btn-success">
                            <span id="verifyLoadingSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                            <span id="verifyButtonText">Verify</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!---end of the lead verify Model -->

    <!---Student send Verify Model ---->
    <div class="modal fade" id="SendVerifyconfirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm To send Lead to Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 fs-5">Are you sure you want to send this lead to student..?</p>
                </div>
                <div class="modal-footer">
                    <form id="SendverifyForm" method="POST" action="">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelButton">Cancel</button>
                        <button type="submit" id="SendverifyButton" class="btn btn-success">
                            <span id="SendverifyLoadingSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                            <span id="SendverifyButtonText"><i class="fa fa-paper-plane me-2"></i>Send to Student List</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!---end of the model --->

@endsection



@section('scripts')



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

<!--validation error handeling --->
@if ($errors->has('name') || $errors->has('email') || $errors->has('country') || $errors->has('country_code') || $errors->has('phone') || $errors->has('city') || $errors->has('address') || $errors->has('lead_source') || $errors->has('last_degree') || $errors->has('active_status') || $errors->has('priority') || $errors->has('interested_course'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('LeadAddOffcanvas'));
            offcanvas.show();
        });
    </script>
@endif
<!---validation error handeling--->

<script>

        // Example JavaScript to populate modal data
        document.querySelectorAll('.btn-view-profile').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.userId;

                // Open the modal immediately
                var userProfileModal = new bootstrap.Modal(document.getElementById('studentProfileModal'));
                userProfileModal.show();    

                // Hide the modal content and show the spinner
                // Show the loading spinner and hide the modal content
                document.getElementById('modalContent').classList.add('d-none');
                document.getElementById('loadingSpinner').classList.remove('d-none');
            
                // Fetch user data based on the userId using the fetch API
                fetch(`/lead-info/${userId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate the modal with the fetched data
                    document.getElementById('studentName').textContent = data.name;
                    document.getElementById('studentEmail').textContent = data.email;
                    document.getElementById('studentCountry').textContent = data.country;
                    document.getElementById('studentCity').textContent = data.city;
                    document.getElementById('studentPhone').textContent = data.phone;
                    document.getElementById('createTime').textContent = data.created_at;
                    document.getElementById('studentQualifications').textContent = data.qualifications;
                    document.getElementById('studentAddress').textContent = data.address;
                    document.getElementById('studentInterests').textContent = data.interests;
                    document.getElementById('Sturemarks').textContent = data.remarks;
                    document.getElementById('eq-user-id').value = userId;
                    // Set the student photo
                    const studentPhoto = document.querySelector('.student-photo');
                    studentPhoto.src = data.profile_photo_path 
                        ? `/storage/${data.profile_photo_path}`
                        : `https://ui-avatars.com/api/?name=${encodeURIComponent(data.name)}`;

                    // Set the verification badge icon
                    const verificationBadge = document.querySelector('.verification-badge i');
                    if (data.is_verified) {
                        verificationBadge.classList.remove('fa-exclamation-triangle', 'text-danger');
                        verificationBadge.classList.add('fa-check-circle', 'text-success');
                    } else {
                        verificationBadge.classList.remove('fa-check-circle', 'text-success');
                        verificationBadge.classList.add('fa-exclamation-triangle', 'text-danger');
                    }

                    const verifyButton = document.querySelector('.btn-verify');
                    // Set the data-id attribute to the student ID
                    verifyButton.setAttribute('data-id', data.id);
                    if(data.is_verified){
                        verifyButton.style.display = 'none';
                    }else{
                        verifyButton.style.display = 'block';
                    }

                    // Fetch and display progress
                    fetchAndDisplayProgress(data.id);
                    fetchAndDisplayActivities(userId);

                    // Hide loading spinner and show the actual content
                    // Hide the spinner and show the modal content
                    // Hide loading spinner and show the actual content
                    document.getElementById('loadingSpinner').classList.add('d-none');
                    document.getElementById('modalContent').classList.remove('d-none');
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);

                    // Show an error message or handle the error case
                    document.getElementById('loadingSpinner').classList.add('d-none');
                    document.getElementById('modalContent').classList.remove('d-none');
                    // Optionally update the modal content to show an error message
                }); 

            });
        });

        // Function to fetch and display user progress
        function fetchAndDisplayProgress(userId) {
            fetch(`/get-progress/${userId}`)
                .then(response => response.json())
                .then(data => {
                    // Update progress bar
                    const progressBar = document.querySelector('.progress-bar');
                    progressBar.style.width = `${data.progressPercentage}%`;
                    progressBar.setAttribute('aria-valuenow', data.progressPercentage);

                    // Update steps
                    const stepsContainer = document.querySelector('.progress-steps');
                    stepsContainer.innerHTML = ''; // Clear existing steps

                    data.steps.forEach(step => {
                        const stepClass = step.completed ? 'active' : '';
                        const stepIconClass = step.completed ? 'bg-success' : 'bg-secondary';
                        const stepIcon = step.completed ? 'fas fa-check' : 'fas fa-hourglass-half';
                        
                        stepsContainer.innerHTML += `
                            <li class="step ${stepClass}">
                                <div class="step-icon ${stepIconClass}">
                                    <i class="${stepIcon}"></i>
                                </div>
                                <span class="step-text">${step.name}</span>
                            </li>
                        `;
                    });

                    // Check if the last step (final step) is completed
                    const finalStepCompleted = data.steps[data.steps.length - 1].completed;

                    // Get the button and toggle its visibility based on the final step completion
                    const sendToStudentListButton = document.querySelector('.btn-send-to-student-list');
                    if (finalStepCompleted) {
                        sendToStudentListButton.style.display = 'inline-block'; // Show the button
                        sendToStudentListButton.setAttribute('data-id', userId);
                    } else {
                        sendToStudentListButton.style.display = 'none'; // Hide the button
                        sendToStudentListButton.removeAttribute('data-id');
                    }

                    // Fetch and populate statuses
                   fetchStatuses(userId);
                })
                .catch(error => {
                    console.error('Error fetching progress data:', error);
                    // Optionally show an error message
                });
        }
        //end of the function 

        //fetch status function 
        function fetchStatuses(userId) {
            
            fetch(`/get-eq-statuses/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const selectElement = document.querySelector('.eq-list');
                    selectElement.innerHTML = ''; // Clear existing options
                    if (data.statuses && data.statuses.length > 0) {
                            data.statuses.forEach(status => {
                                const isSelected = status.id === data.currentStatusId ? 'selected' : '';
                                selectElement.innerHTML += `
                                    <option value="${status.id}" ${isSelected}>${status.status_name}</option>
                                `;
                            });
                            
                        }else {
                        selectElement.innerHTML = '<option>No statuses available</option>';
                    }
                    
                })
                .catch(error => {
                    console.error('Error fetching statuses:', error);
                    // Optionally show an error message
                });
        }
        //end of the function 
        
        //this is the content of the change or update the status 
        document.getElementById('update-status-btn').addEventListener('click', function () {
                const selectElement = document.querySelector('.eq-list');
                const selectedStatusId = selectElement.value;
                const userId = document.getElementById('eq-user-id').value;

                const button = this; // The button that was clicked
                const spinner = button.querySelector('.loading-spinner-eq');
                button.disabled = true; // Disable the button
                spinner.classList.remove('d-none'); // Show the spinner
                
                if (selectedStatusId) {
                        updateStudentEnquiryStatus(userId, selectedStatusId)
                            .then(data => {
                                if (data.success) {
                                    console.log('Enquiry status updated successfully');
                                    // Optionally, refresh the progress bar and steps
                                    fetchAndDisplayProgress(userId);
                                    // Show success toast notification
                                    
                                } else {
                                    console.error('Failed to update enquiry status');
                                }
                            })
                            .catch(error => {
                                console.error('Error updating enquiry status:', error);
                            })
                            .finally(() => {
                                // Remove loading effect: Enable the button and hide the spinner
                                button.disabled = false; // Enable the button
                                spinner.classList.add('d-none'); // Hide the spinner
                            });
                    } else {
                        console.error('No status selected');
                        button.disabled = false; // Re-enable the button if no status is selected
                        spinner.classList.add('d-none'); // Hide the spinner if no status is selected
                    }
        });

        function updateStudentEnquiryStatus(userId, statusId) {
            return fetch(`/update-enquiry-status/${userId}`, {  
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ statusId: statusId })
            })
            .then(response => response.json());
        }
        //display progress
        
        //this is the function for activities 
        function fetchAndDisplayActivities(userId) {
            fetch(`/get-lead-activity/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const activitiesContainer = document.getElementById('activities-list');
                    activitiesContainer.innerHTML = '';
                    if (data.activities.length === 0) {
                        activitiesContainer.innerHTML = '<li class="list-group-item text-center">No activity yet ...</li>';
                    } else {
                    data.activities.forEach(activity => {
                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item d-flex align-items-start border-0 rounded-3 shadow-sm mb-3';

                        // Conditional logic for icon and background color
                        let iconClass = 'fas fa-calendar-check'; // Default icon
                        let bgClass = 'bg-secondary'; // Default background color

                        if(activity.status === 'Cancelled' ){
                            bgClass = 'bg-danger';
                        } else if(activity.status === 'Completed'){
                            bgClass = 'bg-success';
                        }

                        if (activity.activity_type === 'Message') {
                            iconClass = 'fas fa-comment'; 
                        } else if (activity.activity_type === 'Contact') {
                            iconClass = 'fas fa-phone'; // Call icon
                        } else if (activity.activity_type === 'Email') {
                            iconClass = 'fas fa-envelope'; // Call icon
                        } else if (activity.activity_type === 'Meeting') {
                            iconClass = 'fas fa-handshake'; // Call icon
                        } else if (activity.activity_type === 'call') {
                            iconClass = 'fas fa-phone'; // Call icon
                        } else {
                            iconClass = 'fas fa-calendar-alt'; // Default icon for other activities
                        }
                        var deleteActivityUrl = "{{ route('activity.delete', ['id' => 'ID_PLACEHOLDER']) }}";
                        listItem.innerHTML = `
                            <div class="d-flex flex-shrink-0 me-3">
                                <div class="${bgClass} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="${iconClass}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Activity : ${activity.activity_type} (${activity.direction})</h6>
                                <p class="mb-1"><i class="fas fa-calendar-day me-2"></i><strong>Date:</strong> ${activity.activity_date} | <i class="fas fa-clock me-2"></i><strong>Time:</strong> ${activity.activity_time}</p>
                                <p class="mb-1"><i class="fas fa-user me-2"></i><strong>Contact Person:</strong> ${activity.contact_person} | <i class="fas fa-user me-2"></i><strong>Contact Person:</strong> ${activity.contact_number}</p>
                                <p class="mb-1"><i class="fas fa-tachometer-alt me-2"></i><strong>Status:</strong> ${activity.status}</p>
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i><strong>Outcome:</strong> ${activity.result}</p>
                                <p class="mb-1"><i class="fas fa-comment-dots me-2"></i><strong>Remarks:</strong> ${activity.remarks}</p>
                                ${activity.attachment ? 
                                    `<p class="mb-1"><i class="fas fa-file me-2"></i><strong>Attachment:</strong> <a href="${activity.attachment}" target="_blank">View Attachment</a></p>` 
                                    : ''
                                }
                                
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-2 activity-edit-btn" data-activity-id="${activity.id}">
                                        <i class="fas fa-edit"></i> &nbsp;&nbsp;Edit
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-activity-btn" data-form-action="${deleteActivityUrl.replace('ID_PLACEHOLDER', activity.id)}">
                                        <i class="fas fa-trash-alt"></i> &nbsp;&nbsp;Delete
                                    </button>
                                </div>
                            </div>
                        `;

                        activitiesContainer.appendChild(listItem);
                    });
                    } 
                })
                .catch(error => {
                    console.error('Error fetching activities:', error);
            });
        }
        //end of the function        

        document.getElementById('activities-list').addEventListener('click', function(event) {
            if (event.target && event.target.matches('.activity-edit-btn')) {
                event.preventDefault();
                // console.log('Activity edit button clicked');

                var ActivityId = event.target.getAttribute('data-activity-id');
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
                            document.getElementById('remarks').textContent = data.remarks;
                            document.getElementById('stu_id').value = data.student_id;

                            // Update modal title and button text
                            document.getElementById('activity-title').textContent = 'Log Update Activity';
                            document.getElementById('ActivityButtonText').textContent = 'Update Activity';

                            // Hide the userProfileModal
                            
                            
                            // Properly hide the userProfileModal
                            const userProfileModalElement = document.getElementById('studentProfileModal');
                            const userProfileModalInstance = bootstrap.Modal.getInstance(userProfileModalElement);

                            // Check if the modal is open, and if so, hide it
                            if (userProfileModalInstance) {
                                userProfileModalInstance.hide();
                            }


                            // Initialize activityModal only after hiding the first modal
                            const activityModalElement = document.getElementById('activityModal');
                            const activityModal = new bootstrap.Modal(activityModalElement);

                            // Show activity modal after ensuring the first modal is hidden
                            
                           
                            activityModal.show();
                            

                                
                            // const userProfileModalElement = document.getElementById('studentProfileModal');
                            // const userProfileModal = new bootstrap.Modal(userProfileModalElement);
                            // userProfileModal.hide();
                           
                        })
                        .catch(error => {
                            console.error('Error fetching activity data:', error);
                        });
                }
            }
        });
        



        //add activity model 
        document.querySelectorAll('.LogActivityButton').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            
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
            document.getElementById('remarks').textContent = '';
            document.getElementById('stu_id').value = this.getAttribute('data-stu-id');
            
            // Update modal title and button text
            document.getElementById('activity-title').textContent = 'Log New Activity';
            document.getElementById('ActivityButtonText').textContent = 'Save Activity';
            
            // Show the modal
            var activityModal = new bootstrap.Modal(document.getElementById('activityModal'));
            activityModal.show();
        });

        });


        //activity delete model 
        document.getElementById('activities-list').addEventListener('click', function(event) {
            if(event.target && event.target.matches('.delete-activity-btn')) {
                event.preventDefault();
                const formAction = event.target.getAttribute('data-form-action');

                const deleteForm = document.getElementById('deleteForm');
                deleteForm.setAttribute('action', formAction);

                const userProfileActModalElement = document.getElementById('studentProfileModal');
                const userProfileActModalInstance = bootstrap.Modal.getInstance(userProfileActModalElement);

                        // Check if the modal is open, and if so, hide it
                        if (userProfileActModalInstance) {
                            userProfileActModalInstance.hide();
                        }
                
                const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteActConfirmationModal'));
                deleteConfirmationModal.show();
            }
        });

        //lead verify confirmation 
        document.addEventListener('DOMContentLoaded', function () {
            // Target the specific button with the class 'btn-verify'
            const verifyButton = document.querySelector('.btn-verify');        
            // Check if the button exists to avoid errors
            if (verifyButton) {
                verifyButton.addEventListener('click', function (event) {
                    event.preventDefault();
                    
                    // Get the data-id attribute value
                    // const formAction = this.getAttribute('data-id');

                    const studentId = this.getAttribute('data-id');
                     // Construct the form action URL
                    const formAction = `/lead-verify/${studentId}`;
                    
                    // Find the form and set its action attribute
                    const verifyForm = document.getElementById('verifyForm');
                    verifyForm.setAttribute('action', formAction);
                    
                    const userProfileVerifyModalElement = document.getElementById('studentProfileModal');
                    const userProfileVerifyModalInstance = bootstrap.Modal.getInstance(userProfileVerifyModalElement);
                    // Hide the user profile action modal if it exists
                    if (userProfileVerifyModalInstance) {
                        userProfileVerifyModalInstance.hide();
                    }
            
                    // Show the verification confirmation modal
                    const verifyConfirmationModal = new bootstrap.Modal(document.getElementById('VerifyconfirmationModal'));
                    verifyConfirmationModal.show();
                });
            }
        });

        // student send confirmation 
        document.addEventListener('DOMContentLoaded', function () {
            // Target the specific button with the class 'btn-send-to-student-list'
            const sendverifyButton = document.querySelector('.btn-send-to-student-list');        
            // Check if the button exists to avoid errors
            if (sendverifyButton) {
                sendverifyButton.addEventListener('click', function (event) {
                    event.preventDefault();
                    
                    // Get the data-id attribute value
                    const stuId = this.getAttribute('data-id');
                    // Construct the form action URL
                    const SendformAction = `/lead-send-to-student/${stuId}`;
                    
                    // Find the form and set its action attribute
                    const sendverifyForm = document.getElementById('SendverifyForm');
                    sendverifyForm.setAttribute('action', SendformAction);
                    
                    const userProfileSendModalElement = document.getElementById('studentProfileModal');
                    const userProfileSendModalInstance = bootstrap.Modal.getInstance(userProfileSendModalElement);
                    // Hide the user profile action modal if it exists
                    if (userProfileSendModalInstance) {
                        userProfileSendModalInstance.hide();
                    }
            
                    // Show the verification confirmation modal
                    const sendverifyConfirmationModal = new bootstrap.Modal(document.getElementById('SendVerifyconfirmationModal'));
                    sendverifyConfirmationModal.show();
                });
            }
        });

        //open the offcanvas model 
        document.getElementById('AddLead').addEventListener('click', function(event) {
            event.preventDefault();
            
            // Clear the form inputs
            document.getElementById('studentId').value = '';
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('country').value = '';
            document.getElementById('country-code').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('address').value = '';
            document.getElementById('dob').value = '';
            document.getElementById('city').value = '';

            document.getElementById('lead_source').value = '';
            document.getElementById('last_degree').value = '';
            document.getElementById('active_status').value = 1;
            document.getElementById('Priority').value = 0;
            document.getElementById('interested_course').value = '';
            document.getElementById('remarks').textContent = '';
            document.getElementById('PhotoPreview').style.display = 'none';
            
            // Update modal title and button text
            document.getElementById('lead-title').textContent = 'Add New Lead';
            document.getElementById('LeadButtonText').textContent = 'Submit';
            
            // Show the offcanvas
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('LeadAddOffcanvas'));
            offcanvas.show();
        });
        //now this is for fetch and showing the data into the offcanvas
        document.querySelectorAll('.edit-lead').forEach(function(button) {
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

                            document.getElementById('lead_source').value = data.lead_source;
                            document.getElementById('last_degree').value = data.last_degree;
                            document.getElementById('active_status').value = data.active_status;
                            document.getElementById('Priority').value = data.priority;
                            document.getElementById('interested_course').value = data.interested_course;
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
                            var offcanvas = new bootstrap.Offcanvas(document.getElementById('LeadAddOffcanvas'));
                            offcanvas.show();
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    console.error('Invalid Status ID');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
        const countrySelect = document.getElementById('country');
        const countryCodeInput = document.getElementById('country-code');
    
        countrySelect.addEventListener('change', function() {
            const selectedOption = countrySelect.options[countrySelect.selectedIndex];
            const countryCode = selectedOption.getAttribute('data-code');
            countryCodeInput.value = countryCode;
        });

        });

        // Preview uploaded photo
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

        //button for the save button of leads
        document.addEventListener('DOMContentLoaded', function() {
            new FormSubmitHandler('LeadForm', 'LeadsaveButton', 'LeadButtonText', 'LeadSpinner');
            // Add more instances as needed
            new FormSubmitHandler('activityForm', 'ActivitysaveButton', 'ActivityButtonText', 'ActivitySpinner');
            // Activity delete model buttons 
            new FormSubmitHandler('deleteForm', 'deleteButton', 'delbuttonText', 'delloadingSpinner');
            new FormSubmitHandler('SendverifyForm', 'SendverifyButton', 'SendverifyButtonText', 'SendverifyLoadingSpinner');
        });

   
</script>

@endsection