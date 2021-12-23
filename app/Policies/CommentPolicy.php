<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

 
    /**
     * The user, who created the comment can delete it.
     * The user, whose post has been commented can delete the comment
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Comment $comment)
    {
        // User is commenter OR User is the original author of the post.
        return $comment->user_id === $user->id || $comment->post->user->id === $user->id;
    }

}
