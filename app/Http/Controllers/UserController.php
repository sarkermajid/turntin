<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Notice;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            if (auth()->user()->role == 'user') {
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

                return view('frontend.dashboard.dashboard', compact('notice', 'files'));
            } elseif (auth()->user()->role == 'agent') {
                return view('agent.agent_dashboard');
            } elseif (auth()->user()->role == 'admin') {
                return view('admin.admin_dashboard');
            }
        } else {
            return view('frontend.login');
        }
    }

    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = [
            'message' => 'User Logout Successfully',
            'alert-type' => 'success',
        ];

        return redirect('/')->with($notification);
    }

    public function AllUsers()
    {
        $users = User::where('role', '!=', 'admin')->get();

        return view('admin.user.all_users', compact('users'));
    }

    public function AddUser()
    {
        $pages = Page::latest()->get();

        return view('admin.user.add_user', compact('pages'));
    }

    public function StoreUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'role' => 'required|string',
            'status' => 'required|string',
            'password' => 'required|string|min:8',
            'expire_date' => 'required|date',
            'email' => 'required|email|unique:users,email',
        ]);


        // Check if the email validation failed
        if ($validator->errors()->has('email')) {
            $notification = [
                'message' => 'The email you entered already exists. Please use a different email address.',
                'alert-type' => 'error',
            ];
            return redirect()->route('add.user')->with($notification);
        }

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->slot = $request->slot;
        $user->page_id = $request->page_id;
        $user->expire_date = $request->expire_date;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->save();
        $notification = [
            'message' => 'User Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.users')->with($notification);
    }

    public function EditUser($id)
    {
        $user = User::find($id);
        $pages = Page::latest()->get();

        return view('admin.user.edit_user', compact('user', 'pages'));
    }

    public function UpdateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->slot = $request->slot;
        $user->page_id = $request->page_id;
        $user->expire_date = $request->expire_date;
        $user->status = $request->status;

        // Check if a new password is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->update();

        $notification = [
            'message' => 'User Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.users')->with($notification);
    }

    public function DeleteUser($id)
    {
        $user = User::find($id);
        $files = File::where('user_id', $user->id)->get();
        if ($files) {
            foreach ($files as $file) {
                $filePath = public_path('uploads/file/'.$file->file_name);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $file->delete();
            }
        }
        $user->delete();
        $notification = [
            'message' => 'User Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
