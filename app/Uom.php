<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    protected $table= 'uom';
    protected $primaryKey='uom_id';

    public function uomRelation(){
        return $this->hasMany(Uom::class,'uom_id');
    }

}