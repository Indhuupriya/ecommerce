<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function settings()
    {
        // Retrieve existing settings
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'meta_key' => 'required|string|max:255',
            'meta_desc' => 'required|string',
            'favicon' => 'nullable|image|mimes:png,jpg,ico|max:1024',
        ]);

        foreach ($validatedData as $key => $value) {
            if ($key !== 'favicon') {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            Setting::updateOrCreate(['key' => 'favicon'], ['value' => $faviconPath]);
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
    public function profile()
    {
        $userProfile = UserProfile::where('user_id', Auth::id())->first();
        $users = User::where('id', Auth::id())->first();
       
        if (!$userProfile) {
            // Create a new profile for the user if it doesn't exist
            $userProfile = new UserProfile();
            $userProfile->user_id = Auth::id();
            $userProfile->save();
        }
        return view('profile', compact('userProfile','users'));
    }

    public function updateprofile(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for profile image
        ]);
    
        $user = Auth::user();
        $userProfile = UserProfile::where('user_id', $user->id)->first();
    
        if (!$userProfile) {
            // Create a new profile if it doesn't exist
            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
        }
    
        $userProfile->phone = $validatedData['phone'];
        $userProfile->address = $validatedData['address'];
    
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = 'profile_image_'.time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put('profile_image/' . $filename, file_get_contents($image));
            $user->profile_image = $filename; // Update profile image path in the users table
        }
    
        $userProfile->save();
        $user->save();
    
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
    

}
