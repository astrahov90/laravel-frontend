<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic.once', array('except' => array('index', 'show')));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  Post  $post
     * @return CommentCollection
     */
    public function index(Request  $request, Post $post) : CommentCollection
    {
        $perPage = (new Comment)->getPerPage();
        $currentPage = 1;
        if ($request->query->has('offset'))
        {
            $currentPage = floor($request->query->get('offset') / $perPage)+1;
        }
        $request->query->add(['page'=>$currentPage]);

        return new CommentCollection(Comment::wherePostId($post->id)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return CommentResource
     */
    public function store(Request $request, Post $post): CommentResource
    {
        $validatedData = $request->validateWithBag('comment', [
            'body' => ['required'],
        ]);

        $comment = new Comment();
        $comment->fill($validatedData);
        $comment->author_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->save();

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @param  Comment  $comment
     * @return CommentResource
     */
    public function show(Post $post, Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }
}
