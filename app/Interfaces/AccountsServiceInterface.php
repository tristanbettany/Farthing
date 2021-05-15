<?php

namespace App\Interfaces;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;

interface AccountsServiceInterface
{
    public function getAccount(int $accountId): Account;

    public function getAccountsQuery(): Builder;

    public function orderAccounts(Builder $accountsQuery): Builder;

    public function addAccount(
        string $name,
        string $sortCode,
        string $accountNumber
    ): Account;

    public function updateAccount(
        int $accountId,
        string $name,
        string $sortCode,
        string $accountNumber
    ): Account;
}
