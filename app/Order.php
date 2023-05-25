<?php
/**
 * Created by PhpStorm.
 * User: gfonseka
 * Date: 1/16/2021
 * Time: 11:45 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  
    protected $table= 'order';
    protected $primaryKey='order_id';

    public function JobCard(){
        return $this->hasMany(JobCard::class,'order_order_id');
    }

}