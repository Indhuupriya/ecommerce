<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\ThankYouMail;
use Hash;
use DB; 
use Mail; 
use Session;
use Carbon\Carbon; 
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
            'phone' => 'required|numeric',
            'address' => 'required|string',
        ]);
       
       $role = Role::find('3');
   
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);
        $data = $request->all();
        $user_profile=UserProfile::create([
            'user_id'=>$user->id,
            'address'=>$data['address'],
            'phone'=>$data['phone']
            ]);

        $user->assignRole($role);
        // Mail::to($validatedData['email'])->send(new ThankYouMail($user));
        return response()->json(['message' => 'Registration successful','redirect_url'=>'/', 'user' => $user]);
    }
    public function login(Request $request){
        $email = $request->email;
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 401);
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login successful', 'redirect_url' => url('/')]);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect('/')->with('success', 'Logout Successfully!');
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
          
            $users = Socialite::driver('google')->user();
            if ($users) {
                $imagePath = $this->storeUserProfileImage($users->avatar, $users->id);
                $finduser = User::where('google_id', $users->id)->first();
                $existingUser = User::where('email', $users->email)->first();
                
                if ($existingUser) {
                    Auth::login($existingUser);
                    return redirect()->intended('/')->withSuccess('Successfully Logged in with Google');
                } else {
                    $user = User::create([
                        'name' => $users->name,
                        'email' => $users->email,
                        'google_id' => $users->id,
                        'profile_image' => $imagePath,
                        'password' => encrypt('123456dummy')
                    ]);
                    $role = Role::find('3');
                    $user->assignRole($role);
                    Mail::to($users->email)->send(new ThankYouMail($user));
                    Auth::login($user);
                    return redirect()->intended('/')->withSuccess('Successfully Logged in with Google');
                }
            } else {
                // Handle null case if necessary
                return redirect()->back()->withErrors(['msg', 'Failed to retrieve user information from Google']);
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    private function storeUserProfileImage($avatarUrl, $userId){
        $imageContents = file_get_contents($avatarUrl);
        $filename = 'profile_image_' . $userId . '.jpg';
        Storage::disk('public')->put('profile_image/' . $filename, $imageContents);
        return $filename;
    }

    public function forget_password(Request $request){
        $validator = Validator::make($request->all(),[
           'email' => 'required|email|exists:users',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword',['token'=>$token],function($message) use($request){
           $message->to($request->email);
           $message->subject('Reset Password');
        });
        return   response()->json(['message' => 'We have e-mailed your password reset link!'],200);
    }
    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
     }

     public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
          return redirect('/')->with('message', 'Your password has been changed!');
      }
    
}

?>