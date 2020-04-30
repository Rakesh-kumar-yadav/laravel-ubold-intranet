<?php

namespace App\Http\Controllers\Document;

use App\Models\Category;
use App\Models\Company;
use App\Models\Department;
use App\Models\Document;
use App\Models\DowwHistory;
use App\Models\Notification;
use App\Models\Revision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use File;

class RevisionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $revisions = DB::table("documents_revision AS rev")->select('rev.*')
            ->leftJoin("documents AS doc", "doc.id", "=", "rev.docu_id")
            ->leftJoin("categories AS cat", "cat.id", "=", "doc.category_id")
            ->addSelect('doc.docu_name', 'doc.docu_no', 'cat.category_name')
            ->where('rev.docu_id', $id)
            ->orderBy('rev.id')
            ->get();
        return view('documents.revision.index', compact('revisions', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('documents.revision.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->validate([
            'revision_no' => 'required',
            'document' => 'required|file',
        ]);

        $filePath = $request->document->store('documents', 'public');
        $one = new Revision;
        $one->docu_id = $id;
        $one->revision_no = $request->revision_no;
        $one->user_key = $request->user_key;
        $one->real_name = $request->document->getClientOriginalName();
        $one->file_name = $filePath;
        $one->save();

        $depart_ids = explode(",", $request->depart_ids);
        $total_user_ids = [];
        foreach ($depart_ids as $depart_id)
        {
            if (strpos($depart_id, "_") !== false) continue;
            $created_user_id = Auth::user()->id;
            $docu_id = $id;
            $revision_id = $one->id;
            $users = DB::table("usersettings")->select("user_id", "depart_id")->where("depart_id", $depart_id)->get();
            foreach ($users as $user)
            {
                $one_noti = new Notification;
                $one_noti->user_id = $user->user_id;
                $one_noti->depart_id = $depart_id;
                $one_noti->docu_id = $docu_id;
                $one_noti->revision_id = $revision_id;
                $one_noti->docu_name = Document::find($id)->docu_name;
                $one_noti->created_user_id = $created_user_id;
                $one_noti->save();
            }

        }
        return redirect()->route('revision.index', compact('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\revision  $revision
     * @return \Illuminate\Http\Response
     */
    public function show(revision $revision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\revision  $revision
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $revision = Revision::find($id);

        return view('documents.revision.edit', compact('revision'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\revision  $revision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'revision_no' => 'required',
        ]);

        $one = Revision::find($id);
        if ($request->document){
            $filePath = public_path().'/assets/'.$one->file_name;
            File::delete( $filePath);
            $filePath = $request->document->store('documents', 'public');
            $one->file_name = $filePath;
            $one->real_name = $request->document->getClientOriginalName();
        }
        
        $one->revision_no = $request->revision_no;
        $one->user_key = $request->user_key;
        $one->save();

        return redirect()->route('revision.index', $one->docu_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\revision  $revision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $one = Revision::find($id);
        $filePath = public_path().'/assets/'.$one->file_name;
        File::delete( $filePath);
        $one->delete();
        \App\Models\Notification::where('revision_id', $id)->delete();
    }
    public function downfile($id)
    {
        $order = Revision::find($id);
        $username = Auth::user()->name;
        $filename = $order->real_name;
        $down = new DowwHistory;
        $down->user_name = $username;
        $down->file_name = $filename;
        $docment = Document::find($order->docu_id);
        $down->depart_name = Department::find($docment->depart_id)->department_name;
        $down->company_name = Company::find($docment->company_id)->company_name;
        $down->revision_no = $order->revision_no;
        $down->docu_name = $docment->docu_name;
        $down->category_name = Category::find($docment->category_id)->category_name;
        $down->save();
        return response()->download(public_path('assets/').$order->file_name, $filename);
    }
}
