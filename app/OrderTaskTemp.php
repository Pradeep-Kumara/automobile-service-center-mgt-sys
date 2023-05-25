<?php
/**
 * Created by PhpStorm.
 * User: gfonseka
 * Date: 1/16/2021
 * Time: 11:40 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTaskTemp extends Model
{
    protected $table='order_task_detail_temp';
    protected $primaryKey='order_task_temp_line_id';

    public function Item(){
        return $this->hasMany(Item::class,'task_task_id');
    }

    public function Task(){
        return $this->belongsTo(Task::class,'order_task_temp_task_id');
    }
}