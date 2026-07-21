<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
pest()->group('PostController');

describe('PostController', function () {
    test("show methods returns a successful response if post found", function () {
        $post = \App\Models\Post::factory()->create(["title" => "how to test controllers"]);
        $this->get(route('post.show', $post))->assertStatus(200);
    });

    test("show methods returns a 404 response if post not found", function () {

        $post = new \App\Models\Post();
        $post->title = "This is not saved to DB";
        // $post->save();
        $this->get(route('post.show', ["post" => "not found post"]))->assertNotFound();
    });
});
