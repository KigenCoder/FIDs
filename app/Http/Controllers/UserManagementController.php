<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Market;
use App\UserRole;
use App\Http\Requests\UserRequest;
use App\UserMarket;

class UserManagementController extends Controller {
public function __construct() {
    $this->middleware("admin");
}

public function index() {
    $data = array();
    $data["users"] = User::all();
    return view("users.index", $data);
}


public function create() {
    $data = array();
    $data["user_roles"] = UserRole::where('id', '>', 1)->get();
    $data["markets"] = Market::all();
    return view("users.create", $data);
}


public function store(UserRequest $request) {
    $input = $request-> all();
    $user = array();
    $user['name'] = $input["name"];
    $user['email'] = $input["email"];
    $user['password'] =bcrypt($input['password']);
    $user['user_role_id'] = $input["user_role_id"];
    $user_id = User::create($user)->id;
    
    
    if($input['market_id']>0){
        $user_market = array();
        $user_market['user_id'] = $user_id;
        $user_market['market_id'] = $input["market_id"];
        UserMarket::create($user_market);
    }
    
    return redirect('user');

}


public function show($id) {
//
}


public function edit($id) {
//
}

/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, $id) {
//
}

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function destroy($id) {
//
}
}
