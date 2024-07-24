<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHolder extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'house_holders';
    protected $guarded = [];

    public function services()
    {
        return $this->hasMany(Service::class, 'house_holder_id');
    }
}


