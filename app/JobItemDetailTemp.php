<?php
/**
 * Created by PhpStorm.
 * User: gfonseka
 * Date: 1/9/2021
 * Time: 11:13 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class JobItemDetailTemp extends Model
{
    protected $table= 'job_item_detail_temp';
    protected  $primaryKey='job_item_temp_line_id';

    public function Item(){
        return $this->belongsTo(Item::class,'job_item_item_id');
    }

   

}