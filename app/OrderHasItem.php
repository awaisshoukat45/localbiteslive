<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHasItem extends Model
{
    protected  $table = "order_has_items";
    public function item(){
        return $this->belongsTo('App\Items','item_id','id');
    }
    public function itemHasExtras(){
        return $this->hasMany('App\OrderItemHasExtra','order_has_item_id','id')->with('extra');
    }
    public function itemHasSubItems(){
        return $this->hasMany('App\OrderItemHasIngredient','order_has_item_id','id')->with('ingredient');
    }
}
