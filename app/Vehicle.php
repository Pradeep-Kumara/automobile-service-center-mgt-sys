<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicle'; 
    protected $primaryKey = 'vehicle_id';

    public function customerRelation(){
        return $this->belongsTo(Customer::class,'vehicle_customer_id');
    }

}