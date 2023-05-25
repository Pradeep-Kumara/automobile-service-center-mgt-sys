<?php
/**
 * Created by PhpStorm.
 * User: gfonseka
 * Date: 1/5/2021
 * Time: 11:28 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';

    public function vehicleRelation(){
        return $this->hasMany(Vehicle::class,'customer_id');
    }
}