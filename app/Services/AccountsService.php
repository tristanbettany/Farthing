<?php

namespace App\Services;

use App\Interfaces\AccountsInterface;
use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

final class AccountsService extends AbstractService implements AccountsInterface
{
    public function getAccount(int $accountId): Account
    {
        return Account::where('id', $accountId)
            ->firstOrFail();
    }

    public function getAccountsQuery(): Builder
    {
        return Account::query()
            ->where('user_id', Auth::id());
    }

    public function orderAccounts(Builder $accountsQuery): Builder
    {
        return $accountsQuery->orderByDesc('created_at');
    }

    public function addAccount(
        string $name,
        string $sortCode,
        string $accountNumber
    ): Account {
        return Account::create([
            'name' => $name,
            'sort_code' => $sortCode,
            'account_number' => $accountNumber,
            'user_id' => Auth::id(),
        ]);
    }

    public function updateAccount(
        int $accountId,
        string $name,
        string $sortCode,
        string $accountNumber
    ): Account {
        $account = $this->getAccount($accountId);

        $account->name = $name;
        $account->sort_code = $sortCode;
        $account->account_number = $accountNumber;

        $account->save();

        return $account;
    }
}
