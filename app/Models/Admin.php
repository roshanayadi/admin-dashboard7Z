<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'role',
        'permissions',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class, 'author_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
