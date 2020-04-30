<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use File;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memos = Memo::all();
        return view('memos.index', compact('memos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('memos.create');
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
            'title' => 'required|string|max:190',
            'addtional_file' => 'required|file',
        ]);
        $filePath = $request->addtional_file->store('memos', 'public');
        $one = new Memo;
        $one->title = $request->title;
        $one->real_name = $request->addtional_file->getClientOriginalName();
        $one->file_path = $filePath;
        $one->save();

        return redirect()->route('memos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $one = Memo::findOrFail($id);
        return view('memos.show', compact('one'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $one = Memo::findOrFail($id);

        return view('memos.edit', compact('one'));
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
            'title' => 'required|string|max:190',
        ]);
        
        $one = Memo::findOrFail($id);
        if ($request->addtional_file){
            $filePath = public_path().'/assets/'.$one->file_path;
            File::delete( $filePath);
            $filePath = $request->addtional_file->store('memos', 'public');
            $one->file_path = $filePath;
            $one->real_name = $request->addtional_file->getClientOriginalName();
        }
        
        $one->title = $request->title;
        $one->save();

        return redirect()->route('memos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $one = Memo::findOrFail($id);
        $filePath = public_path().'/assets/'.$one->file_path;
        File::delete( $filePath);
        $one->delete();
    }
}
