<?php

namespace App\Services;

use App\Models\AccountModel;
use App\Models\TransactionModel;
use Illuminate\Database\Eloquent\Builder;

final class TransactionsService extends AbstractService
{
    public function getTransactionsQuery(AccountModel $account): Builder
    {
        return TransactionModel::query()
            ->where('account_id', $account->id);
    }

    public function orderTransactions(Builder $transactionsQuery): Builder
    {
        return $transactionsQuery->orderByDesc('date');
    }
}
