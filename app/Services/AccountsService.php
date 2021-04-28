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
}
