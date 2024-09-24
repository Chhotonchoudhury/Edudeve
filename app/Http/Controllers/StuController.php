<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Students;
use App\Models\StudentActivity;
use App\Models\StudentQualification;

use Illuminate\Http\Request;

class StuController extends Controller
{
  //index function
  public function index()
  {
    // Fetch paginated students
    $students = Students::where('archive_status', 1)->paginate(10); // Adjust the number per page as needed
    // Fetch users with their role

    // You can pass data to the view if needed
    return view('leads.students', compact('students'));
  }
  //this is function for student save
  public function stuSave(Request $request)
  {
    // Validate the incoming request
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:students,email,' . $request->input('studentId'),
      'country' => 'required|string|max:255',
      'country_code' => 'required|numeric',
      'phone' => 'required|numeric|unique:students,phone,' . $request->input('studentId'),
      'city' => 'required|string|max:255',
      'address' => 'required|string',
      'dob' => 'nullable|date',
      'last_degree' => 'required|string|max:255',
      'password' => 'nullable|string|confirmed|min:8',
      'active_status' => 'required|numeric',
      'interested_course' => 'required|string|max:255',
      'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
      'remarks' => 'nullable|string',
    ]);

    $data = $request->only([
      'name',
      'email',
      'country',
      'country_code',
      'phone',
      'city',
      'address',
      'dob',
      'last_degree',
      'active_status',
      'interested_course',
      'photo',
      'remarks',
    ]);

    // Handle password separately
    if ($request->filled('password')) {
      $data['password'] = bcrypt($request->input('password'));
    }

    // Handle photo upload
    if ($request->hasFile('photo')) {
      $photo = $request->file('photo');
      $photoPath = $photo->store('photos', 'public');

      // Add the photo path to the data array
      $data['photo'] = $photoPath;

      // Delete the old photo if updating
      if ($request->has('studentId') && $request->input('studentId')) {
        $student = Students::findOrFail($request->input('studentId'));
        if ($student->photo && \Storage::disk('public')->exists($student->photo)) {
          \Storage::disk('public')->delete($student->photo);
        }
      }
    }

    if ($request->has('studentId') && $request->input('studentId')) {
      // Update existing student record
      $student = Students::findOrFail($request->input('studentId'));
      $student->update($data);
      $message = 'Student record updated successfully!';
    } else {
      // Generate a unique 6-digit student ID
      do {
        $studentId = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
      } while (Students::where('student_id', $studentId)->exists());

      $data['student_id'] = $studentId;

      // Set archive_status to 1 and entry_id to the authenticated user
      $data['archive_status'] = 1;
      $data['entry_id'] = auth()->id(); // or Auth::id()

      //add status id
      // Create new student record
      Students::create($data);
      $message = 'Student record added successfully!';
    }

    return back()->with(['success' => $message]);
  }

  public function stuDelete($studentId)
  {
    // Find the student by their ID
    $student = Students::findOrFail($studentId);

    // Check if the student has a photo and delete it from storage
    if ($student->photo && \Storage::disk('public')->exists($student->photo)) {
      \Storage::disk('public')->delete($student->photo);
    }

    // Delete the student record
    $student->delete();

    // Return a success message
    return back()->with(['success' => 'Student record deleted successfully!']);
  }

  //this is the function for show the student profile
  public function show($id)
  {
    // Find the university by ID or fail with a 404 error
    $student = Students::findOrFail($id);
    $qualifications = StudentQualification::where('student_id', $id)->get();
    $activities = StudentActivity::with('user') // Eager load the user relationship
      ->where('student_id', $id)
      ->orderBy('activity_date', 'desc')
      ->get();
    // Return the view with the university data
    return view('leads.show', compact('student', 'qualifications', 'activities'));
  }

  //this is the function for the qualification save
  public function Quasave(Request $request)
  {
    $request->validate([
      'degree' => 'required|string|max:255',
      'passing_year' => 'required|integer',
      'cgpa' => 'required|numeric',
      'institution' => 'required|string|max:255',
    ]);

    // Get the ID from the request, if present
    $id = $request->input('qualification_id');

    if ($id) {
      // Update existing qualification
      $qualification = StudentQualification::findOrFail($id);
      $qualification->update($request->only(['degree', 'passing_year', 'cgpa', 'institution']));
      $message = 'Student qualification updated successfully!';
    } else {
      // Create new qualification
      StudentQualification::create([
        'student_id' => $request->student_id, // Make sure to pass student_id from the form
        'degree' => $request->degree,
        'passing_year' => $request->passing_year,
        'cgpa' => $request->cgpa,
        'institution' => $request->institution,
      ]);

      $message = 'Student qualification added successfully!';
    }

    return back()->with(['success' => $message]);
  }

  //this is the function for the qualification delete
  public function Qdel($id)
  {
    $qualification = StudentQualification::findOrFail($id);
    $qualification->delete();

    return back()->with('success', 'Qualification deleted successfully!');
  }

  public function updateStudent(Request $request)
  {
    // Validate the incoming request
    $request->validate([
      'studentId' => 'required|exists:students,id', // Ensure the student ID is provided and exists
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:students,email,' . $request->input('studentId'),
      'country' => 'required|string|max:255',
      'country_code' => 'required|numeric',
      'phone' => 'required|numeric|unique:students,phone,' . $request->input('studentId'),
      'city' => 'required|string|max:255',
      'address' => 'required|string',
      'dob' => 'nullable|date',
      'last_degree' => 'required|string|max:255',
      'password' => 'nullable|string|confirmed|min:8',
      'active_status' => 'required|numeric',
      'interested_course' => 'required|string|max:255',
      'interested_category' => 'required|string|max:255', // New field
      'passport_no' => 'required|string|max:255', // New field
      'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
      'remarks' => 'nullable|string',
    ]);

    // Prepare the data for updating the record
    $data = $request->only([
      'name',
      'email',
      'country',
      'country_code',
      'phone',
      'city',
      'address',
      'dob',
      'last_degree',
      'active_status',
      'interested_course',
      'interested_category', // New field
      'passport_no', // New field
      'photo',
      'remarks',
    ]);

    // Handle password update if it's provided
    if ($request->filled('password')) {
      $data['password'] = bcrypt($request->input('password'));
    }

    // Handle photo upload
    if ($request->hasFile('photo')) {
      $photo = $request->file('photo');
      $photoPath = $photo->store('photos', 'public');

      // Add the new photo path to the data array
      $data['photo'] = $photoPath;

      // Delete the old photo if it exists
      $student = Students::findOrFail($request->input('studentId'));
      if ($student->photo && \Storage::disk('public')->exists($student->photo)) {
        \Storage::disk('public')->delete($student->photo);
      }
    }

    // Update the student record
    $student = Students::findOrFail($request->input('studentId'));
    $student->update($data);

    return back()->with(['success' => 'Student record updated successfully!']);
  }

  //this is the activity
  //this is for the activity log for the leads
  public function Activitysave(Request $request)
  {
    // Validation rules
    $validator = Validator::make($request->all(), [
      'student_id' => 'required|integer',
      'activity_type' => 'required|string|max:255',
      'activity_date' => 'required|date',
      // 'activity_time' => 'required|date_format:H:i',
      'contact_person' => 'nullable|string|max:255',
      'contact_number' => 'nullable|string|max:20',
      'result' => 'required|string|max:255',
      'status' => 'required|in:Pending,Completed,Cancelled',
      'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
      'direction' => 'required|in:incoming,outgoing',
      'remarks' => 'nullable|string',
      'entry_id' => 'required|integer',
      'updated_id' => 'required|integer',
      'activityid' => 'nullable|exists:student_activities,id', // Check if it exists for update
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput()
        ->with('show_modal', true);
    }

    $userId = Auth::id(); // Get the ID of the currently authenticated user

    $activityData = $request->only([
      'student_id',
      'activity_type',
      'activity_date',
      'activity_time',
      'contact_person',
      'contact_number',
      'result',
      'status',
      'attachment',
      'direction',
      'remarks',
      'entry_id',
      'updated_id',
    ]);

    // Handle file attachment
    if ($request->hasFile('attachment')) {
      // If an attachment exists, handle it
      $file = $request->file('attachment');
      $filePath = $file->store('attachments', 'public'); // Store file and get path
      $activityData['attachment'] = $filePath;
    }

    if ($request->has('activityid') && !empty($request->input('activityid'))) {
      // Update existing activity
      // dd($request->input('activityid'));
      $activity = StudentActivity::find($request->input('activityid'));

      if (!$activity) {
        return redirect()
          ->back()
          ->with('error', 'Activity not found.');
      }
      // Delete old attachment if it exists and a new one is uploaded
      if ($request->hasFile('attachment') && $activity->attachment) {
        Storage::disk('public')->delete($activity->attachment);
      }

      $activityData['updated_id'] = $userId; // Set the user ID who is updating
      $activity->update($activityData);
      $message = 'Activity updated successfully.';
    } else {
      // Create new activity
      $activityData['entry_id'] = $userId; // Set the user ID who is creating
      StudentActivity::create($activityData);
      $message = 'Activity created successfully.';
    }

    return back()->with(['success' => $message, 'active_tab' => 2]);
  }

  public function Activitydelete($id)
  {
    // Find the activity by ID
    $activity = StudentActivity::find($id);

    if (!$activity) {
      // If the activity is not found, redirect back with an error message
      return back()->with('error', 'Activity not found.');
    }

    // Check if there is an attachment and delete it
    if ($activity->attachment) {
      // Delete the file from storage
      Storage::disk('public')->delete($activity->attachment);
    }

    // Delete the activity record
    $activity->delete();

    // Redirect back with a success message
    return back()->with(['success' => 'Activity deleted successfully.', 'active_tab' => 2]);
  }
}
