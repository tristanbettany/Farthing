<?php

namespace App\Http\Controllers;

use App\Services\AccountsService;
use Illuminate\Contracts\Support\Renderable;

class AccountsController extends Controller
{
    public function getIndex(AccountsService $accountsService): Renderable
    {
        $accountsQuery = $accountsService->getAccountsQuery();

        return view('dashboard.accounts.index')
            ->with('accounts', $accountsService->paginateRecords($accountsQuery));
    }
}
