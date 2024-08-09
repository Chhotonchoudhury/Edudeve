<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  //

  public function index(Request $request)
  {
    $search = $request->query('search');

    // Retrieve users with search functionality
    $users = User::where('name', 'LIKE', "%{$search}%")
      ->orWhere('email', 'LIKE', "%{$search}%")
      ->paginate(10);

    // Count users by role
    $roleCounts = [
      'Admin' => Role::where('name', 'Admin')->exists() ? User::role('Admin')->count() : 0,
      'Staff' => Role::where('name', 'Staff')->exists() ? User::role('Staff')->count() : 0,
      'Agent' => Role::where('name', 'Agent')->exists() ? User::role('Agent')->count() : 0,
    ];

    $user = null;
    if ($request->query('edit')) {
      $user = User::find($request->query('edit'));
    }

    return view('users.index', compact('users', 'roleCounts', 'user'));
  }

  public function store(Request $request)
  {
    // Validate the request
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|confirmed|min:8',
      'phone' => 'required|string|unique:users',
      'country_code' => 'required|string|max:10',
      'country' => 'required|string',
      'city' => 'nullable|string',
      'address' => 'nullable|string',
      'status' => 'required|in:Active,Inactive',
      'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    // Handle file upload
    $profilePhotoPath = null;
    if ($request->hasFile('profile_photo_path')) {
      $file = $request->file('profile_photo_path');
      $profilePhotoPath = $file->store('profile_photos', 'public');
    }

    // Combine country code and phone number

    // Create user
    $user = User::create([
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => Hash::make($request->input('password')),
      'phone' => $request->input('phone'),
      'code' => $request->input('country_code'),
      'country' => $request->input('country'),
      'city' => $request->input('city'),
      'address' => $request->input('address'),
      'status' => $request->input('status'),
      'profile_photo_path' => $profilePhotoPath,
    ]);

    // Assign roles to the user
    $user->assignRole($request->input('role'));

    return redirect()
      ->route('users.index')
      ->with('success', 'User created successfully.');
  }

  public function edit(User $user)
  {
    // Pass the user to the view
    return view('users.index', compact('user'));
  }

  public function update(Request $request, User $user)
  {
    // Validate the request
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
      'password' => 'nullable|string|confirmed|min:8',
      'phone' => 'required|string|unique:users,phone,' . $user->id,
      'country_code' => 'required|string|max:10',
      'country' => 'required|string',
      'city' => 'nullable|string',
      'address' => 'nullable|string',
      'status' => 'required|in:Active,Inactive',
      'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    // Handle file upload
    $profilePhotoPath = $user->profile_photo_path; // Keep old photo if new one isn't uploaded
    if ($request->hasFile('profile_photo_path')) {
      // Delete old photo if exists
      if ($profilePhotoPath && \Storage::exists('public/' . $profilePhotoPath)) {
        \Storage::delete('public/' . $profilePhotoPath);
      }
      $file = $request->file('profile_photo_path');
      $profilePhotoPath = $file->store('profile_photos', 'public');
    }

    // Combine country code and phone number

    // Update user
    $user->update([
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
      'code' => $request->input('country_code'),
      'phone' => $request->input('phone'),
      'country' => $request->input('country'),
      'city' => $request->input('city'),
      'address' => $request->input('address'),
      'status' => $request->input('status'),
      'profile_photo_path' => $profilePhotoPath,
    ]);

    // Update roles
    $user->syncRoles($request->input('role'));

    return redirect()
      ->route('users.index')
      ->with('success', 'User updated successfully.');
  }

  public function destroy($id)
  {
    // Find the user by ID
    $user = User::findOrFail($id);

    // Check if the user to be deleted is the currently logged-in user
    if ($user->id === Auth::id()) {
      return redirect()
        ->route('users.index')
        ->with('error', 'You cannot delete your own account.');
    }

    // Delete the associated image from storage
    if ($user->profile_photo_path) {
      Storage::disk('public')->delete($user->profile_photo_path);
    }

    // Detach roles from the user
    $user->roles()->detach();

    // Delete the user record
    $user->delete();

    // Redirect or return response
    return redirect()
      ->route('users.index')
      ->with('success', 'User deleted successfully.');
  }
}
