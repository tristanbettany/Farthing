<?php

namespace App\Services;

use App\Models\AccountModel;
use App\Models\TagModel;
use Illuminate\Database\Eloquent\Builder;

final class TagsService extends AbstractService
{
    public function getTag(int $tagId): TagModel
    {
        return TagModel::where('id', $tagId)
            ->firstOrFail();
    }

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

    public function updateTag(
        int $tagId,
        string $name,
        string $regex,
        string $hexCode
    ): TagModel {
        $tag = $this->getTag($tagId);

        $tag->name = $name;
        $tag->regex = $regex;
        $tag->hex_code = $hexCode;

        $tag->save();

        return $tag;
    }
}
