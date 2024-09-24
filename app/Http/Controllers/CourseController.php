<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\University;
use App\Models\CourseCategory;
use App\Models\CourseRequirement;
use Illuminate\Http\Request;

class CourseController extends Controller
{
  //
  public function index(Request $request)
  {
    // Retrieve the search query parameter
    $search = $request->query('search');

    // Retrieve universities and categories for the select options
    $universities = University::all();
    $categories = CourseCategory::all();

    // Retrieve universities with search functionality
    $courses = Course::with('category', 'university')
      ->where('title', 'LIKE', "%{$search}%")
      ->paginate(10);

    //dd($courses);

    return view('courses.index', compact('courses', 'universities', 'categories'));
  }

  public function courseSave(Request $request)
  {
    // Validation rules
    $rules = [
      'title' => 'required|string|max:255',
      'description' => 'required|string|max:1000',
      'duration_type' => 'required|string|max:255',
      'duration_value' => 'required|integer|min:1',
      'level' => 'required|string|in:Beginner,Intermediate,Advanced',
      'admission_fee' => 'required|numeric|min:0',
      'course_fee' => 'required|numeric|min:0',
      'category' => 'required|exists:course_categories,id',
      'university' => 'required|exists:universities,id',
      'max_students' => 'nullable|integer|min:1',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
      'language' => 'required|string|max:255',
      'thumbnail' => $request->has('editId')
        ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        : 'required|image|mimes:jpeg,png,jpg|max:2048',
      'brochure' => 'nullable|file|mimes:pdf|max:2048',
      'status' => 'required|string|in:draft,published',
    ];

    // Validate request
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput()
        ->with('show_modal', true);
    }

    // Determine if updating or creating
    $course = $request->has('editId') && !empty($request->editId) ? Course::find($request->editId) : new Course();

    // Check if course was found for update
    if ($request->has('editId') && !empty($request->editId) && !$course) {
      return back()->with('error', 'Course not found.');
    }

    // Handle file uploads
    $course->thumbnail = $this->handleFileUpload($request, 'thumbnail', $course->thumbnail, 'courses/thumbnails');
    $course->brochure = $this->handleFileUpload($request, 'brochure', $course->brochure, 'courses/brochures');

    $course->category_id = $request->category;
    $course->university_id = $request->university;
    // Fill and save the course object
    $course->fill($request->except(['thumbnail', 'brochure', 'editId', 'category', 'university']));
    $course->save();

    // Redirect with success message
    $message =
      $request->has('editId') && !empty($request->editId)
        ? 'Course updated successfully!'
        : 'Course created successfully!';
    return back()->with('success', $message);
  }

  public function edit($id)
  {
    $course = Course::findOrFail($id);
    return response()->json($course);
  }

  private function handleFileUpload(Request $request, $field, $existingFile, $directory)
  {
    // If a new file is uploaded
    if ($request->hasFile($field)) {
      // Delete the old file if it exists
      if ($existingFile && Storage::disk('public')->exists($existingFile)) {
        Storage::disk('public')->delete($existingFile);
      }
      // Store and return the new file path
      return $request->file($field)->store($directory, 'public');
    }

    // Return existing file path if no new file is uploaded
    return $existingFile;
  }

  public function delete($id)
  {
    // Find the user by ID
    $uni = Course::findOrFail($id);
    // Check if the university has a logo and delete it if it exists
    if ($uni->brochure && Storage::disk('public')->exists($uni->brochure)) {
      Storage::disk('public')->delete($uni->brochure);
    }

    // Check if the university has a banner and delete it if it exists
    if ($uni->thumbnail && Storage::disk('public')->exists($uni->thumbnail)) {
      Storage::disk('public')->delete($uni->thumbnail);
    }
    // Delete the user record
    $uni->delete();

    // Redirect or return response
    return back()->with('success', 'Course deleted successfully.');
  }

  //this is the function for the course show case
  public function show($id)
  {
    $course = Course::findOrFail($id);
    // Fetch the related course requirements
    $courseRequirements = $course->requirements;
    // Return the view with the university data
    return view('courses.show', compact('course', 'courseRequirements'));
  }

  //this is the course requirement parts
  public function reqSave(Request $request)
  {
    // Validate the input
    $validator = Validator::make($request->all(), [
      'courseId' => 'required|exists:courses,id',
      'title' => 'required|string|max:255',
      'description' => 'nullable|string',
      'is_required' => 'nullable',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput()
        ->with('show_modal', true);
    }

    // Check if the requirement already exists and update or create
    if ($request->requirementId) {
      // Update existing requirement
      $requirement = CourseRequirement::findOrFail($request->requirementId);
      $requirement->update([
        'title' => $request->title,
        'description' => $request->description,
        'is_required' => $request->has('is_required'),
        'course_id' => $request->courseId,
      ]);
      $message = 'Requirement updated successfully!';
    } else {
      // Create new requirement
      CourseRequirement::create([
        'title' => $request->title,
        'description' => $request->description,
        'is_required' => $request->has('is_required'),
        'course_id' => $request->courseId,
      ]);
      $message = 'Requirement added successfully!';
    }

    return back()->with(['success' => $message, 'active_tab' => 2]);
  }

  //this is the function for the qualification delete
  public function reqDel($id)
  {
    $qualification = CourseRequirement::findOrFail($id);
    $qualification->delete();

    return back()->with(['success' => 'Course requirement deleted successfully!', 'active_tab' => 2]);
  }
}
