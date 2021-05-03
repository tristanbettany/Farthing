<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Services\AccountsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Exception;

class AccountsController extends Controller
{
    public function getIndex(AccountsService $accountsService): Renderable
    {
        $accountsQuery = $accountsService->getAccountsQuery();

        $accountsQuery = $accountsService->orderAccounts($accountsQuery);

        return view('dashboard.accounts.index')
            ->with('accounts', $accountsService->paginateRecords($accountsQuery));
    }

    public function postIndex(
        AccountRequest $request,
        AccountsService $accountsService
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $account = $accountsService->addAccount(
                $validatedInput['name'],
                $validatedInput['sort_code'],
                $validatedInput['account_number']
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Add Account ' . $e->getMessage());
        }

        Session::flash('success', 'Added Account');

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

    public function postView(
        int $accountId,
        AccountRequest $request,
        AccountsService $accountsService
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $account = $accountsService->updateAccount(
                $accountId,
                $validatedInput['name'],
                $validatedInput['sort_code'],
                $validatedInput['account_number']
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Update Account ' . $e->getMessage());
        }

        Session::flash('success', 'Updated Account');

        return redirect('/dashboard/accounts');
    }
}
