<?php

pest()->group('PostsApi');
test('/post return a list of posts with titles', function () {
    $post = \App\Models\Post::factory()->create([
        'title' => 'My first post'
    ]);
    $response = $this->get('/api/posts');
    $response->assertJsonStructure([
        "data" => [
            "*" => ["id", "title", "created_at"]
        ],
        'links' => ['first', 'last', 'prev', 'next'],
        'meta' => ['current_page', 'total']
    ]);

    $response->assertJsonFragment([
        "title" => $post->title
    ]);
});
