<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionBonus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'commission_bonuses';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customerService()
    {
        return $this->belongsTo(CustomerService::class, 'customer_service_id');
    }
}
