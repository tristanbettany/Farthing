<?php

namespace App\Services;

use App\Models\AccountModel;
use Illuminate\Database\Eloquent\Builder;

final class AccountsService extends AbstractService
{
    public function getAccount(int $accountId): AccountModel
    {
        return AccountModel::where('id', $accountId)
            ->firstOrFail();
    }

    public function getAccountsQuery(): Builder
    {
        return AccountModel::query();
    }

    public function orderAccounts(Builder $accountsQuery): Builder
    {
        return $accountsQuery->orderByDesc('created_at');
    }

    public function addAccount(
        string $name,
        string $sortCode,
        string $accountNumber
    ): AccountModel {
        return AccountModel::create([
            'name' => $name,
            'sort_code' => $sortCode,
            'account_number' => $accountNumber,
        ]);
    }

    public function updateAccount(
        int $accountId,
        string $name,
        string $sortCode,
        string $accountNumber
    ): AccountModel {
        $account = $this->getAccount($accountId);

        $account->name = $name;
        $account->sort_code = $sortCode;
        $account->account_number = $accountNumber;

        $account->save();

        return $account;
    }
}