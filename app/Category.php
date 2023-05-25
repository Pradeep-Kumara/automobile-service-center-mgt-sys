<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    
    public function itemRelation(){
        return $this->hasMany(Item::class,'category_id');
    }

    
}