<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostLikes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic.once', array('except' => array('index', 'show', 'rating')));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return PostCollection
     */
    public function index(Request $request) : PostCollection
    {
        $perPage = (new Post)->getPerPage();
        $currentPage = 1;
        if ($request->query->has('offset'))
        {
            $currentPage = floor($request->query->get('offset') / $perPage)+1;
        }
        $request->query->add(['page'=>$currentPage]);

        return new PostCollection(Post::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return PostResource
     */
    public function store(Request $request) : PostResource
    {
        $validatedData = $request->validateWithBag('post', [
            'title' => ['required', 'max:255'],
            'body' => ['required'],
        ]);

        $post = new Post();
        $post->fill($validatedData);
        $post->author_id = Auth::id();
        $post->save();

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return PostResource
     */
    public function show(Post $post) : PostResource
    {
        return new PostResource($post);
    }

    /**
     * Display Post rating.
     *
     * @param  Post  $post
     * @return int
     */
    public function rating(Post $post) : int
    {
        return $post->rating->sum('rating');
    }

    /**
     * Display Post rating.
     *
     * @param  Post  $post
     * @return Response
     */
    public function like(Post $post) : Response
    {
        $author_id = Auth::id();
        $post_id = $post->id;

        try
        {
            $this->fillPostLike($author_id, $post_id, 1);
        }
        catch (\Throwable $e)
        {
            return response('Post already rated',400);
        }
        return response('', 200);
    }

    /**
     * Display Post rating.
     *
     * @param  Post  $post
     * @return Response
     */
    public function dislike(Post $post) : Response
    {
        $author_id = Auth::id();
        $post_id = $post->id;

        try
        {
            $this->fillPostLike($author_id, $post_id, -1);
        }
        catch (\Throwable $e)
        {
            return response('Post already rated',400);
        }
        return response('', 200);
    }

    private function fillPostLike($author_id, $post_id, $rating): void
    {
        $postLike = new PostLikes();
        $postLike->author_id = $author_id;
        $postLike->post_id = $post_id;
        $postLike->rating = $rating;
        $postLike->saveOrFail();
    }
}
