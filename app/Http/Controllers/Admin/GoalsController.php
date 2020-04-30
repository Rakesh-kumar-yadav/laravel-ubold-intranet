<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\Setting;

use File;

class GoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $one = Setting::first();
        return view('admin.goals.show', compact('one'));
    }
    public function create()
    {
        return view('admin.goals.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'our_goal' => 'required|file',
        ]);

        $one = Setting::first();
        $filePath = public_path().'/assets/'.$one->our_goal;
        File::delete( $filePath);
        $filePath = $request->our_goal->store('goals', 'public');
        $one->our_goal = $filePath;
        $one->save();
        return redirect()->route('admin.goals.index');
    }
    public function getContact()
    {
        $one = Setting::first();
        return view('admin.contacts.show', compact('one'));
    }
    public function createContact()
    {
        return view('admin.contacts.create');
    }
    public function storeContact(Request $request)
    {
        $data = $request->validate([
            'contact' => 'required|file',
        ]);

        $one = Setting::first();
        $filePath = public_path().'/assets/'.$one->contact;
        File::delete( $filePath);
        $filePath = $request->contact->store('contacts', 'public');
        $one->contact = $filePath;
        $one->save();
        return redirect('/admin/contacts');
    }
}
