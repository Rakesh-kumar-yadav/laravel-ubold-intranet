<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use File;
use DB;
class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ones = Event::all();
        return view('admin.events.index', compact('ones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.create');
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
            'name' => 'required|string|max:190',
            'thumbnail' => 'required|image',
        ]);

        $one = new Event;
        $filePath = $request->thumbnail->store('events', 'public');
        $one->name = $request->name;
        $one->thumbnail = $filePath;
        $one->save();
        return redirect()->route('admin.events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $one = Event::findOrfail($id);
        return view('admin.events.show', compact('one'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $one = Event::findOrFail($id);
        return view('admin.events.edit', compact('one'));
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
            'name' => 'required|string|max:190',
        ]);
        $one = Event::findOrFail($id);
        if ($request->thumbnail){
            $filePath = public_path().'/assets/'.$one->thumbnail;
            File::delete( $filePath);
            $filePath = $request->thumbnail->store('events', 'public');
            $one->thumbnail = $filePath;
        }
        $one->name = $request->name;
        $one->save();
        return redirect()->route('admin.events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $one = Event::findOrFail($id);
        $filePath = public_path().'/assets/'.$one->thumbnail;
        File::delete( $filePath);
        DB::table('galleries')->where('event_id', $id)->delete();

        $one->delete();
    }
}
