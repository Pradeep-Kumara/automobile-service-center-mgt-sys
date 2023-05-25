<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table='role';
    protected $primaryKey='role_id';

     public function userRelation(){
         return $this->hasMany(User::class,'role_id');
     }

}