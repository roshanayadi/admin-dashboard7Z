<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryLike extends Model
{
    protected $table = 'gallery_likes';

    public $timestamps = false;

    protected $fillable = [
        'gallery_id',
        'ip_address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function galleryItem()
    {
        return $this->belongsTo(GalleryItem::class, 'gallery_id');
    }
}
