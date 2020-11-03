<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Market;
use App\UserRole;
use App\Http\Requests\UserRequest;
use App\UserMarket;

class UserAnalystController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create()
    {
        $data = array();
        $data["user_roles"] = UserRole::where('id', '>', 1)->get();
        $data["markets"] = Market::all();
        return view("users.create_analyst", $data);
    }


    public function store(UserRequest $request)
    {
        $input = $request->all();
        $user = array();
        $user['name'] = $input["name"];
        $user['email'] = $input["email"];
        $user['password'] = bcrypt($input['password']);
        $user['user_role_id'] = 3; //Default to Field analyst
        $user_id = User::create($user)->id;




        return redirect('login');


    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


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
