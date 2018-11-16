<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model{
    protected $fillable = ['user_role'];

    public function users(){
        return $this->hasMany('App\User');
    }
}
