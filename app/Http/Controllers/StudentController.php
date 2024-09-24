<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\LeadSource;
use App\Models\Students;
use App\Models\EnquiryStatus;
use App\Models\StudentActivity;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class StudentController extends Controller
{
  //

  // Assign colors to statuses
  private function assignStatusColors($statuses)
  {
    $colors = [
      '#655be6', // Color 1
      '#e45555', // Color 2
      '#FF6600', // Color 3
      '#cc00a9', // Color 4
      '#46cd93', // Color 5
      '#6c757d', // Color 6
      '#f9392f', // Color 7
      '#0cb5b5', // Color 8
    ];

    $statusColors = [];
    foreach ($statuses as $index => $status) {
      // Use the modulo operator to cycle through the colors
      $statusColors[$status->status_name] = $colors[$index % count($colors)];
    }

    return $statusColors;
  }

  public function index()
  {
    $leadSources = LeadSource::where('status', 'Active')->get();

    // Fetch all statuses from the enquiry_status table
    $statuses = EnquiryStatus::withCount([
      'students' => function ($query) {
        $query->where('archive_status', 0);
      },
    ])->get();
    $totalstu = $statuses->sum('students_count');

    // Assign colors to statuses
    $statusColors = $this->assignStatusColors($statuses);
    // You can pass data to the view if needed

    // Fetch paginated students
    $students = Students::where('archive_status', 0)
      ->with('enqstatus')
      ->paginate(10); // Adjust the number per page as needed
    // Fetch users with their roles
    $users = User::with('roles')->get();
    $currentUser = auth()->user();
    // dd($users);

    // You can pass data to the view if needed
    return view(
      'leads.index',
      compact('leadSources', 'statuses', 'statusColors', 'totalstu', 'students', 'users', 'currentUser')
    );
  }

  public function showStudentsByStatus($statusId)
  {
    // Fetch active lead sources
    $leadSources = LeadSource::where('status', 'Active')->get();

    // Fetch the specific status by ID
    $status = EnquiryStatus::findOrFail($statusId);

    // Get the students with the given status ID and paginate results
    $students = Students::where('enq_id', $statusId)
      ->where('archive_status', 0)
      ->with('enqstatus') // Ensure related status data is loaded
      ->paginate(10); // Adjust the number per page as needed

    // Fetch all statuses to maintain consistency in color mapping
    $statuses = EnquiryStatus::withCount([
      'students' => function ($query) {
        $query->where('archive_status', 0);
      },
    ])->get();
    $totalstu = $statuses->sum('students_count');

    // Assign colors to statuses
    $statusColors = $this->assignStatusColors($statuses);

    $users = User::with('roles')->get();
    $currentUser = auth()->user();

    // Return the view with relevant data
    return view(
      'leads.index',
      compact('leadSources', 'statuses', 'students', 'status', 'statusColors', 'totalstu', 'users', 'currentUser')
    );
  }

  public function leadSave(Request $request)
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
      'lead_source' => 'required|numeric',
      'last_degree' => 'required|string|max:255',
      'password' => 'nullable|string|confirmed|min:8',
      'active_status' => 'required|numeric',
      'Priority' => 'required|numeric',
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
      'lead_source',
      'last_degree',
      'active_status',
      'priority',
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
      $data['entry_id'] = auth()->id(); // or Auth::id()
      //add status id
      // Retrieve the first status from the enquiry_status table
      $firstStatus = EnquiryStatus::orderBy('id')->first();
      $data['enq_id'] = $firstStatus->id;
      // Create new student record
      Students::create($data);
      $message = 'Student record added successfully!';
    }

    return back()->with(['success' => $message]);
  }

  public function fetchStudent($id)
  {
    $status = Students::findOrFail($id);
    return response()->json($status);
  }

  //this is for the activity log for the leads
  public function LeadActivitysave(Request $request)
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

    return back()->with('success', $message);
  }

  //this is the lead info fetching function
  public function LeadInfo($id)
  {
    // Fetch the user data based on the ID
    $user = Students::findOrFail($id);

    // Prepare the data to return
    $data = [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
      'country' => $user->country,
      'city' => $user->city,
      'phone' => $user->phone,
      'created_at' => $user->created_at->format('F j, Y, g:i A'),
      'qualifications' => $user->last_degree,
      'address' => $user->address,
      'interests' => $user->interested_course,
      'remarks' => $user->remarks,
      'profile_photo_path' => $user->photo, // Add this line
      'is_verified' => $user->verify == 1, // Add this line
    ];

    // Return the data as JSON
    return response()->json($data);
  }

  public function getProgress($studentId)
  {
    try {
      // Fetch the student and their associated enquiry status
      $student = Students::findOrFail($studentId);
      $enquiryStatusId = $student->enq_id;

      // Fetch all enquiry statuses
      $statuses = EnquiryStatus::all();

      // Determine which statuses are covered based on the student's enquiry status ID
      $coveredStatuses = EnquiryStatus::whereIn('id', function ($query) use ($enquiryStatusId) {
        $query
          ->select('id')
          ->from('enquiry_statuses')
          ->where('id', '<=', $enquiryStatusId);
      })->get();

      // Calculate progress percentage
      $totalStatuses = $statuses->count();
      $coveredStatusesCount = $coveredStatuses->count();
      $progressPercentage = $totalStatuses > 0 ? ($coveredStatusesCount / $totalStatuses) * 100 : 0;

      // Example steps data
      $steps = $statuses->map(function ($status) use ($enquiryStatusId) {
        return [
          'name' => $status->status_name,
          'completed' => $status->id <= $enquiryStatusId,
        ];
      });

      // Return the progress data
      return response()->json([
        'progressPercentage' => $progressPercentage,
        'steps' => $steps,
      ]);
    } catch (\Exception $e) {
      // Log error and return JSON with error message
      \Log::error('Error fetching progress data: ' . $e->getMessage());
      return response()->json(['error' => 'An error occurred'], 500);
    }
  }

  public function updateProgress(Request $request, $id)
  {
    // Update progress in the database
    // For example, update progress for the given ID
    $progress = $request->input('progress');

    // Save progress to the database
    // Example code (make sure to handle validation and authorization)
    $process = Process::findOrFail($id);
    $process->progress = $progress;
    $process->save();

    return response()->json(['success' => true]);
  }

  public function getStatuses($studentId)
  {
    try {
      // Fetch the student and their associated enquiry status
      $student = Students::findOrFail($studentId);
      $enquiryStatusId = $student->enq_id;

      // Fetch all enquiry statuses
      $statuses = EnquiryStatus::all();

      // Return the statuses and the student's current enquiry status ID
      return response()->json([
        'statuses' => $statuses,
        'currentStatusId' => $enquiryStatusId,
      ]);
    } catch (\Exception $e) {
      // Log error and return JSON with error message
      \Log::error('Error fetching statuses: ' . $e->getMessage());
      return response()->json(['error' => 'An error occurred'], 500);
    }
  }

  public function updateEnquiryStatus(Request $request, $studentId)
  {
    try {
      // Fetch the student record by ID
      $student = Students::findOrFail($studentId);

      // Update the student's enquiry status
      $student->enq_id = $request->input('statusId');
      $student->save();

      // Return a success response
      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      // Log the error and return a failure response
      \Log::error('Error updating enquiry status: ' . $e->getMessage());
      return response()->json(['success' => false, 'error' => 'An error occurred while updating enquiry status'], 500);
    }
  }

  public function getLeadActivity($userId)
  {
    // Fetch activities for the given user ID
    $activities = StudentActivity::where('student_id', $userId)->get();

    // Add the full URL for attachments
    foreach ($activities as $activity) {
      if ($activity->attachment) {
        $activity->attachment = asset('storage/' . $activity->attachment);
      }
    }

    // Return activities as JSON response
    return response()->json(['activities' => $activities]);
  }

  public function fetchLeadActivity($activityId)
  {
    $activity = StudentActivity::findOrFail($activityId);
    return response()->json($activity);
  }

  public function deleteActivity($id)
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
    return back()->with('success', 'Activity deleted successfully.');
  }

  //Now make a function for verify the lead student
  public function VerifyLead($studentId)
  {
    // Find the student by ID
    $student = Students::find($studentId);

    // Check if the student exists
    if (!$student) {
      return back()->with('error', 'Student not found.');
    }

    // Update the student's verification status
    $student->verify = 1;
    $student->verified_by = Auth::id();
    $student->save();

    // Optionally, you could log this action or perform other tasks here

    // Redirect back with a success message
    return back()->with('success', 'Lead Student successfully verified.');
  }

  //update the reffere to part
  public function updateReferTo(Request $request, $id)
  {
    $request->validate([
      'refer_to' => 'nullable|exists:users,id', // Validate that the ID exists in the users table
    ]);

    $student = Students::findOrFail($id);
    $student->refer_to = $request->input('refer_to');
    $student->save();

    return back()->with('success', 'Student assigned successfully.');
  }

  public function LeadToStudent(Request $request, $id)
  {
    // Retrieve the student record using the provided ID
    $student = Students::find($id);

    // Check if the student record exists
    if (!$student) {
      return back()->with('error', 'Student Not Found.');
    }

    // Check the 'verify' status of the student
    if ($student->verify == 1) {
      // Update the 'archive_status' to 1
      $student->archive_status = 1;
      $student->save();

      return back()->with('success', 'Lead Transfer to Student.');
    }

    return back()->with('error', 'Student Should be must verified ! .');
  }
}
