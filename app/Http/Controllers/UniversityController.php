<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
  //
  public function index(Request $request)
  {
    // Retrieve the search query parameter
    $search = $request->query('search');

    // Retrieve universities with search functionality
    $universities = University::where('name', 'LIKE', "%{$search}%")->paginate(10);

    return view('universities.index', compact('universities'));
  }

  public function store(Request $request)
  {
    // Validation rules
    $rules = [
      'name' => 'required|string|max:255',
      'acronym' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'country' => 'required|string|max:255',
      'country_code' => 'required|string|max:255',
      'city' => 'required|string|max:255',
      'state' => 'required|string|max:255',
      'postal_code' => 'required|string|max:20',
      'address' => 'required|string|max:255',
      'description' => 'nullable|string|max:1000',
      'phone' => 'required|string|max:20',
      'website' => 'required|url|max:255',
      'is_active' => 'required|boolean',
      'mission_statement' => 'nullable|string|max:1000',
      'vision_statement' => 'nullable|string|max:1000',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];

    // Validate request
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput()
        ->with('show_modal', true);
    }

    // Debugging information
    // \Log::info('Request data:', $request->all());

    // Determine if updating or creating
    $university =
      $request->has('editId') && !empty($request->editId) ? University::find($request->editId) : new University();

    // Check if university was found for update
    if ($request->has('editId') && !empty($request->editId) && !$university) {
      // \Log::error('University not found for ID:', ['id' => $request->editId]);
      return back()->with('error', 'University not found.');
    }

    // Handle file uploads
    $university->logo = $this->handleFileUpload($request, 'logo', $university->logo, 'universities/logos');
    $university->banner = $this->handleFileUpload($request, 'banner', $university->banner, 'universities/banners');

    // Exclude editId from fillable attributes
    $data = $request->except(['logo', 'banner', 'editId']);

    // Fill and save the university object
    $university->fill($data);
    $university->save();

    // Redirect with success message
    $message =
      $request->has('editId') && !empty($request->editId)
        ? 'University updated successfully!'
        : 'University created successfully!';
    return back()->with('success', $message);
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

  public function edit($id)
  {
    $university = University::findOrFail($id);
    return response()->json($university);
  }

  public function delete($id)
  {
    // Find the user by ID
    $uni = University::findOrFail($id);
    // Check if the university has a logo and delete it if it exists
    if ($uni->logo && Storage::disk('public')->exists($uni->logo)) {
      Storage::disk('public')->delete($uni->logo);
    }

    // Check if the university has a banner and delete it if it exists
    if ($uni->banner && Storage::disk('public')->exists($uni->banner)) {
      Storage::disk('public')->delete($uni->banner);
    }
    // Delete the user record
    $uni->delete();

    // Redirect or return response
    return back()->with('success', 'University deleted successfully.');
  }

  //this is the function for the view page of the university
  public function show($id)
  {
    // Find the university by ID or fail with a 404 error
    $university = University::findOrFail($id);

    // Return the view with the university data
    return view('universities.show', compact('university'));
  }
}
