<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class TemplatesController extends Controller
{
    public function getIndex(): Renderable
    {
        return view('dashboard.templates.index');
    }
}
