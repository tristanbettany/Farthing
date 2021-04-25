<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class TransactionsController extends Controller
{
    public function getIndex(): Renderable
    {
        return view('dashboard.transactions.index');
    }
}
