<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\DB;
use App\MarketData;

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
        $query = "SELECT u.id, u.name, um.market_id, m.market_name, m.system_id as market_type_id ";
        $query .= "from users u ";
        $query .= "JOIN user_markets um ON um.user_id = u.id ";
        $query .= "JOIN markets m ON m.id = um.market_id ";
        $query .= "WHERE u.id = $user->id";
       return DB::select(DB::raw($query));
          
    }


    public function uploadMarketData(Request $request){
       $input = $request->all();
       $metaData = $input["metaData"];
       $marketData = $input["marketData"];
       $year_name = $metaData["yearName"];
       $month_id = $metaData["month_id"];
       $week = $metaData["week"];
       $market_id = $metaData['marketId'];

       $numberOfRecords = 0;
       foreach($marketData as $indicator_id => $price){
           $data = array();
           $data["year_name"] = $year_name;
           $data["month_id"] = $month_id;
           $data["week"] = $week;
           $data["market_id"] = $market_id;
           $data["indicator_id"] = $indicator_id;
           $data["price"] = $price;
           MarketData::updateOrCreate($data);
           $numberOfRecords ++;  
       }
  
       if($numberOfRecords > 0){
        return response()->json([
            'message' => 'Successfully updated market data!',
            'numberOfRecords' => $numberOfRecords
        ], 201);
       }

    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request){
        return response()->json($request->user());
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
  


}
