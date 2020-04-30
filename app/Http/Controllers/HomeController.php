<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Todo;
use App\User;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $permission = DB::table('model_has_roles')
                    ->leftJoin('role_has_permissions', 'model_has_roles.role_id', '=', 'role_has_permissions.role_id')
                    ->leftJoin('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('model_has_roles.model_id', '=', $user_id)
                    ->pluck('name')[0];
        return view('home');
    }

    public  function usersetting()
    {
        $users = User::all();
        return view('admin.usersetting', compact('users'));
    }

    public function savepro(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->hasFile('customFile')) {
            if (!file_exists(public_path('assets/images/users'))) {
                mkdir(public_path('assets/images/users'), 0777);
            }
            $file     = $request->file('customFile');
            $filename = $id.'.'.$file->extension();
            $file->move(public_path('assets/images/users'), $filename);
            $user->photo = 'assets/images/users/'.$filename;
        }

        $user->name = $request->name;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->birth = $request->birth;
        $user->contact_number = $request->contact_number;
        $user->extension_number = $request->extension_number;
        $user->mobile_number = $request->mobile_number;
        $user->save();
        return redirect('/profile');
    }
    public function changepwd(Request $request, $id)
    {
        $request->validate([
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();
        $message = "Password was changed successfully!";
        return redirect('/profile');
    }
    public function getTodo()
    {
        $user_id = Auth()->user()->id;
        $todos = Todo::where('user_id', '=', $user_id)->get();
        $datas = [];
        foreach ($todos as $todo){
            $data = [];
            $data['id'] = $todo->id;
            $data['text'] = $todo->todo_name;
            if ($todo->status == 1)
                $data['done'] = !0;
            else
                $data['done'] = !1;
            array_push($datas, $data);
        }
        
        return json_encode($datas);
    }
    public function addTodo(Request $request)
    {
        $user_id = Auth()->user()->id;
        $one = new Todo;
        $one->user_id = $user_id;
        $one->todo_name = $request->text;
        $one->save();
    }
    public function updateTodo(Request $request)
    {
        $one = Todo::find($request->id);
        $one->status = $request->status;
        $one->save();
    }
    public function deleteTodo()
    {
        Todo::where('status', '=', 1)->delete();
    }
}
