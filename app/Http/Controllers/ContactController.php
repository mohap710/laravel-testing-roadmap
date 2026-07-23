<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(ContactStoreRequest $request)
    {
        $data = $request->validated();
        Contact::create($data);
        return back()->with(["message" => "Sent Successfully"]);
    }
}
