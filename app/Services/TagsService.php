<?php

namespace App\Services;

use App\Models\AccountModel;
use App\Models\TagModel;
use Illuminate\Database\Eloquent\Builder;

final class TagsService extends AbstractService
{
    public function getTagsQuery(AccountModel $account): Builder
    {
        return TagModel::query()
            ->where('account_id', $account->id);
    }

    public function orderTags(Builder $tagsQuery): Builder
    {
        return $tagsQuery->orderByDesc('updated_at');
    }

    public function addTag(
        int $accountId,
        string $name,
        string $regex,
        string $hexCode
    ): TagModel {
        return TagModel::create([
            'account_id' => $accountId,
            'name' => $name,
            'regex' => $regex,
            'hex_code' => $hexCode,
            'is_active' => true,
        ]);
    }
}
