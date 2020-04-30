<?php

namespace App\Http\Controllers\Admin;
use App\Models\Company;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;
use DB;

class DepartmentsController extends Controller
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

        $departments = Department::leftJoin('companies', function($join){
            $join->on('companies.id', '=', 'departments.company_id');
        })->select('departments.*', 'companies.company_name')->get();

        return view('admin.departments.index', compact('departments'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all()->pluck('company_name', 'id');
        return view('admin.departments.create', compact('companies'));
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
            'company_name' => 'required|not_in:0',
            'department_name' => 'required',
        ]);
        $department = new Department;
        $department->company_id = $request->company_name;
        $department->department_name = $request->department_name;
        $department->save();
        return redirect()->route('admin.departments.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
        $companies = Company::all()->pluck('company_name', 'id');
        return view('admin.departments.edit', compact('department', 'companies'));
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
            'company_name' => 'required|not_in:0',
            'department_name' => 'required',
//            'department_name' => 'required|unique:departments,department_name,'.$request->company_name. ',company_id',
        ]);
        $department = Department::find($id);
        $department->company_id = $request->company_name;
        $department->department_name = $request->department_name;
        $department->save();
        return redirect()->route('admin.departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Department::find($id);
        $documents = DB::table('documents')->where('depart_id', $id);
        $arrDoc = array();
        foreach ($documents->get() as $document) {
            array_push($arrDoc, $document->id);
        }
        DB::table('documents_revision')->whereIn('docu_id', $arrDoc)->delete();
        DB::table('notifications')->whereIn('docu_id', $arrDoc)->delete();
        DB::table('notifications')->where('depart_id', $id)->delete();
        DB::table('usersettings')->where('depart_id', $id)->delete();
        DB::table('organisations')->where('department_id', $id)->delete();
        $documents->delete();
        $company->delete();
    }
}
