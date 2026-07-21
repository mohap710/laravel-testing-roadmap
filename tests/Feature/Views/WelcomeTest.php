<?php
pest()->group('welcome');

describe('home', function () {
    it('Should return a page with "Welcome" word in it', function () {
        $response = $this->get('/');
        $response->assertStatus(200)->assertSeeText("Welcome");
    });

    it('Should not contain Vue', function () {
        $response = $this->get('/');
        $response->assertStatus(200)->assertDontSeeText("Vue");
    });

    it('Should return "Welcome" then "Laravel" then "Mohab"', function () {
        $response = $this->get('/');
        $response->assertStatus(200)->assertSeeTextInOrder([
            "Welcome",
            "Laravel",
            "Mohab"
        ]);
    });
});
