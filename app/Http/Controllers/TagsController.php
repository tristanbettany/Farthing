<?php

namespace App\Http\Controllers;

use App\Services\AccountsService;
use App\Services\TagsService;
use Illuminate\Contracts\Support\Renderable;

class TagsController extends Controller
{
    public function getIndex(
        int $accountId,
        AccountsService $accountsService,
        TagsService $tagsService
    ): Renderable {
        $account = $accountsService->getAccount($accountId);

        $tagsQuery = $tagsService->getTagsQuery($account);

        $tagsQuery = $tagsService->orderTags($tagsQuery);

        return view('dashboard.tags.index')
            ->with('tags', $tagsService->paginateRecords($tagsQuery))
            ->with('account', $account);
    }
}
