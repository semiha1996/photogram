<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\StoreCommentRequest;
use \Illuminate\Http\Request;
use App\Events\NewCommentEvent;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $post = Post::findOrFail($request->post);
        $validated = $request->validated();   
        $comment = new Comment();
        $comment->text = strip_tags($validated['text']);
        $comment->user()->associate(auth()->user());
        $comment->post()->associate($post->id);
        try {
            $comment->saveOrFail();
            
             NewCommentEvent::dispatch($comment->post, auth()->user());
             
             return redirect()->route('post.show', ['post' => $post->id]);
            //return redirect()->route('post', ['user' => auth()->user()]);//?????
        } catch (\Throwable $ex) {
            if ($comment->id) {
                $comment->delete();
            }
            
            return redirect()->back()->withErrors([$ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        if($request->user()->cannot('delete', $comment)){
            abort(403);
        }
        if ($comment->delete()) {
            $responseCode = 200;
            $responseResult = "Deletion was sucessfull";
        } else {
            $responseCode = 500;
            $responseResult = "Deletion failed";
        }
        
        return response(['result' => $responseResult], $responseCode);
    }
    
}
