<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\AccountsServiceService;
use App\Services\TransactionsServiceService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use DateTimeImmutable;

class TransactionsController extends Controller
{
    public function __construct(
        private AccountsServiceService $accountsService,
        private TransactionsServiceService $transactionsService
    ){}

    public function getIndex(
        int $accountId,
        Request $request
    ): Renderable {
        $account = $this->accountsService->getAccount($accountId);

        $transactionsQuery = $this->transactionsService->getTransactionsQuery($accountId);

        if ($request->has('filter') === true) {
            try {
                $transactionsQuery = $this->transactionsService->filterTransactionsByDate(
                    $transactionsQuery,
                    new DateTimeImmutable($request->get('date-from')),
                    new DateTimeImmutable($request->get('date-to'))
                );
            } catch (Exception $e) {
                Session::flash('error', 'Failed To Filter Transactions ' . $e->getMessage());
            }

            Session::flash('success', 'Showing Filtered Transactions');
        }

        $transactionsQuery = $this->transactionsService->orderTransactions($transactionsQuery);

        if (
            $request->has('page') === false
            && $request->has('filter') === false
        ) {
            $page = $this->transactionsService->determineStartPage($accountId);
        }

        return view('dashboard.transactions.index')
            ->with('transactions', $this->transactionsService->paginateRecords($transactionsQuery, $page ?? null))
            ->with('account', $account);
    }

    public function postIndex(
        int $accountId,
        Request $request
    ): RedirectResponse {
        if ($request->has('add') === true) {
            try {
                $this->transactionsService->addTransaction(
                    $accountId,
                    new DateTimeImmutable($request->get('date')),
                    (float) $request->get('amount'),
                    $request->get('type'),
                    $request->get('name'),
                );

                $this->transactionsService->recalculateRunningTotals($accountId);
            } catch (Exception $e) {
                Session::flash('error', 'Failed To Add Transaction ' . $e->getMessage());
            }

            Session::flash('success', 'Added Transaction');
        }

        if ($request->has('upload') === true) {
            try {
                $this->transactionsService->uploadTransactions(
                    $accountId,
                    $request->get('bank'),
                    $request->file('csv')
                );

                $this->transactionsService->recalculateRunningTotals($accountId);
            } catch (Exception $e) {
                Session::flash('error', 'Failed To Upload Transactions ' . $e->getMessage());
            }

            Session::flash('success', 'Uploaded Transactions');
        }

        return redirect('/dashboard/accounts/' . $accountId . '/transactions');
    }

    public function getView(
        int $accountId,
        int $transactionId
    ): Renderable {
        $account = $this->accountsService->getAccount($accountId);
        $transaction = $this->transactionsService->getTransaction($transactionId);

        return view('dashboard.transactions.view')
            ->with('account', $account)
            ->with('transaction', $transaction);
    }

    public function postView(
        int $accountId,
        int $transactionId,
        TransactionRequest $request
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $transaction = $this->transactionsService->updateTransaction(
                $transactionId,
                $validatedInput['name'],
                (float) $validatedInput['amount'],
                new DateTimeImmutable($validatedInput['date'])
            );

            $this->transactionsService->recalculateRunningTotals($accountId);
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Update Transaction ' . $e->getMessage());
        }

        Session::flash('success', 'Updated Transaction');

        return redirect('/dashboard/accounts/' . $accountId . '/transactions');
    }

    public function getDelete(
        int $accountId,
        int $transactionId
    ): RedirectResponse {
        try {
            $this->transactionsService->deleteTransaction($transactionId);
            $this->transactionsService->recalculateRunningTotals($accountId);
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Delete Transaction ' . $e->getMessage());
        }

        Session::flash('success', 'Deleted Transaction');

        return redirect('/dashboard/accounts/' . $accountId . '/transactions');
    }
}
