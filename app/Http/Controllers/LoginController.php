<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class LoginController extends Controller
{
    public function getIndex(): Renderable
    {
        return view('login');
    }
}
