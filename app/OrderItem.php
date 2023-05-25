<?php
/**
 * Created by PhpStorm.
 * User: gfonseka
 * Date: 1/16/2021
 * Time: 11:44 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  
    protected $table= 'order_item_detail';
    protected $primaryKey='order_item_detail';

    

}