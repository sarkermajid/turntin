<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function fileUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {

            $notification = [
                'message' => $validator->errors()->first(), // Get the first error message
                'alert-type' => 'error',
            ];

            return redirect('dashboard')->with($notification)->withInput();
        }

        $file = $request->file('file');
        $fileName = time().'_'.$file->getClientOriginalName();

        $user = User::find(Auth::user()->id);
        if ($user->slot > 0) {
            // Check if the user has reached the slot limit
            $uploadedFilesCount = File::where('user_id', $user->id)->count();

            if ($uploadedFilesCount >= 5) {
                // Get the oldest file
                $oldestFile = File::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->first();

                if ($oldestFile) {
                    // Remove the file from storage
                    $filePath = public_path('uploads/file/'.$oldestFile->file_name);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // Remove the file record from the database
                    $oldestFile->delete();
                }
            }

            $file->move(public_path('uploads/file'), $fileName); // Move the file

            // Save file information to the database
            $file = new File;
            $file->file_name = $fileName;
            $file->user_id = Auth::user()->id;
            $file->status = 0;
            $file->save();

            // Decrement the user's slot count
            $user->slot = $user->slot - 1;
            $user->save();

            $notification = [
                'message' => 'The File you are submitting will not be added to any repository',
                'alert-type' => 'success',
            ];

            return redirect('dashboard')->with($notification);
        } else {
            $notification = [
                'message' => 'You have reached your upload limit and cannot upload additional files at this time.',
                'alert-type' => 'warning',
            ];

            return redirect('dashboard')->with($notification);
        }
    }

    public function AllFiles()
    {
        $files = File::latest()->get();

        return view('admin.file.all_files', compact('files'));
    }

    public function FilesDownload($id)
    {
        return response()->download(public_path('uploads/file/').$id);
    }

    public function FilesEdit($id)
    {
        $file = File::find($id);
        $users = User::whereIn('role', ['agent', 'admin'])->get();

        return view('admin.file.edit_file', compact('file', 'users'));
    }

    public function FilesUpdate(Request $request, $id)
    {
        $file = File::find($id);
        $file->ai = $request->ai;
        $file->similarity = $request->similarity;

        // Plagiarism report file upload
        if ($request->hasFile('plagiarism_report')) {

            // Delete the old plagiarism report file if it exists
            if ($file->plagiarism_report) {
                $oldPlagiarismReport = public_path('uploads/plagiarism_reports/'.$file->plagiarism_report);
                if (file_exists($oldPlagiarismReport)) {
                    unlink($oldPlagiarismReport);
                }
            }

            $plagiarism_report = $request->file('plagiarism_report');
            $plagiarism_report_name = time().'_'.$plagiarism_report->getClientOriginalName();
            $plagiarism_report->move(public_path('uploads/plagiarism_reports'), $plagiarism_report_name);
            $file->plagiarism_report = $plagiarism_report_name;
        }

        // AI report file upload
        if ($request->hasFile('ai_report')) {

            // Delete the old plagiarism report file if it exists
            if ($file->ai_report) {
                $oldAiReport = public_path('uploads/ai_reports/'.$file->ai_report);
                if (file_exists($oldAiReport)) {
                    unlink($oldAiReport);
                }
            }

            $ai_report = $request->file('ai_report');
            $ai_report_name = time().'_'.$ai_report->getClientOriginalName();
            $ai_report->move(public_path('uploads/ai_reports'), $ai_report_name);
            $file->ai_report = $ai_report_name;
        }

        $file->status = $request->status;
        // $file->checker_id = $request->checker_id;
        $file->flags = $request->flags;
        $file->save();

        $user = User::where('id', Auth::user()->id)->first();
        $user->check_count = $user->check_count + 1;
        $user->save();

        $notification = [
            'message' => 'File Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect('all/files')->with($notification);
    }

    public function FilesDelete($id)
    {
        $file = File::find($id);
        if ($file) {
            $filePath = public_path('uploads/file/'.$file->file_name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $file->delete();

            $notification = [
                'message' => 'File Deleted Successfully',
                'alert-type' => 'error',
            ];
        } else {
            $notification = [
                'message' => 'File Not Found',
                'alert-type' => 'warning',
            ];
        }

        return redirect()->back()->with($notification);
    }

    public function fileDelete($id)
    {
        $file = File::find($id);
        if ($file) {
            $filePath = public_path('uploads/file/'.$file->file_name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $file->delete();

            $notification = [
                'message' => 'File Deleted Successfully',
                'alert-type' => 'error',
            ];
        } else {
            $notification = [
                'message' => 'File Not Found',
                'alert-type' => 'warning',
            ];
        }

        return redirect('dashboard')->with($notification);
    }

    public function fileDownload($id)
    {
        return response()->download(public_path('uploads/file/').$id);
    }

    public function plagiarismDownload($id)
    {
        return response()->download(public_path('uploads/plagiarism_reports/').$id);
    }

    public function aiDownload($id)
    {
        return response()->download(public_path('uploads/ai_reports/').$id);
    }

    public function agentAllFiles()
    {
        $files = File::latest()->get();

        return view('agent.file.all_files', compact('files'));
    }

    public function agentFilesDownload($id)
    {
        return response()->download(public_path('uploads/file/').$id);
    }

    public function agentFilesDelete($id)
    {
        $file = File::find($id);
        if ($file) {
            $filePath = public_path('uploads/file/'.$file->file_name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $file->delete();

            $notification = [
                'message' => 'File Deleted Successfully',
                'alert-type' => 'error',
            ];
        } else {
            $notification = [
                'message' => 'File Not Found',
                'alert-type' => 'warning',
            ];
        }

        return redirect()->back()->with($notification);
    }

    public function agentFilesEdit($id)
    {
        $file = File::find($id);
        $users = User::whereIn('role', ['agent', 'admin'])->get();

        return view('agent.file.edit_file', compact('file', 'users'));
    }

    public function agentFilesUpdate(Request $request, $id)
    {
        $file = File::find($id);
        $file->ai = $request->ai;
        $file->similarity = $request->similarity;

        // Plagiarism report file upload
        if ($request->hasFile('plagiarism_report')) {

            // Delete the old plagiarism report file if it exists
            if ($file->plagiarism_report) {
                $oldPlagiarismReport = public_path('uploads/plagiarism_reports/'.$file->plagiarism_report);
                if (file_exists($oldPlagiarismReport)) {
                    unlink($oldPlagiarismReport);
                }
            }

            $plagiarism_report = $request->file('plagiarism_report');
            $plagiarism_report_name = time().'_'.$plagiarism_report->getClientOriginalName();
            $plagiarism_report->move(public_path('uploads/plagiarism_reports'), $plagiarism_report_name);
            $file->plagiarism_report = $plagiarism_report_name;
        }

        // AI report file upload
        if ($request->hasFile('ai_report')) {

            // Delete the old plagiarism report file if it exists
            if ($file->ai_report) {
                $oldAiReport = public_path('uploads/ai_reports/'.$file->ai_report);
                if (file_exists($oldAiReport)) {
                    unlink($oldAiReport);
                }
            }

            $ai_report = $request->file('ai_report');
            $ai_report_name = time().'_'.$ai_report->getClientOriginalName();
            $ai_report->move(public_path('uploads/ai_reports'), $ai_report_name);
            $file->ai_report = $ai_report_name;
        }

        $file->status = $request->status;
        $file->flags = $request->flags;
        $file->save();

        if ($request->status == 1) {
            $user = User::where('id', Auth::user()->id)->first();
            $user->check_count = $user->check_count + 1;
            $user->save();
        }

        $user = User::find($request->user_id);
        $page = Page::find($user->page_id);
        if ($page) {
            $page->file_count = $page->file_count + 1;
            $page->save();
        }

        $notification = [
            'message' => 'File Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect('agent/all/files')->with($notification);
    }
}
