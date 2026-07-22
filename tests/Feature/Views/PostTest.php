<?php

use App\Models\Post;
use App\Models\User;

pest()->group("PostView");

test('The /posts/{post} route returns posts/show view', function () {
    $user = User::factory()->create();

    $post = Post::factory()->for($user)->create([
        "title" => "This is my first View test"
    ]);
    $response = $this->get(route('post.show', $post));

    $response->assertViewIs('posts.show')->assertViewHas('post', function (Post $post) use ($user) {
        return $post->user->name == $user->name;
    });
});
