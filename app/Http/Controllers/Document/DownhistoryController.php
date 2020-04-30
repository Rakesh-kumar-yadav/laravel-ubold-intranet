<?php

namespace App\Http\Controllers\Document;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DowwHistory;

class DownhistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $date1 = date('Y-m-01');
        $date2 = date('Y-m-d');
        if (isset($request->daterange))
        {
            if (strpos($request->daterange, ' to ') !== false) {
                $date1 = explode(" to ", $request->daterange)[0];
                $date2 = explode(" to ", $request->daterange)[1];
            }else{
                $date1 = $request->daterange;
                $date2 = $request->daterange;
            }
        }
        if ($date1 == $date2)
        {
            $datas = DowwHistory::whereRaw("DATE(created_at)='".$date1."'")->get();
            return view('documents.history.index', compact('datas', 'request'));
        }else{
            $datas = DowwHistory::whereRaw("DATE(created_at)>='".$date1."' AND DATE(created_at)<='".$date2."'")->get();
            return view('documents.history.index', compact('datas', 'request'));
        }
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
        //
    }
}
