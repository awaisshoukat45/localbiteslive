<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemHasIngredient extends Model
{
    public function ingredient(){
        return $this->belongsTo('App\FoodIngredientItem','food_ingredient_item_id','id');
    }
}
