<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $table = 'blog_posts';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'author_id',
        'status',
        'views',
        'likes',
    ];

    protected $casts = [
        'views' => 'integer',
        'likes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'post_id');
    }

    public function blogLikes()
    {
        return $this->hasMany(BlogLike::class, 'post_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
