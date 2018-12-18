<?php

namespace App;
use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable{

    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'email_verified',
        'password',
        'user_role_id'];
        
        public function role(){
            return $this->belongsTo('App\UserRole');
        }

    public function isAdmin(){
        $user = Auth::user();
        if ($user->user_role_id == 1) {
            return true;
        }
        return false;
    }

    public function isDataTeam(){
        $user = Auth::user();
        if (in_array($user->user_role_id, [1,2,3,4])) {
            return true;
        }
        return false;
    }


    
}
