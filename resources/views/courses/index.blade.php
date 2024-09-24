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
        <h6 class="card-title mb-0">All Courses</h6>
        <!-- Search Form and Add New User Button Container -->
        <div class="header-actions">
            <form method="GET" action="{{ route('course.index') }}" class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search.."
                        value="{{ request()->query('search') }}">
                    <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <button class="dt-button add-new btn btn-primary ms-n1" tabindex="0" aria-controls="DataTables_Table_0" type="button" id="AddCourse">
                <span><i class="bx bx-plus me-0 me-lg-2"></i><span class="d-none d-lg-inline-block">Add New Course</span></span>
            </button>
        </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered mb-0">
        <thead class="table-light">
            <tr>
                <th class="p-2 col-0">#img</th>
                <th class="p-2 col-3">Title</th>
                <th class="p-2 col-2">Duration</th>
                <th class="p-2 col-1">Level</th>
                <th class="p-2 col-3">Fees</th>
                <th class="p-2 col-1">Category</th>
                <th class="p-2 col-0">University</th>
                <th class="p-2 col-1">Status</th>
                <th class="p-2 col-1">Actions</th>
            </tr>
        </thead>
        <tbody>

       
            @if ($courses->isEmpty())
            <tr>
                <td colspan="9" class="text-center">
                <div class="text-center p-4 bg-light rounded">
                    <img src="{{ asset('assets/img/hotImg/NoData.gif') }}" alt="No Data" class="img-fluid" style=" height: auto;">
                    {{-- <h6 class="mt-2  text-danger">No students found.</h6> --}}
                </div>
                </td>
            </tr>
            @else
                @foreach ($courses as $course)
            
                <tr>
                    <td class="p-1"> <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://ui-avatars.com/api/?name=' . urlencode($row->title) }}" 
                        alt="{{ $course->title }}" 
                        class="img-fluid rounded-circle"
                        style="width: 30px; height: 30px; object-fit: cover;"></td>
                    <td class="p-1">{{ $course->title }}</td>
                    <td class="p-1">{{ $course->duration_value }} {{ $course->duration_type }}</td>
                    <td class="p-1">{{ $course->level }}</td>
                    <td class="p-1">Total : {{ $course->total_fee }}</td>
                    <td class="p-1">{{ $course->category->Category_name }}</td>
                    <td class="p-1">{{ $course->university->acronym }}</td>
                    <td class="p-1">
                        @if ($course->status == 'published')
                        <span class="badge bg-success">published</span>
                        @else
                        <span class="badge bg-danger">Draft</span>
                        @endif
                    </td>
                    <td class="p-1 text-center">
                        <!-- Container for buttons -->
                        <div class="d-flex justify-content-center align-items-center">
                            <!-- Edit Button with Icon -->
                            <button class="btn btn-outline-primary mx-1 edit-course-button" data-id="{{ $course->id }}" title="Edit" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                                <i class='bx bx-edit'></i>
                            </button>
                            <!-- Delete Button with Icon -->
                            <a href="{{ route('course.show', $course->id) }}"><button class="btn btn-outline-primary mx-1 view-profile-btn" title="Profile" style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
                                <i class='bx bx-chevron-right'></i> <!-- Right Arrow Icon -->
                            </button></a>
                            <!-- Delete Button with Icon -->
                            <button class="btn btn-outline-danger mx-1 delete-btn" data-form-action="{{ route('course.delete', $course->id) }}" title="delete"  style="font-size: 0.5rem; padding: 0.1rem 0.2rem; border-width: 1px;">
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
          Total Records: {{ $courses->total() }}
      </div>
      <!-- Pagination -->
      <div class="pagination-container">
        {{ $courses->links('vendor.pagination.bootstrap-5') }}
      </div>
  </div>
</div>

<!--this is offcanvas for the course input fields--->
<form action="{{ route('course.store') }}" id="CourseForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="offcanvasCourseForm" aria-labelledby="offcanvasCourseFormLabel">
        <div class="offcanvas-header border-bottom" style="padding: 2%;">
            <h6 class="offcanvas-title" id="offcanvasCourseFormLabel">Course Form</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <input type="hidden" name="editId" id="editId" value="{{ old('editId') }}">

            <!-- Course Title -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="title" class="form-label">Course Title *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Course Title" value="{{ old('title') }}">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                 <!-- Category -->
                 <div class="col-md-6">
                    <label for="category" class="form-label">Category *</label>
                    <select id="category" name="category" class="form-select @error('category') is-invalid @enderror">
                        <option value="" selected disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->Category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                 <!-- Course Language -->
                <div class="col-md-6">
                    <label for="language" class="form-label">Course Language *</label>
                    <input type="text" class="form-control @error('language') is-invalid @enderror" id="language" name="language" placeholder="e.g., English" value="{{ old('language') }}">
                    @error('language')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Course Description *</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Detailed description">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
               <!-- Duration Type -->
                <div class="col-md-6">
                    <label for="duration_type" class="form-label">Duration Type *</label>
                    <select id="duration_type" name="duration_type" class="form-select @error('duration_type') is-invalid @enderror">
                        <option value="" selected disabled>Select Duration Type</option>
                        <option value="days" {{ old('duration_type') == 'days' ? 'selected' : '' }}>Days</option>
                        <option value="weeks" {{ old('duration_type') == 'weeks' ? 'selected' : '' }}>Weeks</option>
                        <option value="months" {{ old('duration_type') == 'months' ? 'selected' : '' }}>Months</option>
                        <option value="years" {{ old('duration_type') == 'years' ? 'selected' : '' }}>Years</option>
                    </select>
                    @error('duration_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Duration Value -->
                <div class="col-md-6">
                    <label for="duration_value" class="form-label">Duration Value *</label>
                    <input type="number" class="form-control @error('duration_value') is-invalid @enderror" id="duration_value" name="duration_value" placeholder="e.g., 6" value="{{ old('duration_value') }}">
                    @error('duration_value')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">

                <!-- Course Level -->
                <div class="col-md-6">
                    <label for="level" class="form-label">Level *</label>
                    <select id="level" name="level" class="form-select @error('level') is-invalid @enderror">
                        <option value="" selected disabled>Select Level</option>
                        <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="Intermediate" {{ old('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="Advanced" {{ old('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                    @error('level')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- University -->
                <div class="col-md-6">
                    <label for="university" class="form-label">University *</label>
                    <select id="university" name="university" class="form-select @error('university') is-invalid @enderror">
                        <option value="" selected disabled>Select University</option>
                        @foreach ($universities as $university)
                            <option value="{{ $university->id }}" {{ old('university') == $university->id ? 'selected' : '' }}>
                                {{ $university->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('university')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

               
            </div>

            <div class="row mb-3">
                

                <!-- Admission Fee -->
                <div class="col-md-6">
                    <label for="admission_fee" class="form-label">Admission Fee *</label>
                    <input type="text" class="form-control @error('admission_fee') is-invalid @enderror" id="admission_fee" name="admission_fee" placeholder="e.g., 500.00" value="{{ old('admission_fee') }}">
                    @error('admission_fee')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Course Fee -->
                <div class="col-md-6">
                    <label for="course_fee" class="form-label">Course Fee *</label>
                    <input type="text" class="form-control @error('course_fee') is-invalid @enderror" id="course_fee" name="course_fee" placeholder="e.g., 2000.00" value="{{ old('course_fee') }}">
                    @error('course_fee')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="row mb-3">
                <!-- Start Date -->
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date *</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                    @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- End Date -->
                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date *</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                    @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">

                <!-- Max Students -->
                <div class="col-md-6">
                    <label for="max_students" class="form-label">Max Students</label>
                    <input type="number" class="form-control @error('max_students') is-invalid @enderror" id="max_students" name="max_students" placeholder="e.g., 50" value="{{ old('max_students') }}">
                    @error('max_students')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Course Thumbnail -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="thumbnail" class="form-label">Thumbnail *</label>
                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(this, 'thumbnailPreview')">
                    @error('thumbnail')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="Preview" class="mt-2">
                        <img id="thumbnailPreview" src="" alt="Thumbnail Preview" style="max-width: 250px; max-height: 100px; display: none;">
                    </div>
                </div>
         
                <div class="col-md-6">
                    <label for="brochure" class="form-label">Brochure (PDF)</label>
                    <input type="file" class="form-control @error('brochure') is-invalid @enderror" id="brochure" name="brochure" accept="application/pdf">
                    @error('brochure')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

             <!-- Divider -->
             <hr class="my-4">

             <!-- Submit Button -->
             <button type="submit" id="courseButton" class="btn btn-primary me-sm-3 me-1 data-submit">
                 <span id="courseSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                     <span class="visually-hidden">Loading...</span>
                 </span>
                 <span id="courseButtonText">Submit</span>
             </button>
             <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </div>
</form>

<!----end of the offcanvas--->

 <!-- Delete Confirmation Modal -->
 <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="font-size: 1.25rem;">
          Are you sure you want to delete the course ? This action cannot be undone.
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

@if(session('show_modal'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editIdInput = document.getElementById('editId');
            var actIdValue = editIdInput ? editIdInput.value : null;
            if (actIdValue) {
                // If the value exists
                document.getElementById('offcanvasCourseFormLabel').textContent = 'Update Course';
                document.getElementById('courseButtonText').textContent = 'Update';
            }
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasCourseForm'));
            offcanvas.show();
        });
    </script>
@endif

<script>
    document.getElementById('AddCourse').addEventListener('click', function(event) {
        event.preventDefault();
        
        // Clear the form inputs
        document.getElementById('editId').value = '';
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('duration_type').value = '';
        document.getElementById('duration_value').value = '';
        document.getElementById('university').value = '';
        document.getElementById('category').value = '';
        document.getElementById('level').value = '';
        document.getElementById('admission_fee').value = '';
        document.getElementById('course_fee').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
        document.getElementById('max_students').value = '';
        document.getElementById('status').value = 'draft'; // Set default to Draft
        document.getElementById('thumbnail').value = ''; // Clear file input
        document.getElementById('brochure').value = ''; // Clear file input
        document.getElementById('thumbnailPreview').style.display = 'none'; // Hide the preview
        document.getElementById('language').value = '';
        // Update modal title and button text
        document.getElementById('offcanvasCourseFormLabel').textContent = 'Add New Course';
        document.getElementById('courseButtonText').textContent = 'Submit';
        
        // Show the offcanvas
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasCourseForm'));
        offcanvas.show();
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

    //this is the button saving thing options 
    document.addEventListener('DOMContentLoaded', function() {
        new FormSubmitHandler('CourseForm', 'courseButton', 'courseButtonText', 'courseSpinner');
        new FormSubmitHandler('deleteForm', 'deleteButton', 'delbuttonText', 'delloadingSpinner');
    });

    //this is the js code for the course edit part 
    document.addEventListener('DOMContentLoaded', function() {
       // Add event listeners to edit buttons
        document.querySelectorAll('.edit-course-button').forEach(button => {
            button.addEventListener('click', function() {
                const courseId = this.dataset.id; // Get the course ID from the data attribute
                fetchCourseData(courseId);
            });
        });

        function fetchCourseData(id) {
            fetch(`/course/${id}`)
                .then(response => response.json())
                .then(data => {
                    // Populate the form with the fetched data
                    document.getElementById('editId').value = data.id;
                    document.getElementById('title').value = data.title;
                    document.getElementById('category').value = data.category_id;
                    document.getElementById('language').value = data.language;
                    document.getElementById('description').value = data.description;
                    document.getElementById('duration_type').value = data.duration_type;
                    document.getElementById('duration_value').value = data.duration_value;
                    document.getElementById('level').value = data.level;
                    document.getElementById('university').value = data.university_id;
                    document.getElementById('admission_fee').value = data.admission_fee;
                    document.getElementById('course_fee').value = data.course_fee;
                    document.getElementById('start_date').value = data.start_date;
                    document.getElementById('end_date').value = data.end_date;
                    document.getElementById('max_students').value = data.max_students;
                    document.getElementById('status').value = data.status;

                    // Preview existing thumbnail and brochure
                    if (data.thumbnail) {
                        document.getElementById('thumbnailPreview').src = `/storage/${data.thumbnail}`;
                        document.getElementById('thumbnailPreview').style.display = 'block';
                    }
                    if (data.brochure) {
                        // Handle brochure preview if needed
                    }

                    document.getElementById('offcanvasCourseFormLabel').textContent = 'Update Course';
                    document.getElementById('courseButtonText').textContent = 'Update';

                    // Show the offcanvas form
                    var myOffcanvas = document.getElementById('offcanvasCourseForm');
                    var offcanvas = new bootstrap.Offcanvas(myOffcanvas);
                    offcanvas.show();
                })
                .catch(error => console.error('Error:', error));
        }
    });

    //this is the deletation function 
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