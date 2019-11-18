<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Role;
use App\User;
use DB;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $roles = Role::retrieve();

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

        User::saveUser($data);


        return redirect('/user/list');

    }

    public function list()
    {

        $users = User::retrievePagination(10);

        $roles = Role::retrieve();


        return view('user.list', ['users' => $users, 'roles' => $roles]);
    }

    public function edit($id)
    {
        if(\Auth::user()->id!=$id && \Auth::user()->roleId !=1){
            return \Redirect('/')->withErrors([' You dont have permission to see that page!']);
        }
        $userInfo = User::retrieveById($id);


        $roles = Role::retrieve();

        $students = Student::retrieveStudentsForParent($id);


        return view('user.edit', ['userInfo' => $userInfo, 'roles' => $roles, 'students' => $students]);
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
            User::saveUser($data, $id);


        }

        return redirect('/user/list');

    }

    public function delete($id)
    {

        User::deleteById($id);


        return redirect('/user/list');

    }

}
