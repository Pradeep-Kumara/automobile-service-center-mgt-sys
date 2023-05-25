<?php
/**
 * Created by PhpStorm.
 * User: gfonseka
 * Date: 1/9/2021
 * Time: 11:13 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class JobTaskDetailTemp extends Model
{
    protected $table= 'job_task_detail_temp';
    protected  $primaryKey='job_task_temp_line_id';

    public function categoryRelation(){
        return $this->belongsTo(Category::class,'item_category_id');
    }

    public function uomRelation(){
        return $this->belongsTo(Uom::class,'item_uom_id');
    }

    public function OrderItemTemp(){
        return $this->hasMany(OrderItemTemp::class,'order_item_temp_item_id');
    }

    public function Task(){
        return $this->belongsTo(Task::class,'job_task_task_id');
    }


}