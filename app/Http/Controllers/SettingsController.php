<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Companyinfo;
use App\Models\EnquiryStatus;
use App\Models\EmgsStatus;
use App\Models\PaymentStatus;
use App\Models\ProcessStatus;
use App\Models\CourseCategory;
use App\Models\LeadSource;
use App\Models\ActivityStatus;
use App\Models\EmailSetting;
class SettingsController extends Controller
{
  //
  public function index()
  {
    $companyInfo = Companyinfo::first();
    $EnqStatus = EnquiryStatus::all();
    $EMGSStatus = EmgsStatus::all();
    $PaymentStatus = PaymentStatus::all();
    $processStatuses = ProcessStatus::all();
    $courseCategory = CourseCategory::all();
    $leadSources = LeadSource::all();
    $activityStatuses = ActivityStatus::all();
    $emails = EmailSetting::first();
    // Set the session variable
    return view(
      'setting.index',
      compact(
        'companyInfo',
        'EnqStatus',
        'EMGSStatus',
        'PaymentStatus',
        'processStatuses',
        'courseCategory',
        'leadSources',
        'activityStatuses',
        'emails'
      )
    );
  }

  public function companyInfo(Request $request)
  {
    // Validate the request
    // Handle validation error by catching exception
    $validatedData = $request->validate([
      'company_name' => 'required|string|max:255',
      'company_moto' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'required|string|max:15',
      'address' => 'required|string',
      'description' => 'required|string',
    ]);

    // Check if any company info exists
    $companyInfo = CompanyInfo::first();

    if ($companyInfo) {
      // Update the existing company info
      $companyInfo->update($validatedData);
      $message = 'Company information updated successfully.';
    } else {
      // Create new company info
      CompanyInfo::create($validatedData);
      $message = 'Company information created successfully.';
    }

    // Redirect back with a success message
    return back()->with(['success' => $message, 'active_tab' => 1, 'cp_tab' => 1]); // Specify the active tab
  }

  public function uploadLogos(Request $request)
  {
    // Validate the request
    $validatedData = $request->validate([
      'small_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'wide_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
    ]);

    // Check if any company info exists
    $companyInfo = CompanyInfo::first();

    if ($companyInfo) {
      // Update the existing logos
      if ($request->hasFile('small_logo')) {
        // Delete the old small logo if exists
        if ($companyInfo->small_logo && Storage::disk('public')->exists($companyInfo->small_logo)) {
          Storage::disk('public')->delete($companyInfo->small_logo);
        }
        // Store the new small logo
        $smallLogoPath = $request->file('small_logo')->store('logos', 'public');
        $companyInfo->update(['small_logo' => $smallLogoPath]);
      }

      if ($request->hasFile('wide_logo')) {
        // Delete the old wide logo if exists
        if ($companyInfo->wide_logo && Storage::disk('public')->exists($companyInfo->wide_logo)) {
          Storage::disk('public')->delete($companyInfo->wide_logo);
        }
        // Store the new wide logo
        $wideLogoPath = $request->file('wide_logo')->store('logos', 'public');
        $companyInfo->update(['wide_logo' => $wideLogoPath]);
      }

      if ($request->hasFile('favicon')) {
        // Delete the old favicon if exists
        if ($companyInfo->favicon && Storage::disk('public')->exists($companyInfo->favicon)) {
          Storage::disk('public')->delete($companyInfo->favicon);
        }
        // Store the new favicon
        $faviconPath = $request->file('favicon')->store('logos', 'public');
        $companyInfo->update(['favicon' => $faviconPath]);
      }

      $message = 'Logos updated successfully.';
    } else {
      // Create new company info with logos
      $companyInfo = new CompanyInfo();

      if ($request->hasFile('small_logo')) {
        $companyInfo->small_logo = $request->file('small_logo')->store('logos', 'public');
      }

      if ($request->hasFile('wide_logo')) {
        $companyInfo->wide_logo = $request->file('wide_logo')->store('logos', 'public');
      }

      if ($request->hasFile('favicon')) {
        $companyInfo->favicon = $request->file('favicon')->store('logos', 'public');
      }

      $companyInfo->save();
      $message = 'Logos created successfully.';
    }

    // Redirect back with a success message and active tab
    return back()->with(['success' => $message, 'active_tab' => 1, 'cp_tab' => 2]); // Pass the active tab back to the view
  }

  public function updateSocialLinks(Request $request)
  {
    // Validate the request
    $validatedData = $request->validate([
      'twitter' => 'nullable|url',
      'facebook' => 'nullable|url',
      'google' => 'nullable|url',
      'linkedin' => 'nullable|url',
      'instagram' => 'nullable|url',
      'quora' => 'nullable|url',
    ]);

    // Find or create the CompanyInfo instance
    $companyInfo = CompanyInfo::firstOrNew([]);

    // Update or create the social links
    $socialLinks = [
      'twitter' => $request->input('twitter'),
      'facebook' => $request->input('facebook'),
      'google' => $request->input('google'),
      'linkedin' => $request->input('linkedin'),
      'instagram' => $request->input('instagram'),
      'quora' => $request->input('quora'),
    ];

    $companyInfo->social_links = $socialLinks;
    $companyInfo->save();

    // Redirect back with a success message
    return back()->with(['success' => 'Social links updated successfully.', 'active_tab' => 1, 'cp_tab' => 3]);
  }
  /* This is the Enquiry status part */
  public function enqSave(Request $request)
  {
    $request->validate([
      'statusName' => 'required|string|max:255',
      'statusDescription' => 'required|string|max:500',
    ]);

    $data = [
      'status_name' => $request->input('statusName'),
      'status_description' => $request->input('statusDescription'),
    ];

    if ($request->has('statusId') && $request->input('statusId')) {
      // Update existing record
      $status = EnquiryStatus::findOrFail($request->input('statusId'));
      $status->update($data);
      $message = 'Sataus updated successfully !';
    } else {
      // Create new record
      EnquiryStatus::create($data);
      $message = 'Sataus added successfully !';
    }

    return back()->with(['success' => $message, 'active_tab' => 2]);
  }

  public function fetchStatus($id)
  {
    $status = EnquiryStatus::findOrFail($id);
    return response()->json($status);
  }

  public function deletStatus($id)
  {
    // Find the user by ID
    $user = EnquiryStatus::findOrFail($id);

    // Delete the user record
    $user->delete();

    // Redirect or return response
    return back()->with(['success' => 'Enquiry deleted successfully.', 'active_tab' => 2]);
  }

  /* this is the functions for the emgs status parts */

  public function emgsSave(Request $request)
  {
    $request->validate([
      'EMGSstatusName' => 'required|string|max:255',
      'EMGSstatusDescription' => 'required|string|max:500',
    ]);

    $data = [
      'EMGstatus_name' => $request->input('EMGSstatusName'),
      'EMGstatus_description' => $request->input('EMGSstatusDescription'),
    ];

    if ($request->has('statusEMGId') && $request->input('statusEMGId')) {
      // Update existing record
      $status = EmgsStatus::findOrFail($request->input('statusEMGId'));
      $status->update($data);
      $message = 'Sataus updated successfully !';
    } else {
      // Create new record
      EmgsStatus::create($data);
      $message = 'Sataus added successfully !';
    }

    return back()->with(['success' => $message, 'active_tab' => 2]);
  }

  public function fetchemgsStatus($id)
  {
    $status = EmgsStatus::findOrFail($id);
    return response()->json($status);
  }

  public function deletemgsStatus($id)
  {
    // Find the user by ID
    $user = EmgsStatus::findOrFail($id);

    // Delete the user record
    $user->delete();

    // Redirect or return response
    return back()->with(['success' => 'Status deleted successfully.', 'active_tab' => 2]);
  }

  /*this is the function of the payment status */
  public function paymentSave(Request $request)
  {
    $request->validate([
      'PaystatusName' => 'required|string|max:255',
      'PaystatusDescription' => 'required|string|max:500',
    ]);

    $data = [
      'Paystatus_name' => $request->input('PaystatusName'),
      'Paystatus_description' => $request->input('PaystatusDescription'),
    ];

    if ($request->has('statusPayId') && $request->input('statusPayId')) {
      // Update existing record
      $status = PaymentStatus::findOrFail($request->input('statusPayId'));
      $status->update($data);
      $message = 'Status updated successfully!';
    } else {
      // Create new record
      PaymentStatus::create($data);
      $message = 'Status added successfully!';
    }

    return back()->with(['success' => $message, 'active_tab' => 2]);
  }

  public function fetchPaymentStatus($id)
  {
    $status = PaymentStatus::findOrFail($id);
    return response()->json($status);
  }

  public function deletePaymentStatus($id)
  {
    $status = PaymentStatus::findOrFail($id);
    $status->delete();

    return back()->with(['success' => 'Status deleted successfully.', 'active_tab' => 2]);
  }

  /*this is the function of the processing status */
  public function processSave(Request $request)
  {
    $request->validate([
      'ProcessStatusName' => 'required|string|max:255',
      'ProcessStatusDescription' => 'required|string|max:500',
    ]);

    $data = [
      'Pstatus_name' => $request->input('ProcessStatusName'),
      'Pstatus_description' => $request->input('ProcessStatusDescription'),
    ];

    if ($request->has('statusProcessId') && $request->input('statusProcessId')) {
      // Update existing record
      $status = ProcessStatus::findOrFail($request->input('statusProcessId'));
      $status->update($data);
      $message = 'Status updated successfully!';
    } else {
      // Create new record
      ProcessStatus::create($data);
      $message = 'Status added successfully!';
    }

    return back()->with(['success' => $message, 'active_tab' => 2]);
  }

  public function fetchProcessStatus($id)
  {
    $status = ProcessStatus::findOrFail($id);
    return response()->json($status);
  }

  public function deleteProcessStatus($id)
  {
    $status = ProcessStatus::findOrFail($id);
    $status->delete();

    return back()->with(['success' => 'Status deleted successfully.', 'active_tab' => 2]);
  }

  /* this is the functions for the course category part */

  public function courseCatSave(Request $request)
  {
    $request->validate([
      'CategoryName' => 'required|string|max:255',
      'CategoryDescription' => 'nullable|string|max:255',
      'CategoryStatus' => 'required|in:Active,Inactive',
      'profilePhoto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
      // Validate the image
    ]);

    $categoryId = $request->input('categoryId');
    $photoPath = null;

    if ($request->hasFile('profilePhoto')) {
      $photoPath = $request->file('profilePhoto')->store('course_category_photos', 'public');
    }

    if ($categoryId) {
      // Update existing Course Category
      $category = CourseCategory::findOrFail($categoryId);

      // Delete old photo if a new one is uploaded
      if ($photoPath && $category->profile_photo_path) {
        Storage::disk('public')->delete($category->profile_photo_path);
      }

      $category->update([
        'Category_name' => $request->input('CategoryName'),
        'Category_description' => $request->input('CategoryDescription'),
        'status' => $request->input('CategoryStatus'),
        'profile_photo_path' => $photoPath ? $photoPath : $category->profile_photo_path,
      ]);
      $message = 'Category updated successfully !';
    } else {
      // Create new Course Category
      CourseCategory::create([
        'Category_name' => $request->input('CategoryName'),
        'Category_description' => $request->input('CategoryDescription'),
        'status' => $request->input('CategoryStatus'),
        'profile_photo_path' => $photoPath,
      ]);
      $message = 'Category created successfully !';
    }

    return back()->with(['success' => $message, 'active_tab' => 3]);
  }

  public function courseCatDestroy($id)
  {
    $category = CourseCategory::findOrFail($id);

    // Delete associated photo
    if ($category->profile_photo_path) {
      Storage::disk('public')->delete($category->profile_photo_path);
    }

    $category->delete();

    return back()->with(['success' => 'Course category deleted ', 'active_tab' => 3]);
  }

  public function courseCatShow($id)
  {
    $category = CourseCategory::findOrFail($id);
    return response()->json($category);
  }

  /*this is the lead sources code sections */
  public function leadSourceSave(Request $request)
  {
    $request->validate([
      'SourceName' => 'required|string|max:255',
      'SourceDescription' => 'required|string|max:255',
      'SourceStatus' => 'required|in:Active,Inactive',
    ]);

    $sourceId = $request->input('sourceId');

    if ($sourceId) {
      $leadSource = LeadSource::findOrFail($sourceId);
      $leadSource->Source_name = $request->input('SourceName');
      $leadSource->Source_description = $request->input('SourceDescription');
      $leadSource->status = $request->input('SourceStatus');
      $leadSource->save();
      return redirect()
        ->back()
        ->with(['success' => 'Lead source updated successfully.', 'active_tab' => 4]);
    } else {
      LeadSource::create([
        'Source_name' => $request->input('SourceName'),
        'Source_description' => $request->input('SourceDescription'),
        'status' => $request->input('SourceStatus'),
      ]);
      return back()->with(['success' => 'Lead source added successfully.', 'active_tab' => 4]);
    }
  }

  public function leadSourceDelete($id)
  {
    LeadSource::destroy($id);
    return back()->with(['success' => 'Lead source deleted successfully.', 'active_tab' => 4]);
  }

  public function leadSourceShow($id)
  {
    $leadSource = LeadSource::findOrFail($id); // Ensure correct model name
    return response()->json($leadSource);
  }

  //this is the code for the activity sections
  public function activityStatusSave(Request $request)
  {
    $request->validate([
      'ActivityName' => 'required|string|max:255',
      'ActivityDescription' => 'required|string|max:255',
      'ActivityStatus' => 'required|in:Active,Inactive',
    ]);

    $statusId = $request->input('ActivitystatusId');

    if ($statusId) {
      // Update existing Activity Status
      $status = ActivityStatus::findOrFail($statusId);
      $status->update([
        'Activity_name' => $request->input('ActivityName'),
        'Activity_description' => $request->input('ActivityDescription'),
        'status' => $request->input('ActivityStatus'),
      ]);
      $message = 'Activity Status updated successfully!';
    } else {
      // Create new Activity Status
      ActivityStatus::create([
        'Activity_name' => $request->input('ActivityName'),
        'Activity_description' => $request->input('ActivityDescription'),
        'status' => $request->input('ActivityStatus'),
      ]);
      $message = 'Activity Status created successfully!';
    }

    return back()->with(['success' => $message, 'active_tab' => 5]);
  }

  public function activityStatusDestroy($id)
  {
    $status = ActivityStatus::findOrFail($id);
    $status->delete();
    return back()->with(['success' => 'Activity Status deleted', 'active_tab' => 5]);
  }

  public function activityStatusShow($id)
  {
    $status = ActivityStatus::findOrFail($id);
    return response()->json($status);
  }

  /*email setting update */

  public function emailupdate(Request $request)
  {
    $request->validate([
      'smtp_host' => 'required|string',
      'smtp_port' => 'required|string',
      'smtp_user' => 'required|string',
      'smtp_password' => 'required|string',
      'smtp_encryption' => 'required|string',
      'sender_name' => 'required|string',
      'sender_email' => 'required|email',
    ]);

    $settings = EmailSetting::first();
    if (!$settings) {
      $settings = new EmailSetting();
    }

    $settings->fill($request->all());
    $settings->save();

    return back()->with(['success' => 'Settings updated successfully.', 'active_tab' => 6]);
  }
}
