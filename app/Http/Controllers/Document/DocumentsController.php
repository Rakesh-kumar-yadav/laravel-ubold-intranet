<?php

namespace App\Http\Controllers\Document;

use App\Models\Company;
use App\Models\Department;
use App\Models\Category;
use App\Models\Document;
use App\Models\Revision;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DowwHistory;
use Illuminate\Support\Facades\Gate;


class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $documents = DB::table("documents AS doc")->select('doc.*')
            ->leftJoin("companies AS company", "company.id", "=", "doc.company_id")
            ->leftJoin("departments AS depart", "depart.id", "=", "doc.depart_id")
            ->leftJoin("categories AS category", "category.id", "=", "doc.category_id")
            ->addSelect('company.company_name', 'company.company_code', 'depart.department_name', 'category.category_name');
        if (isset($request->company) && $request->company != "0")
        {
            $documents = $documents->where('company.id', $request->company);
        }
        if (isset($request->department) && $request->department != "0")
        {
            $documents = $documents->where('depart.id', $request->department);
        }
        if (isset($request->category) && $request->category != "0")
        {
            $documents = $documents->where('category.id', $request->category);
        }
        if (isset($request->keyword) && $request->keyword != "")
        {
            $documents = $documents->where('doc.docu_name', 'like', '%'.$request->keyword.'%');
            $documents = $documents->orWhere('doc.docu_no', 'like', '%'.$request->keyword.'%');
        }
        
        $depart_ids = DB::table('usersettings')->where('user_id', '=', Auth::user()->id)->get()->pluck('depart_id');
        $arr_ids = $depart_ids->toArray();

        // for admins
        if (Gate::allows('documents_manage')) {
            
            $documents = $documents->orderBy('doc.id')->get();
        } else {
            $documents = $documents->whereIn("doc.depart_id", $arr_ids)->orderBy('doc.id')->get();
        }

        $companies = Company::all();
        $categories = Category::all();
        return view('documents.index', compact('documents', 'companies', 'categories', 'request'));
    }

    public function savedeparttree(Request $request)
    {
        $user_id = $request->user_id;
        $depart_ids = $request->depart_ids;
        DB::table('usersettings')->where("user_id", $user_id)->delete();

        // notification
        DB::table('notifications')->where('user_id', $user_id)->delete();

        foreach ($depart_ids as $depart_id) {
            if (strpos($depart_id, "_") !== false) continue;
            DB::table('usersettings')->insert(
                ['user_id' => $user_id, 'depart_id' => $depart_id]
            );

            // notification
            $documents = DB::table('documents')->where('depart_id', $depart_id)->get();
            foreach ($documents as $document) {
                $revision = DB::table('documents_revision')->where('docu_id', $document->id)->get();
                if (sizeof($revision) < 1) {
                    continue;
                }
                DB::table('notifications')->insert(
                    [
                        'user_id' => $user_id, 
                        'depart_id' => $depart_id,
                        'docu_id' => $document->id,
                        'revision_id' => $revision->last()->id,
                        'docu_name' => $document->docu_name,
                        'embed_id' => 0,
                        'created_user_id' => 0,
                        'confirm' => 0,
                        'due_date' => '9999-12-31 00:00:00',
                    ]
                );
            }
        }
        return "OK";
    }

    public function getdeparttree(Request $request)
    {
        $results = array();
        $compaines = Company::all();
        foreach ($compaines as $company)
        {
            $result = array();
            $result['id'] = '_'.$company->id;
            $result['text'] = $company->company_name;
            $result['children'] = $this->getSubData('_'.$company->id, $request->user_id);
            array_push($results, $result);
        }
        return json_encode($results);
    }

    public function getSubData($compay_id, $user_id)
    {
        $departs = Department::where('company_id', str_replace("_", "", $compay_id))->get();
        $results = array();
        $depart_ids = DB::table('usersettings')->where('user_id', '=', $user_id)->get()->pluck('depart_id');
        $str_ids = $depart_ids->toArray();
        foreach ($departs as $depart)
        {
            $result = array();
            $result['id'] = $depart->id;
            $result['text'] = $depart->department_name;
            if (in_array($depart->id, $str_ids)) {
                $result['checked'] = true;
            }
            $result['children'] = [];
            array_push($results, $result);
        }
        return $results;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        $categories = Category::all();
        return view('documents.wcreate', compact('companies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company' => 'required',
            'department' => 'required',
            'category' => 'required',
            'docu_name' => 'required|unique:documents',
            'docu_no' => 'required',
            'revision_no' => 'required',
            'docu_file' => 'required|file',
            'depart_ids' => 'required',
        ]);

        $one = new Document;
        $one->company_id = $request->company;
        $one->depart_id = $request->department;
        $one->category_id = $request->category;
        $one->docu_name = $request->docu_name;
        $one->docu_no = $request->docu_no;
        $one->save();

        $one_rev = new Revision;
        if (!file_exists(public_path('assets/documents'))) {
            mkdir(public_path('assets/documents'), 0777);
        }
        $filePath = $request->docu_file->store('documents', 'public');
        $one_rev->docu_id = $one->id;
        $one_rev->revision_no = $request->revision_no;
        $one_rev->user_key = $request->user_key;
        $one_rev->file_name = $filePath;
        $one_rev->real_name = $request->docu_file->getClientOriginalName();
        $one_rev->save();

        $depart_ids = explode(",", $request->depart_ids);
        foreach ($depart_ids as $depart_id)
        {
            if (strpos($depart_id, "_") !== false) continue;
            $created_user_id = Auth::user()->id;
            $docu_id = $one->id;
            $revision_id = $one_rev->id;
            $users = DB::table("usersettings")->select("user_id", "depart_id")->where("depart_id", $depart_id)->get();
            foreach ($users as $user)
            {
                $one_noti = new Notification;
                $one_noti->user_id = $user->user_id;
                $one_noti->depart_id = $depart_id;
                $one_noti->docu_id = $docu_id;
                $one_noti->revision_id = $revision_id;
                $one_noti->docu_name = $request->docu_name;
                $one_noti->created_user_id = $created_user_id;
                $one_noti->save();
            }

        }

        return redirect()->route('document.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::find($id);
        $companies = Company::all();
        $categories = Category::all();
        return view('documents.edit', compact('companies', 'categories', 'document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'company' => 'required',
            'department' => 'required',
            'category' => 'required',
            'docu_no' => 'required',
        ]);

        $one = Document::find($id);
        $one->company_id = $request->company;
        $one->depart_id = $request->department;
        $one->category_id = $request->category;
        $one->docu_name = $request->docu_name;
        $one->docu_no = $request->docu_no;
        $one->save();

        return redirect()->route('document.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $one = Document::find($id);
        $one->delete();
        \App\Models\Notification::where('docu_id', $id)->delete();
        DB::table('documents_revision')->where('docu_id', $id)->delete();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getdepartments(Request $request)
    {
        $company_id = $request->company_id;
        $departments = Department::where('company_id', $company_id)->get();
        return json_encode($departments);
    }

    public function downfile($id)
    {
        $order = Revision::whereRaw('id = (select max(`id`) from documents_revision where docu_id='.$id.')')->get();
        $username = Auth::user()->name;
        $filename = $order[0]->real_name;
        $down = new DowwHistory;
        $down->user_name = $username;
        $down->file_name = $filename;
        $docment = Document::find($id);
        $down->depart_name = Department::find($docment->depart_id)->department_name;
        $down->company_name = Company::find($docment->company_id)->company_name;
        $down->revision_no = $order[0]->revision_no;
        $down->docu_name = $docment->docu_name;
        $down->category_name = Category::find($docment->category_id)->category_name;
        $down->save();
        return response()->download(public_path('assets/').$order[0]->file_name, $order[0]->real_name);
    }
}
