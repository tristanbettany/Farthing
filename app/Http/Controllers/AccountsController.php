<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class AccountsController extends Controller
{
    public function getIndex(): Renderable
    {
        return view('dashboard.accounts.index');
    }
}
