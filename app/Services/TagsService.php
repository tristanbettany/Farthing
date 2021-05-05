<?php

namespace App\Services;

use App\Models\Pivots\TransactionTagPivot;
use App\Models\TagModel;
use Illuminate\Database\Eloquent\Builder;

final class TagsService extends AbstractService
{
    public function getTag(int $tagId): TagModel
    {
        return TagModel::where('id', $tagId)
            ->firstOrFail();
    }

    public function getTagsQuery(int $accountId): Builder
    {
        return TagModel::query()
            ->where('account_id', $accountId);
    }

    public function orderTags(Builder $tagsQuery): Builder
    {
        return $tagsQuery->orderByDesc('created_at');
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

    public function deleteTag(int $tagId): void
    {
        $tag = $this->getTag($tagId);

        TransactionTagPivot::query()
            ->where('tag_id', $tagId)
            ->delete();

        $tag->delete();
    }
}
