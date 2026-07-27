<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostApiResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $resource = Post::select(['id', 'title', 'created_at'])->paginate(10);
        $posts = PostApiResource::collection($resource);

        return $posts;
    }
}
