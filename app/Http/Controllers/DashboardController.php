<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Notice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index()
    {
        $files = File::where('user_id', Auth::user()->id)->latest()->get();
        $notice = Notice::first();
        $user_status = auth()->user()->status;
        if ($user_status == 'inactive') {
            Auth::logout();
            $notification = [
                'message' => 'Your account validity has expired. Please contact support.',
                'alert-type' => 'danger',
            ];

            return redirect()->route('home')->with($notification);
        }

        $user = auth()->user();
        if ($user->role != 'admin') {
            $current_date = Carbon::now();
            $expire_date = Carbon::createFromFormat('Y-m-d', $user->expire_date);

            if ($current_date >= $expire_date) {
                $user = User::where('id', $user->id)->first();
                $user->slot = 0;
                $user->save();
                session()->flash('message', 'Your account has expired. Please contact support.');
                session()->flash('alert-type', 'danger');

                throw ValidationException::withMessages([
                    'login' => 'Your account has expired.',
                ]);
            }
        } else {
            return redirect()->route('home');
        }

        return view('frontend.dashboard.dashboard', compact('files', 'notice'));
    }
}
