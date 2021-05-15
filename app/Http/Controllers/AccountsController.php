<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Services\AccountsServiceService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Exception;

class AccountsController extends Controller
{
    public function __construct(
        private AccountsServiceService $accountsService
    ){}

    public function getIndex(): Renderable
    {
        $accountsQuery = $this->accountsService->getAccountsQuery();

        $accountsQuery = $this->accountsService->orderAccounts($accountsQuery);

        return view('dashboard.accounts.index')
            ->with('accounts', $this->accountsService->paginateRecords($accountsQuery));
    }

    public function postIndex(AccountRequest $request): RedirectResponse
    {
        $validatedInput = $request->validated();

        try {
            $account = $this->accountsService->addAccount(
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

    public function getView(int $accountId): Renderable
    {
        $account = $this->accountsService->getAccount($accountId);

        return view('dashboard.accounts.view')
            ->with('account', $account);
    }

    public function postView(
        int $accountId,
        AccountRequest $request
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $account = $this->accountsService->updateAccount(
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
