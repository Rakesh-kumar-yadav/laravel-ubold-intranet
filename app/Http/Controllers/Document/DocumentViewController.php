<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentViewController extends Controller
{
    public function view($id)
    {
        $notification = Notification::find($id);
        if(!isset($notification->user_id))
            return redirect()->route('document.index');
        if(intval($notification->docu_id) < 1)
            return redirect()->route('document.index');
        if($notification->user_id != Auth::user()->id)
            return redirect()->route('document.index');
        else
            return view('documents.view.index', compact('notification'));
    }
    public function confirm(Request $request, $id)
    {
        $data = $request->validate([
            'customCheck3' => 'required',
        ]);
        $notification = Notification::find($id);
        $notification->confirm = 1;
        $notification->save();
        return redirect()->route('document.index');
    }
    public function adminview(Request $request){
        $notifications = DB::table("notifications AS noti")->select('noti.*')
            ->leftJoin("departments AS depart", "depart.id", "=", "noti.depart_id")
            ->leftJoin("companies AS company", "company.id", "=", "depart.company_id")
            ->leftJoin("documents_revision AS revision", "revision.id", "=", "noti.revision_id")
            ->leftJoin("documents AS doc", "doc.id", "=", "noti.docu_id")
            ->leftJoin("categories AS category", "category.id", "=", "doc.category_id")
            ->addSelect('company.company_name', 'depart.department_name', 'category.category_name', 'doc.docu_name', 'revision.revision_no');
        if (isset($request->company) && $request->company != "0")
        {
            $notifications = $notifications->where('company.id', $request->company);
        }
        if (isset($request->department) && $request->department != "0")
        {
            $notifications = $notifications->where('depart.id', $request->department);
        }
        if (isset($request->category) && $request->category != "0")
        {
            $notifications = $notifications->where('category.id', $request->category);
        }
        if (isset($request->revision_no) && $request->revision_no != "")
        {
            $notifications = $notifications->where('revision.revision_no', $request->revision_no);
        }
        if (isset($request->docu_name) && $request->docu_name != "")
        {
            $notifications = $notifications->where('doc.docu_name', $request->docu_name);
        }
        $notifications = $notifications->where('noti.docu_id', '<>', '0')->orderBy('noti.id')->get();
        $companies = Company::all();
        $categories = Category::all();
        return view('documents.view.admin_index', compact('notifications', 'companies', 'categories', 'request'));
    }
}
