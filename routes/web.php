<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StuController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\CourseController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Page Route

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
  Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

  // locale
  Route::get('lang/{locale}', [LanguageController::class, 'swap']);

  // pages
  Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

  // authentication
  Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
  Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

  Route::get('/', [HomePage::class, 'index'])->name('pages-home');

  Route::get('/dashboard', function () {
    return view('dashboard.index');
  })->name('dashboard');

  //roles & permissions routes sections
  Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
  Route::get('roles-permissions/{id}/edit', [RolePermissionController::class, 'edit'])->name('roles-permissions.edit');
  Route::put('roles-permissions/{id}', [RolePermissionController::class, 'update'])->name('roles-permissions.update');
  //user Management system

  Route::resource('users', UserController::class);

  //settings part
  Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
  Route::put('/company-info', [SettingsController::class, 'companyInfo'])->name('settings.company.info');
  Route::post('/company-upload-logos', [SettingsController::class, 'uploadLogos'])->name(
    'setting.company.upload.logos'
  );
  // In your web.php (routes file)
  Route::post('/update-social-links', [SettingsController::class, 'updateSocialLinks'])->name('update.social.links');

  //this is for status
  // Route for saving (both insert and update)
  Route::post('/enquiry-status/save', [SettingsController::class, 'enqSave'])->name('enquiry-status.save');
  // web.php (routes file)
  Route::get('/enquiry-status/{id}', [SettingsController::class, 'fetchStatus'])->name('enquiry-status.fetch');
  Route::post('/enquiry-status-delete/{id}', [SettingsController::class, 'deletStatus'])->name('enquiry-status.delete');

  //this routes for the emgs status
  Route::post('/emgs-status/save', [SettingsController::class, 'emgsSave'])->name('emgs-status.save');
  Route::get('/emgs-status/{id}', [SettingsController::class, 'fetchemgsStatus'])->name('emgs-status.fetch');
  Route::post('/emgs-status-delete/{id}', [SettingsController::class, 'deletemgsStatus'])->name('emgs-status.delete');

  // Routes for the PaymentStatus
  Route::post('/payment-status/save', [SettingsController::class, 'paymentSave'])->name('payment-status.save');
  Route::get('/payment-status/{id}', [SettingsController::class, 'fetchPaymentStatus'])->name('payment-status.fetch');
  Route::post('/payment-status-delete/{id}', [SettingsController::class, 'deletePaymentStatus'])->name(
    'payment-status.delete'
  );

  // Routes for the ProcessStatus

  Route::post('/process-status/save', [SettingsController::class, 'processSave'])->name('process-status.save');
  Route::get('/process-status/{id}', [SettingsController::class, 'fetchProcessStatus'])->name('process-status.fetch');
  Route::post('/process-status-delete/{id}', [SettingsController::class, 'deleteProcessStatus'])->name(
    'process-status.delete'
  );

  //routes for course category
  // Course Category routes
  Route::post('/course-category/save', [SettingsController::class, 'courseCatSave'])->name('course-category.save');
  Route::delete('/course-category/{id}', [SettingsController::class, 'courseCatDestroy'])->name(
    'course-category.delete'
  );
  Route::get('/course-category/{id}', [SettingsController::class, 'courseCatShow'])->name('course-category.show');
  //this is the lead source

  Route::post('/lead-source/save', [SettingsController::class, 'leadSourceSave'])->name('lead-source.save');
  Route::delete('/lead-source/{id}', [SettingsController::class, 'leadSourceDelete'])->name('lead-source.delete');
  Route::get('/lead-source/{id}', [SettingsController::class, 'leadSourceShow'])->name('lead-source.show');

  //this is the routes for the activity code
  Route::post('/activity-status/save', [SettingsController::class, 'activityStatusSave'])->name('activity-status.save');
  Route::delete('/activity-status/{id}', [SettingsController::class, 'activityStatusDestroy'])->name(
    'activity-status.delete'
  );
  Route::get('/activity-status/{id}', [SettingsController::class, 'activityStatusShow'])->name('activity-status.show');

  //this is the email setup
  Route::post('/email-settings', [SettingsController::class, 'emailupdate'])->name('email-settings.update');

  //this is the leads routes
  Route::get('/leads', [StudentController::class, 'index'])->name('leads.index');
  Route::get('/leads/{id}', [StudentController::class, 'showStudentsByStatus'])->name('leads.show');
  Route::get('/lead-student/{id}', [StudentController::class, 'fetchStudent'])->name('lead-student.fetch');

  Route::post('/leads/save', [StudentController::class, 'leadSave'])->name('leads.save');
  Route::post('/leads/activity', [StudentController::class, 'LeadActivitysave'])->name('leads.activity');
  Route::get('/lead-info/{id}', [StudentController::class, 'LeadInfo']);

  // Route to get progress data
  Route::get('/get-progress/{id}', [StudentController::class, 'getProgress']);
  // Route to update progress data (for the final submit)
  Route::post('/update-progress/{id}', [StudentController::class, 'updateProgress']);
  Route::get('/get-eq-statuses/{studentId}', [StudentController::class, 'getStatuses']);
  Route::post('/update-enquiry-status/{studentId}', [StudentController::class, 'updateEnquiryStatus'])->name(
    'update-enquiry-status'
  );
  Route::get('/get-lead-activity/{studentId}', [StudentController::class, 'getLeadActivity']);
  Route::get('/get-update-activity/{activityId}', [StudentController::class, 'fetchLeadActivity']);
  Route::delete('/lead-activity-delete/{id}', [StudentController::class, 'deleteActivity'])->name('activity.delete');
  Route::post('/lead-verify/{studentId}', [StudentController::class, 'VerifyLead']);
  Route::post('/lead-send-to-student/{studentId}', [StudentController::class, 'LeadToStudent']);
  Route::put('/lead/{id}/update-refer-to', [StudentController::class, 'updateReferTo'])->name('students.updateReferTo');

  // web.php (routes file)
  Route::get('/enquiry-status/{id}', [SettingsController::class, 'fetchStatus'])->name('enquiry-status.fetch');
  Route::post('/enquiry-status-delete/{id}', [SettingsController::class, 'deletStatus'])->name('enquiry-status.delete');

  //this is for the university parts
  Route::get('/universities', [UniversityController::class, 'index'])->name('university.index');
  // For storing or updating university data
  Route::post('/university/store', [UniversityController::class, 'store'])->name('university.store');
  Route::get('/university/{id}', [UniversityController::class, 'edit'])->name('university.edit');
  Route::delete('/university-delete/{id}', [UniversityController::class, 'delete'])->name('university.delete');
  Route::get('/university-profile/{id}', [UniversityController::class, 'show'])->name('university.show');

  //this routes for the courses related routes
  Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
  Route::post('/course/save', [CourseController::class, 'courseSave'])->name('course.store');
  Route::get('/course/{id}', [CourseController::class, 'edit'])->name('course.edit');
  Route::delete('/course-delete/{id}', [CourseController::class, 'delete'])->name('course.delete');
  Route::get('/course-profile/{id}', [CourseController::class, 'show'])->name('course.show');
  Route::post('/courese/requirement', [CourseController::class, 'reqSave'])->name('course.requirement');
  Route::delete('/course-req-delete/{id}', [CourseController::class, 'reqDel']);
  //this is the students list here ok please
  Route::get('/student', [StuController::class, 'index'])->name('student.index');
  Route::post('/student/save', [StuController::class, 'stuSave'])->name('student.save');
  Route::delete('/student-delete/{id}', [StuController::class, 'stuDelete'])->name('student.delete');
  Route::get('/student-profile/{id}', [StuController::class, 'show'])->name('student.show');
  Route::post('/qualifications/{id?}', [StuController::class, 'Quasave'])->name('qualifications.save');
  Route::delete('/qualification-delete/{id}', [StuController::class, 'Qdel'])->name('qualifications.destroy');
  Route::post('/student/update', [StuController::class, 'updateStudent'])->name('student.update');
  Route::post('/student/activity', [StuController::class, 'Activitysave'])->name('student.activity');
  Route::delete('/student-activity-delete/{id}', [StuController::class, 'Activitydelete']);
});

// Fallback route
Route::fallback(function () {
  return redirect()->route('pages-misc-error');
});
