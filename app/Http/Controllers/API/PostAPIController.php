<?php

namespace App\Http\Controllers\API;

use App\Events\PostCreated;
use App\Events\PostUpdated;
use App\Events\PostDeleted;

use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Http\Requests\API\StorePostAPIRequest;
use App\Http\Requests\API\UpdatePostAPIRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Response;
use App\Http\Controllers\AppBaseController;

class PostAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts),'Post retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostAPIRequest $request)
    {
        $input = $request->all();

        $post = Post::create($input);

        PostCreated::dispatch($post);
        return $this->sendResponse(new PostResource($post), 'Post saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);

        if(empty($post)) {
            return $this->sendError('Post not found');
        }

        return $this->sendResponse(new PostResource($post),'Post shown successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdatePostAPIRequest $request)
    {
        $input = $request->all();
        $post = Post::find($id);

        if(empty($post)) {
            return $this->sendError('Post not found');
        }

         $post -> fill($input);
        $post->save();

        PostUpdated::dispatch($post);
        return $this->sendResponse($post->toArray(),'Post updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(empty($post)) {
            return $this->sendError('Post not found.');
        }

        $post->delete();
        PostDeleted::dispatch($post);
        return $this->sendSuccess('Post deleted successfully');
    }
}
