<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $table = "communes";
    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

}
