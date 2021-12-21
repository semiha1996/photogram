<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];
    
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
    
    // 1 Post - Many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
