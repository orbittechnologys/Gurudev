<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AuthenticatedSessionController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {  // dd(Auth::check());
        if (Auth::guard('admin')->check()) {
            return redirect(RouteServiceProvider::AdminHOME);
        } else if (Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }
        return view('Home.index');
    }
    public function adminCreate()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(RouteServiceProvider::AdminHOME);
        }
        return view('Home.index');
    }
    public function store(LoginRequest $request)
    {


        $res = $request->authenticate();
        $request->session()->regenerate();
        if (Auth::guard('admin')->check()) {
            return redirect(RouteServiceProvider::AdminHOME);
        } else if (Auth::check()) {
            Auth::logoutOtherDevices($request->password);
            DB::table('personal_access_tokens')->where('tokenable_id', Auth::user()->id)->delete();
            
            return redirect(RouteServiceProvider::HOME);
        }
    }
    public function resetPassword(Request $request)
    {
        //dd($request->input());
        $res = User::where('mobile', $request->mobile)->update(['password' => Hash::make($request->password)]);

        if ($res)
            return redirect(RouteServiceProvider::LOGIN)->with('sweet-success', 'Password Changed Successfully');
        return redirect(RouteServiceProvider::LOGIN)->with('sweet-success', 'Please Try After sometime');
    }
    public function resetUserPassword(Request $request)
    {
        if(!(Hash::check($request->current_password, auth()->user()->password))){
            return redirect()->back()->withErrors("Your current password does not matches with the password you provided. Please try again.");
        }
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required','confirmed','min:8'],
        ], [
            'password.required' => 'The Password is required.',
            'current_password.required'=>'Current Password is required.',
            'password.confirmed' => "New Password & Confirm Password doesn't match."
        ]);

        $res = User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->password)]);

        Auth::guard('web')->logout();
        if ($res)
            return redirect(RouteServiceProvider::LOGIN)->with('sweet-success', 'Password Changed Successfully');
        return redirect(RouteServiceProvider::LOGIN)->with('sweet-success', 'Please Try After sometime');
    }


    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function adminDestroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    //----For Admin

}
