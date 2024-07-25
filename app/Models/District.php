<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table="districts";
    protected $guarded = [];

    public function communes(){
       return $this->hasMany(Commune::class,'district_id','id');
    }
    public function city(){
      return  $this->belongsTo(City::class,'city_id','id');
    }
}
