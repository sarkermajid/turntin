<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notice = Notice::first();

        return view('admin.notice.notice_index', compact('notice'));
    }

    public function noticeUpdate(Request $request, $id)
    {
        $notice = Notice::find($id);
        $notice->notice = $request->notice;
        $notice->save();
        $notification = [
            'message' => 'Notice Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect('notice')->with($notification);
    }
}
