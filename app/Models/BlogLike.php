<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogLike extends Model
{
    protected $table = 'blog_likes';

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'ip_address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'post_id');
    }
}
