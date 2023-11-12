<?php

namespace App\Controllers;

use App\Models\Contact;

class HomeController
{
    protected $contact;
    public function __construct()
    {
        $this->contact = new Contact();
    }
    public function index()
    {

        view('home.index', ['contacts' => $this->contact->getAll()]);
    }
}
