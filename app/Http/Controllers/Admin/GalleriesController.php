<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Gallery;
use App\Models\Event;
use File;
class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $event_id = 0;
        $ones = Gallery::leftJoin('events', function($join){
            $join->on('events.id', '=', 'galleries.event_id');
        })
        ->select('galleries.*', 'events.name as eventname')->get();

        if (isset($request->event)){
            $event_id = $request->event;
            if ($event_id != 0){
                $ones = Gallery::leftJoin('events', function($join){
                    $join->on('events.id', '=', 'galleries.event_id');
                })
                ->where('galleries.event_id', '=', $event_id)
                ->select('galleries.*', 'events.name as eventname')->get();
            }
        }
        $events = Event::all();
        return view('admin.galleries.index', compact('events', 'ones', 'event_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ones = Event::all();
        return view('admin.galleries.create', compact('ones'));
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
            'event' => 'required|integer|max:50',
            'title' => 'required|string|max:190',
            'gallery' => 'required|image',
        ]);

        $one = new Gallery;
        $filePath = $request->gallery->store('galleries', 'public');
        $one->event_id = $request->event;
        $one->title = $request->title;
        $one->gallery = $filePath;
        $one->save();
        return redirect()->route('admin.galleries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $one = Gallery::findOrfail($id);
        $ones = Event::all();
        return view('admin.galleries.show', compact('one', 'ones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $one = Gallery::findOrFail($id);
        $ones = Event::all();
        return view('admin.galleries.edit', compact('one', 'ones'));
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
            'event' => 'required|integer|max:50',
            'title' => 'required|string|max:190',
        ]);

        $one = Gallery::findOrFail($id);
        if (isset($request->gallery_image)){
            $filePath = public_path().'/assets/'.$one->gallery;
            File::delete( $filePath);
            $filePath = $request->gallery_image->store('galleries', 'public');
            $one->gallery = $filePath;
        }
        $one->event_id = $request->event;
        $one->title = $request->title;
        $one->save();
        return redirect()->route('admin.galleries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $one = Gallery::findOrFail($id);
        $filePath = public_path().'/assets/'.$one->gallery;
        File::delete( $filePath);
        $one->delete();
    }

    public function showEvent()
    {
        $ones = Event::all();
        return view('admin.galleries.event', compact('ones'));
    }

    public function showGallery($id)
    {
        $ones = Gallery::where('event_id', '=', $id)->get();
        return view('admin.galleries.gallery', compact('ones'));
    }
}
