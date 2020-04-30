<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('model_has_roles')->select('model_id')->whereIn('role_id', [1, 2])->get();
        $user_ids = [];
        foreach ($users as $user)
            $user_ids[] = $user->model_id;
        $events = DB::table('lstevent')->whereIn('user_id', $user_ids)->get();
        return view('setting.calendar', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeevtname(Request $request)
    {
        $id =$request->evt_id;
        $user_id = Auth::user()->id;
        $title = $request->title;
        $classname = $request->skin;
        if (intval($id) < 1) {
            $id = DB::table('lstevent')->insert(
                ['user_id' => $user_id, 'title' => $title, 'classname' => 'bg-'.$classname]
            );
        }else{
            DB::table('lstevent')->where('id', $id)->update(
                ['user_id' => $user_id, 'title' => $title, 'classname' => $classname]
            );
        }

        echo DB::getPdo()->lastInsertId();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('lstevent')->where('id', $id)->delete();
        echo "ok";
    }
}
