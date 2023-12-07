<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
              if (!Auth::attempt(array('mobile' => $this->user_name, 'password' => $this->password,'status' => 'Active'), $this->filled('remember'))) {
                if (!Auth::attempt(array('email' => $this->user_name, 'password' => $this->password,'status' => 'Active'), $this->filled('remember'))) {
                    $this->authenticateAdmin();
                }
            }
        //dd(array('mobile' => $this->user_name, 'password' => $this->password));
        RateLimiter::clear($this->throttleKey());
    }
    public function authenticateAdmin()
    {
        $this->ensureIsNotRateLimited();


        if (! Auth::guard('admin')->attempt(array('user_name' => $this->user_name, 'password' => $this->password), $this->filled('remember'))) {

            //dd($this->user_name);
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'user_name' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
