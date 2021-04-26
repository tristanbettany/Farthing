<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class TagsController extends Controller
{
    public function getIndex(): Renderable
    {
        return view('dashboard.tags.index');
    }
}
