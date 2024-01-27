<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Requests\User\UserRequest;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')->get();
        if(!$request->ajax()){
            return view('users.index', compact('users'));
        }
        return response()->json(['users'=> $users], 200);
    }


    public function getRoles()
    {
        $roles = Role::pluck('name');
        return response()->json(['roles' => $roles], 200);
    }


    public function store(UserRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = new User($request->all());
            $user->assignRole($request->input('role'));
            $user->save();
            DB::commit();
            if(!$request->ajax()){
                return back()->with('success', 'user created');
            }
            return response()->json(['status'=> 'user created', 'user' => $user], 201);

        } catch(\Throwable $th){
            DB::rollback();
            throw $th;
        }
    }

    public function show(Request $request, User $user)
    {
        if (!$request->ajax()) {
            return view();
        }

        return response()->json(['user' => $user], 200);
    }


    public function edit(User $user)
    {

    }

    public function update(UserRequest $request, User $user)
    {
        try{
            DB::beginTransaction();
            $user -> update($request->all());
            $user->syncRoles([$request->input('role')]);
            DB::commit();
            if(!$request->ajax()){
                return back()->with('success', 'User update');
            }
            return response()->json([], 204);

        } catch(\Throwable $th){
            DB::rollback();
            throw $th;
        }


    }


    public function destroy(Request $request, User $user)
    {
        $user->delete();
        if(!$request->ajax()){
            return back()->with('success', 'User delete');
        }
        return response()->json([], 204);
    }
}
