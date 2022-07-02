<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'About Me'
        ];

        return view('pages/about', $data);
    }
}
