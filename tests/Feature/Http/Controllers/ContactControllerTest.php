<?php
pest()->group("ContactController");
describe("contact form", function () {
    test("Form with missing message should fail validation", function () {

        $invalidData = [
            "name" => "Mohab",
            "email" => "mohab@company.com"
        ];

        $response = $this->post(route("contact.store"), $invalidData);

        $response->assertRedirect();
        $response->assertSessionHasErrors([
            "message" => "The message field is required.",
        ]);
    });

    test("Form with non-business email should fail validation", function () {
        $invalidData = [
            "name" => "Mohab",
            "email" => "mohab@gmail.com",
            "message" => "This is a valid message.",
        ];

        $response = $this->post(route("contact.store"), $invalidData);

        $response->assertRedirect();
        $response->assertSessionHasErrors([
            "email" => "The email must be a business email.",
        ]);
    });

    test("Form with all required fields should pass validation", function () {

        $validData = [
            "name" => "Mohab",
            "email" => "mohab@company.com",
            "message" => "Hello"
        ];

        $response = $this->post(route("contact.store"), $validData);
        $response->assertRedirectBack();
        $response->assertSessionHas(["message" => "Sent Successfully"]);
    });
});
