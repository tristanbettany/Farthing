<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Services\AccountsService;
use App\Services\TagsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

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

    public function postIndex(
        int $accountId,
        TagRequest $request,
        TagsService $tagsService
    ): RedirectResponse {
        $validatedInput = $request->validated();

        $tag = $tagsService->addTag(
            $accountId,
            $validatedInput['name'],
            $validatedInput['regex'],
            $validatedInput['hex_code']
        );

        return redirect('/dashboard/accounts/' . $accountId . '/tags');
    }
}
