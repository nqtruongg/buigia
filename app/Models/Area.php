<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'areas';
    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function parent()
    {
        return $this->belongsTo(Area::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(Area::class, 'parent_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'area_id');
    }
}
