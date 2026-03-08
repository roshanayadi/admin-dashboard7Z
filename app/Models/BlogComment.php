<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $table = 'blog_comments';

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'name',
        'email',
        'comment',
        'status',
        'ip_address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'post_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
