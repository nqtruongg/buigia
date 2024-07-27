<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'filters';
    protected $fillable = ['filter_type_id', 'min_value', 'max_value', 'exact_value', 'direction'];
    protected $guarded = [];

    public function filterType()
    {
        return $this->belongsTo(FilterType::class);
    }
}
