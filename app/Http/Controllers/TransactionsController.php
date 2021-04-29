<?php

namespace App\Http\Controllers;

use App\Services\AccountsService;
use App\Services\TransactionsService;
use Illuminate\Contracts\Support\Renderable;

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
}
