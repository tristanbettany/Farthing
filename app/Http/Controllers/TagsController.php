<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Services\AccountsService;
use App\Services\TagsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

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

    public function getView(
        int $accountId,
        int $tagId,
        AccountsService $accountsService,
        TagsService $tagsService
    ): Renderable {
        $account = $accountsService->getAccount($accountId);
        $tag = $tagsService->getTag($tagId);

        return view('dashboard.tags.view')
            ->with('account', $account)
            ->with('tag', $tag);
    }

    public function postView(
        int $accountId,
        int $tagId,
        TagRequest $request,
        AccountsService $accountsService,
        TagsService $tagsService
    ): RedirectResponse {
        $validatedInput = $request->validated();

        $tag = $tagsService->updateTag(
            $tagId,
            $validatedInput['name'],
            $validatedInput['regex'],
            $validatedInput['hex_code']
        );

        Session::flash('success', 'Updated Tag');

        return redirect('/dashboard/accounts/' . $accountId . '/tags');
    }

    public function getDelete(
        int $accountId,
        int $tagId,
        TagsService $tagsService
    ): RedirectResponse {
        $tagsService->deleteTag($tagId);

        Session::flash('success', 'Deleted Tag');

        return redirect('/dashboard/accounts/' . $accountId . '/tags');
    }
}
