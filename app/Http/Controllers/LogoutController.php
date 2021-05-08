<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function getIndex()
    {
        Session::flush();

        return redirect('/');
    }
}
