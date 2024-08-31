<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extras extends Model
{
    use SoftDeletes;
    protected $table = 'extras';

    public function item()
    {
        return $this->hasOne('App\Items','id','item_id');
    }
    public function extrasGroup()
    {
        return $this->belongsTo('App\ExtraGroup','extra_group_id','id');
    }
}
