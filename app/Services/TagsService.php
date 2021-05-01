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
        return $tagsQuery->orderByDesc('date');
    }
}
