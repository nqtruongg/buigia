<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

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

    public function customerServices()
    {
        return $this->hasMany(CustomerService::class, 'customer_id');
    }
}
