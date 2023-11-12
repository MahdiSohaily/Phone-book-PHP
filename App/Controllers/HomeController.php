<?php

namespace App\Controllers;

use App\Models\Contact;
use Faker\Factory;

class HomeController
{
    protected $contact;

    public function __construct()
    {
        $this->contact = new Contact();
    }
    public function index()
    {
        // // use the factory to create a Faker\Generator instance
        // $faker = Factory::create();

        // for ($counter = 1; $counter < 1000; $counter++) {
        //     $this->contact->create(['name' => $faker->name(), 'mobile' => $faker->phoneNumber(), 'email' => $faker->email()]);
        // }

        view('home.index', ['contacts' => $this->contact->get('*', ['ORDER' => 'created_at'])]); //
    }
}
