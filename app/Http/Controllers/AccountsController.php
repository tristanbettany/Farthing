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

    public function getView(
        int $accountId,
        AccountsService $accountsService
    ): Renderable {
        $account = $accountsService->getAccount($accountId);

        return view('dashboard.accounts.view')
            ->with('account', $account);
    }
}
