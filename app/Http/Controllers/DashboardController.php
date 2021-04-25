<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    public function getIndex(): Renderable
    {
        return view('dashboard.index');
    }
}
