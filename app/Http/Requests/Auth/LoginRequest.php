<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        $user = User::where('email', $this->login)
            ->orWhere('username', $this->login)
            ->first();

        // Corrected condition
        if (! $user || ($user->status != 'inactive' && ! Hash::check($this->password, $user->password))) {
            RateLimiter::hit($this->throttleKey());

            session()->flash('message', 'Login failed. Please check your credentials and try again.');
            session()->flash('alert-type', 'danger');

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        // Prevent inactive users from logging in
        if ($user->status == 'inactive') {
            session()->flash('message', 'Your account validity has expired. Please contact support.');
            session()->flash('alert-type', 'danger');

            throw ValidationException::withMessages([
                'login' => 'Your account is inactive.',
            ]);
        }

        // Additional expiration check for non-admin users
        if ($user->role != 'admin') {
            $current_date = Carbon::now();
            $expire_date = Carbon::createFromFormat('Y-m-d', $user->expire_date);

            if ($current_date >= $expire_date) {
                $user = User::where('id', $user->id)->first();
                $user->slot = 0;
                $user->save();
                session()->flash('message', 'Your account validity has expired. Please contact support.');
                session()->flash('alert-type', 'danger');

                throw ValidationException::withMessages([
                    'login' => 'Your account has expired.',
                ]);
            }
        }

        Auth::login($user, $this->boolean('remember'));
        RateLimiter::clear($this->throttleKey());

        session()->flash('message', 'Login Successfully');
        session()->flash('alert-type', 'success');

        return redirect()->intended('dashboard');
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
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
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
