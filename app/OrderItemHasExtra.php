<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemHasExtra extends Model
{
    public function extra(){
        return $this->belongsTo('App\Extras','extra_id','id');
    }
}
