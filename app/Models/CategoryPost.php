<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_posts';

    protected $guarded = [];
    public function childs()
    {
        return $this->hasMany(CategoryPost::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->childs()->with('childrenRecursive');
    }

}
