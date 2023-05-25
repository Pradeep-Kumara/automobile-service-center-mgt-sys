<?php
/**
 * Created by PhpStorm.
 * User: gfonseka
 * Date: 1/16/2021
 * Time: 11:44 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  
    protected $table= 'task';
    protected $primaryKey='task_id';

    public function OrderTaskTemp(){
        return $this->hasMany(OrderTaskTemp::class,'order_task_temp_task_id');
    }

    public function JobTaskDetailTemp(){
        return $this->hasMany(JobTaskDetailTemp::class,'job_task_task_id');
    }

}