<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function AgentDashboard()
    {
        return view('agent.agent_dashboard');
    }

    public function AgentLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = [
            'message' => 'Sub Admin Logout Successfully',
            'alert-type' => 'success',
        ];

        return redirect('/')->with($notification);
    }
}
