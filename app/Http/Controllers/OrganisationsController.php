<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\User;
use Illuminate\Http\Request;
use App\Models\Organisation;
use File;
use DB;

class OrganisationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company_id = 0;
        $department_id = 0;
        $ones = Organisation::leftJoin('companies', function($join){
            $join->on('organisations.company_id', '=', 'companies.id');
        })
        ->leftJoin('departments', function($join){
            $join->on('organisations.department_id', '=', 'departments.id');
        })
        ->select('organisations.*', 'companies.company_name as companyname', 'departments.department_name as departmentname');

        if ($request->company){
            $company_id = $request->company;
            $department_id = $request->department;
            if ($company_id != 0)
                $ones = $ones->where('organisations.company_id', '=', $company_id);
            if ($department_id != 0)
                $ones = $ones->where('organisations.department_id', '=', $department_id);
        }
        $ones = $ones->get();

        $companies = Company::all();
        $departments = Department::all();
        return view('organisations.index', compact('ones', 'companies', 'departments', 'company_id', 'department_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('organisations.create', compact('companies'));
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
            'company' => 'required|integer',
            'department' => 'required|integer',
            'title' => 'required|string|max:190',
            'organisation_chart' => 'required|file',
        ]);
        $one = new Organisation;
        $filePath = $request->organisation_chart->store('organisations', 'public');
        $one = new Organisation;
        $one->company_id = $request->company;
        $one->department_id = $request->department;
        $one->title = $request->title;
        $one->organisation_chart = $filePath;
        $one->save();
        return redirect()->route('organisations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $one = Organisation::findOrFail($id);
        $users = DB::table('usersettings')
        ->leftJoin('users', 'usersettings.user_id', '=', 'users.id')
        ->where('usersettings.depart_id', $one->department_id)
        ->select('users.*')
        ->get();
        return view('organisations.show', compact('one', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $one = Organisation::findOrFail($id);
        $companies = Company::all();
        return view('organisations.edit', compact('one', 'companies'));
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
            'company' => 'required|integer',
            'department' => 'required|integer',
            'title' => 'required|string|max:190',
        ]);

        $one = Organisation::findOrFail($id);
        if ($request->organisation_chart){
            $filePath = public_path().'/assets/'.$one->organisation_chart;
            File::delete( $filePath);
            $filePath = $request->organisation_chart->store('organisations', 'public');
            $one->organisation_chart = $filePath;
        }
        $one->title = $request->title;
        $one->save();
        return redirect()->route('organisations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $one = Organisation::findOrFail($id);
        $filePath = public_path().'/assets/'.$one->organisation_chart;
        File::delete( $filePath);
        $one->delete();
    }
    public function getprofile($id){
        $one = User::findOrFail($id);
        return view('organisations.profile', compact('one'));
    }
}
