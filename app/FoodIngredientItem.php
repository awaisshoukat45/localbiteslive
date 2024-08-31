<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodIngredientItem extends Model
{
    public function ingredientGroup(){
        return $this->belongsTo('App\FoodIngredient','food_ingredient_id','id');
    }
}
