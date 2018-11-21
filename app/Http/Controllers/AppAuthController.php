<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\DB;

class AppAuthController extends Controller{

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_role_id'=> 3 //Defaults to enumerator 
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        //dd($user->id);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        
        //Remember token
        if($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }


        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(), 
            'user_data' => $this->appUserMarkets($user)
        ]);
    }

    public function appUserMarkets(User $user){
        $query = "SELECT u.id, u.name, um.market_id, m.market_name ";
        $query .= "from users u ";
        $query .= "JOIN user_markets um ON um.user_id = u.id ";
        $query .= "JOIN markets m ON m.id = um.market_id ";
        $query .= "WHERE u.id = $user->id";
       return DB::select(DB::raw($query));
          
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request){
        return response()->json($request->user());
    }

}
