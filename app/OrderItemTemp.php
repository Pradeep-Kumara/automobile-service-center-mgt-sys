<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemTemp extends Model
{
    protected $table= 'order_item_detail_temp';
    protected  $primaryKey='order_item_temp_line_id';
    
    public function Item(){
        return $this->belongsTo(Item::class,'order_item_temp_item_id');
    }
}