<?php
/**
 * Created by PhpStorm.
 * User: gfonseka
 * Date: 1/9/2021
 * Time: 11:13 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table= 'item';
    protected  $primaryKey='item_id';

    public function categoryRelation(){
        return $this->belongsTo(Category::class,'item_category_id');
    }

    public function uomRelation(){
        return $this->belongsTo(Uom::class,'item_uom_id');
    }

    public function OrderItemTemp(){
        return $this->hasMany(OrderItemTemp::class,'order_item_temp_item_id');
    }

    public function JobItemDetailTemp(){
        return $this->hasMany(JobItemDetailTemp::class,'job_item_item_id');
    }


}