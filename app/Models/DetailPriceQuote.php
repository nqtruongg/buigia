<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPriceQuote extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_price_quotes';

    protected $guarded = [];

    
}
