<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic.once', array('only' => array('me')));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return AuthorCollection
     */
    public function index(Request $request) : AuthorCollection
    {
        $perPage = (new User)->getPerPage();
        $currentPage = 1;
        if ($request->query->has('offset'))
        {
            $currentPage = floor($request->query->get('offset') / $perPage)+1;
        }
        $request->query->add(['page'=>$currentPage]);

        return new AuthorCollection(User::paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return AuthorResource
     */
    public function show(Request $request, User $user) : AuthorResource
    {
        return new AuthorResource($user);
    }

    /**
     * Display current user.
     *
     * @return AuthorResource
     */
    public function me() : AuthorResource
    {
        return new AuthorResource(Auth::user());
    }
}
