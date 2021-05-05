<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\AccountsService;
use App\Services\TransactionsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use DateTimeImmutable;

class TransactionsController extends Controller
{
    public function getIndex(
        int $accountId,
        Request $request,
        AccountsService $accountsService,
        TransactionsService $transactionsService
    ): Renderable {
        $account = $accountsService->getAccount($accountId);

        $transactionsQuery = $transactionsService->getTransactionsQuery($accountId);

        if ($request->has('filter') === true) {
            try {
                $transactionsQuery = $transactionsService->filterTransactionsByDate(
                    $transactionsQuery,
                    new DateTimeImmutable($request->get('date-from')),
                    new DateTimeImmutable($request->get('date-to'))
                );
            } catch (Exception $e) {
                Session::flash('error', 'Failed To Filter Transactions ' . $e->getMessage());
            }

            Session::flash('success', 'Showing Filtered Transactions');
        }

        $transactionsQuery = $transactionsService->orderTransactions($transactionsQuery);

        return view('dashboard.transactions.index')
            ->with('transactions', $transactionsService->paginateRecords($transactionsQuery))
            ->with('account', $account);
    }

    public function postIndex(
        int $accountId,
        Request $request,
        TransactionsService $transactionsService
    ): RedirectResponse {
        if ($request->has('add') === true) {
            try {
                $transactionsService->addTransaction(
                    $accountId,
                    new DateTimeImmutable($request->get('date')),
                    (float) $request->get('amount'),
                    $request->get('type'),
                    $request->get('name'),
                );

                $transactionsService->recalculateRunningTotals($accountId);
            } catch (Exception $e) {
                Session::flash('error', 'Failed To Add Transaction ' . $e->getMessage());
            }

            Session::flash('success', 'Added Transaction');
        }

        if ($request->has('upload') === true) {
            try {
                $transactionsService->uploadTransactions(
                    $accountId,
                    $request->get('bank'),
                    $request->file('csv')
                );

                $transactionsService->recalculateRunningTotals($accountId);
            } catch (Exception $e) {
                Session::flash('error', 'Failed To Upload Transactions ' . $e->getMessage());
            }

            Session::flash('success', 'Uploaded Transactions');
        }

        return redirect('/dashboard/accounts/' . $accountId . '/transactions');
    }

    public function getView(
        int $accountId,
        int $transactionId,
        AccountsService $accountsService,
        TransactionsService $transactionsService
    ): Renderable {
        $account = $accountsService->getAccount($accountId);
        $transaction = $transactionsService->getTransaction($transactionId);

        return view('dashboard.transactions.view')
            ->with('account', $account)
            ->with('transaction', $transaction);
    }

    public function postView(
        int $accountId,
        int $transactionId,
        TransactionRequest $request,
        TransactionsService $transactionsService
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $transaction = $transactionsService->updateTransaction(
                $transactionId,
                $validatedInput['name'],
                (float) $validatedInput['amount'],
                new DateTimeImmutable($validatedInput['date'])
            );

            $transactionsService->recalculateRunningTotals($accountId);
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Update Transaction ' . $e->getMessage());
        }

        Session::flash('success', 'Updated Transaction');

        return redirect('/dashboard/accounts/' . $accountId . '/transactions');
    }

    public function getDelete(
        int $accountId,
        int $transactionId,
        TransactionsService $transactionsService
    ): RedirectResponse {
        try {
            $transactionsService->deleteTransaction($transactionId);
            $transactionsService->recalculateRunningTotals($accountId);
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Delete Transaction ' . $e->getMessage());
        }

        Session::flash('success', 'Deleted Transaction');

        return redirect('/dashboard/accounts/' . $accountId . '/transactions');
    }
}
