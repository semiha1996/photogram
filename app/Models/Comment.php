<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'text',
    ];
   
    //Relations
    // 1 comments - 1 Post
    public function post() 
    {
        $this->belongsTo(Post::class);
    }
    
    // 1 Comment - 1 User
    public function user() 
    {
        $this->belongsTo(User::class);
    }
}
