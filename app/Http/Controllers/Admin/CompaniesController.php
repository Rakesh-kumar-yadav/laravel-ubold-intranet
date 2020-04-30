<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Company;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('documents_manage')) {
            return abort(500);
        }

        $companies = Company::all();

        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.companies.create');
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
            'company_code' => 'required',
            'company_name' => 'required|unique:companies',
        ]);

        $company = new Company;
        $company->company_code = $data['company_code'];
        $company->company_name = $data['company_name'];
        $company->save();

        return redirect()->route('admin.companies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);

        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'company_code' => 'required',
            'company_name' => 'required|unique:companies,company_name,'.$request->company_name,
        ]);

        $company = Company::find($id);
        $company->company_code = $data['company_code'];
        $company->company_name = $data['company_name'];
        $company->save();

        return redirect()->route('admin.companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $departments = DB::table('departments')->where('company_id', $id);
        $arrDepart = array();
        foreach ($departments->get() as $department) {
            array_push($arrDepart, $department->id);
        }
        DB::table('notifications')->whereIn('depart_id', $arrDepart)->delete();

        $documents = DB::table('documents')->where('company_id', $id);
        $arrDoc = array();
        foreach ($documents->get() as $document) {
            array_push($arrDoc, $document->id);
        }
        DB::table('documents_revision')->whereIn('docu_id', $arrDoc)->delete();
        DB::table('notifications')->whereIn('docu_id', $arrDoc)->delete();
        DB::table('organisations')->where('company_id', $id)->delete();
        DB::table('usersettings')->whereIn('depart_id', $arrDepart)->delete();

        $documents->delete();
        $departments->delete();
        $company->delete();
    }
}
