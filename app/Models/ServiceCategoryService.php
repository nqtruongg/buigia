<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategoryService extends Model
{
    use HasFactory;

    protected $table = 'service_and_categoryservices';

    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function categoryService()
    {
        return $this->belongsTo(CategoryService::class, 'categoryService_id');
    }
}
