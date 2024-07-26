<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts_cate';
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryPost::class, 'category_id');
    }
}