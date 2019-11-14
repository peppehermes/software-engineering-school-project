<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\User;
use DB;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    public function add()
    {
        $roles = \DB::table('role')->get();

        return view('user.add', ['roles' => $roles]);

    }

    public function store(Request $request)
    {


        $data = request('frm');


        $data['password'] = Hash::make($data['password']);

        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


            $data['photo'] = $fileName;
        }

        DB::table('users')->insertGetId($data);


        return redirect('/user/list');

    }

    public function list()
    {

        $users = DB::table('users')->paginate(10);

        $roles = DB::table('role')->get();


        return view('user.list', ['users' => $users, 'roles' => $roles]);
    }

    public function edit($id)
    {
        $userInfo = DB::table('users')->where(['id' => $id])->first();

        $roles = DB::table('role')->get();


        return view('user.edit', ['userInfo' => $userInfo, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {


        $data = request('frm');
        $password = request('password');

        if ($id) {
            if ($password != '') {
                $data['password'] = Hash::make($password);
            }

            if ($request->file('photo')) {

                $cover = $request->file('photo');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['photo'] = $fileName;
            }
            DB::table('users')->where('id', $id)->update($data);

        }

        return redirect('/user/list');

    }

    public function delete($id)
    {

        DB::table('users')->where('id', $id)->delete();


        return redirect('/user/list');

    }

}
