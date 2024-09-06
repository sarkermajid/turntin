<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function AllPage()
    {
        $pages = Page::latest()->get();

        foreach ($pages as $item) {
            $item->total_users = User::where('page_id', $item->id)->count();
        }

        return view('admin.pages.all_pages', compact('pages'));
    }

    public function addPage()
    {
        return view('admin.pages.add_page');
    }

    public function StorePage(Request $request)
    {
        $page = new Page;
        $page->name = $request->name;
        $page->save();
        $notification = [
            'message' => 'Page Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect('all/pages')->with($notification);
    }

    public function EditPage($id)
    {
        $page = Page::find($id);

        return view('admin.pages.edit_page', compact('page'));
    }

    public function UpdatePage(Request $request, $id)
    {
        $page = Page::find($id);
        $page->name = $request->name;
        $page->update();
        $notification = [
            'message' => 'Page Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect('all/pages')->with($notification);
    }

    public function DeletePage($id)
    {
        $page = Page::find($id);
        $page->delete();
        $notification = [
            'message' => 'Page Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect('all/pages')->with($notification);
    }
}
