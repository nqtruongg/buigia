<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilterType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'filter_types';
    protected $fillable = ['name'];
    protected $guarded = [];
    public function filters()
    {
        return $this->hasMany(Filter::class);
    }

}
