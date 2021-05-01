<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAccountRequest;
use App\Services\AccountsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class AccountsController extends Controller
{
    public function getIndex(AccountsService $accountsService): Renderable
    {
        $accountsQuery = $accountsService->getAccountsQuery();

        return view('dashboard.accounts.index')
            ->with('accounts', $accountsService->paginateRecords($accountsQuery));
    }

    public function postIndex(
        AddAccountRequest $request,
        AccountsService $accountsService
    ): RedirectResponse {
        $validatedInput = $request->validated();

        $account = $accountsService->addAccount(
            $validatedInput['name'],
            $validatedInput['sort_code'],
            $validatedInput['account_number']
        );

        return redirect('/dashboard/accounts');
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
