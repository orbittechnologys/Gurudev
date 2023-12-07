<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PaymentDetail;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       // dd($request);
       /* $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|string|max:12|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);*/

        $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'dob' => date('Y-m-d',strtotime($request->dob)),
            'password' => Hash::make($request->password),
           //'password' => $request->password,
        ]);
       //event(new Registered($user));
        $userCount=str_pad($user->id,5,"0",STR_PAD_LEFT);
        $userCount="GD".date('Y').$userCount;
        $user->user_id=$userCount;
        $query = $user->save();
        if($query){
            $courseDetail = new PaymentDetail();
            $courseDetail->create([
                'user_id'=>$user->id,
                'type'=>'Course',
                'type_id'=>0,
                'status'=>'Success'
            ]);
        }
        
        if($query){
            return redirect(RouteServiceProvider::LOGIN)->with('sweet-success','Registration Done Successfully');
        }
        else{
            return redirect(RouteServiceProvider::LOGIN)->with('sweet-danger','Registration Failed');
        }

    }
    public function emailVerificationNotice()
    {
        return view('auth.verifyEmail');
    }

    public function emailVerificationVerify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('dashboard');
    }
}
