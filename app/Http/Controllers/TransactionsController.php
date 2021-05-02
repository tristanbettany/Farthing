<?php

namespace App\Http\Controllers;

use App\Services\AccountsService;
use App\Services\TransactionsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;

class TransactionsController extends Controller
{
    public function getIndex(
        int $accountId,
        AccountsService $accountsService,
        TransactionsService $transactionsService
    ): Renderable {
        $account = $accountsService->getAccount($accountId);

        $transactionsQuery = $transactionsService->getTransactionsQuery($account);

        $transactionsQuery = $transactionsService->orderTransactions($transactionsQuery);

        return view('dashboard.transactions.index')
            ->with('transactions', $transactionsService->paginateRecords($transactionsQuery))
            ->with('account', $account);
    }

    public function postIndex(
        int $accountId,
        Request $request,
        AccountsService $accountsService,
        TransactionsService $transactionsService
    ): RedirectResponse {
        $account = $accountsService->getAccount($accountId);

        if ($request->has('upload') === true) {
            try {
                $transactionsService->uploadTransactions(
                    $accountId,
                    $request->get('bank'),
                    $request->file('csv')
                );
            } catch (Exception $e) {
                Session::flash('error', 'Failed To Upload Transactions ' . $e->getMessage());
            }

            Session::flash('success', 'Uploaded Transactions');
        }

        return redirect('/dashboard/accounts/' . $accountId . '/transactions');
    }
}
