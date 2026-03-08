<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $table = 'gallery_items';

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'category',
        'location',
        'views',
        'likes',
        'author_id',
    ];

    protected $casts = [
        'views' => 'integer',
        'likes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }

    public function galleryLikes()
    {
        return $this->hasMany(GalleryLike::class, 'gallery_id');
    }

    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('file_type', 'video');
    }
}
