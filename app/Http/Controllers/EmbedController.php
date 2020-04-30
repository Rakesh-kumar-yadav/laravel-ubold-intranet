<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Embed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmbedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dttoday = date("Y-m-d");
        $ones = Embed::where('due_date', '>=', $dttoday)->get();
        return view('embeds.index', compact('ones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('embeds.create');
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
            'form_name' => 'required|string|max:190',
            'due_date' => 'required|date',
            'embed_html' => 'required',
            'depart_ids' => 'required',
        ]);

        $one = new Embed;
        $one->form_name = $request->form_name;
        $one->due_date = $request->due_date;
        $one->embed_html = $request->embed_html;
        $one->save();

        $depart_ids = explode(",", $request->depart_ids);
        foreach ($depart_ids as $depart_id)
        {
            if (strpos($depart_id, "_") !== false) continue;
            $created_user_id = Auth::user()->id;
            $embed_id = $one->id;
            $users = DB::table("usersettings")->select("user_id", "depart_id")->where("depart_id", $depart_id)->get();
            foreach ($users as $user)
            {
                $one_noti = new \App\Models\Notification;
                $one_noti->user_id = $user->user_id;
                $one_noti->depart_id = $depart_id;
                $one_noti->docu_id = 0;
                $one_noti->revision_id = 0;
                $one_noti->embed_id = $embed_id;
                $one_noti->docu_name = "";
                $one_noti->due_date = $request->due_date;
                $one_noti->created_user_id = $created_user_id;
                $one_noti->save();
            }

        }

        return redirect()->route('embeds.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $one = Embed::find($id);
        return view('embeds.show', compact('one'));
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
        $one = Embed::find($id);
        $one->delete();
        \App\Models\Notification::where('embed_id', $id)->delete();
    }

    public function confirm(Request $request, $id)
    {
        $data = $request->validate([
            'customCheck3' => 'required',
        ]);
        $notification = \App\Models\Notification::find($id);
        $notification->confirm = 1;
        $notification->save();
        return redirect()->route('embeds.index');
    }
    public function view($id)
    {
        $notification = \App\Models\Notification::find($id);
        if(!isset($notification->user_id))
            return redirect()->route('embeds.index');
        if(intval($notification->embed_id) < 1)
            return redirect()->route('embeds.index');
        if($notification->user_id != Auth::user()->id)
            return redirect()->route('embeds.index');
        else
            return view('embeds.confirm', compact('notification'));
    }
    public function history(Request $request, $id){
        $notifications = DB::table("notifications AS noti")->select('noti.*')
            ->leftJoin("departments AS depart", "depart.id", "=", "noti.depart_id")
            ->leftJoin("companies AS company", "company.id", "=", "depart.company_id")
            ->leftJoin("embeds AS embed", "embed.id", "=", "noti.embed_id")
            ->addSelect('company.company_name', 'depart.department_name', 'embed.due_date', 'embed.form_name');
        if (isset($request->company) && $request->company != "0")
        {
            $notifications = $notifications->where('company.id', $request->company);
        }
        if (isset($request->department) && $request->department != "0")
        {
            $notifications = $notifications->where('depart.id', $request->department);
        }
        if (isset($request->due_date) && $request->due_date != "")
        {
            $notifications = $notifications->where('embed.due_date', $request->due_date);
        }
        if (isset($request->form_name) && $request->form_name != "")
        {
            $notifications = $notifications->where('embed.form_name', $request->form_name);
        }
        $notifications = $notifications->where('noti.embed_id', '<>', '0')->orderBy('noti.id')->get();
        $companies = \App\Models\Company::all();
        return view('embeds.admin_index', compact('notifications', 'companies', 'request'));
    }
}
