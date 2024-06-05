<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;

class AdminAuthController extends Controller
{
    // index function to return the login view for admin
    public function index()
    {
        return view('auth.login');
    }
    // function to return the reset password view for admin
    public function resetPassword()
    {
        return view('auth.pass-reset');
    }
    // function to return the change password view for admin
    public function changePassword()
    {
        return view('auth.changePassword');
    }
    // function to login the admin
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            # check if user status is inactive
            if (auth()->user()->status == 'inactive') {
                auth()->logout();
                return redirect()->route('admin.login')->with('error', 'Your account is inactive. Please contact the administrator.');
            }

            if (auth()->user()->password == '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi') {
                return redirect()->route('admin.changePassword');
            }
            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);

            // return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login')->with('error', 'Invalid Credentials');
    }
    // changePasswordStore function to change the password of the admin
    public function changePasswordStore(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);
        # check if new password is same as old password
        if ((Hash::check($request->get('password'), auth()->user()->password))) {
            return redirect()->back()->with('error', 'Your current password matches with the password you provided. Please try again.');
        }
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        #logout the user
        auth()->logout();
        # redirect to login page
        return redirect()->route('admin.login')->with('success', 'Password changed successfully!');
    }
}
