<?php

namespace App\Interfaces;

use App\Models\Tag;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface TagsInterface
{
    public function getTag(int $tagId): Tag;

    public function getTagsQuery(int $accountId): Builder;

    public function orderTags(Builder $tagsQuery): Builder;

    public function addTag(
        int $accountId,
        string $name,
        string $regex,
        string $hexCode
    ): Tag;

    public function updateTag(
        int $tagId,
        string $name,
        string $regex,
        string $hexCode
    ): Tag;

    public function deleteTag(int $tagId): void;

    public function matchTags(
        Collection $tags,
        string $matchString,
        Closure $closure
    );

    public function dropTags(int $accountId): void;
}
