<?php
pest()->group('PostModel');
describe("Post Model & Factory", function () {
    test("published state should create a post with is_published : true", function () {
        $post = \App\Models\Post::factory()->published()->create();
        $this->assertTrue($post->is_published);
    });

    test("create 6 posts for 3 users should be published and 3 should be drafted", function () {
        $posts = \App\Models\Post::factory()->for(\App\Models\User::factory())->count(6)->sequence(['is_published' => true], ['is_published' => false])->create();
        expect($posts->first()->user)->toBeInstanceOf(\App\Models\User::class);
        $this->assertCount(3, $posts->where('is_published', true));
        $this->assertCount(3, $posts->where('is_published', false));
    });
});
