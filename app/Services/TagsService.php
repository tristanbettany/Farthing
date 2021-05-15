<?php

namespace App\Services;

use App\Interfaces\TagsServiceInterface;
use App\Models\Pivots\TransactionTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Support\Collection;

final class TagsService extends AbstractService implements TagsServiceInterface
{
    public function getTag(int $tagId): Tag
    {
        return Tag::where('id', $tagId)
            ->firstOrFail();
    }

    public function getTagsQuery(int $accountId): Builder
    {
        return Tag::query()
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
    ): Tag {
        return Tag::create([
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
    ): Tag {
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

        TransactionTag::query()
            ->where('tag_id', $tagId)
            ->delete();

        $tag->delete();
    }

    public function matchTags(
        Collection $tags,
        string $matchString,
        Closure $closure
    ) {
        foreach ($tags as $tag) {
            $match = preg_match('/' . $tag->regex . '/', $matchString);

            if ($match === 1) {
                $closure($tag);
            }
        }
    }

    public function dropTags(int $accountId): void
    {
        $tags = $this->getTagsQuery($accountId)->get();

        foreach ($tags as $tag) {
            TransactionTag::query('tag_id', $tag->id)
                ->delete();
        }
    }
}
