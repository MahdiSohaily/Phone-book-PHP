<?php

namespace App\Controllers;

class ContactController
{
    public function add()
    {
        global $request;

        echo $request->input('page');
    }
}
