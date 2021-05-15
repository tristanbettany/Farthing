<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Jobs\ProcessTagsJob;
use App\Services\AccountsServiceService;
use App\Services\TagsServiceService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Exception;

class TagsController extends Controller
{
    public function __construct(
        private AccountsServiceService $accountsService,
        private TagsServiceService $tagsService
    ){}

    public function getIndex(int $accountId): Renderable
    {
        $account = $this->accountsService->getAccount($accountId);

        $tagsQuery = $this->tagsService->getTagsQuery($accountId);

        $tagsQuery = $this->tagsService->orderTags($tagsQuery);

        return view('dashboard.tags.index')
            ->with('tags', $this->tagsService->paginateRecords($tagsQuery))
            ->with('account', $account);
    }

    public function postIndex(
        int $accountId,
        TagRequest $request
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $tag = $this->tagsService->addTag(
                $accountId,
                $validatedInput['name'],
                $validatedInput['regex'],
                $validatedInput['hex_code']
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Add Tag ' . $e->getMessage());
        }

        Session::flash('success', 'Added Tag');

        return redirect('/dashboard/accounts/' . $accountId . '/tags');
    }

    public function getView(
        int $accountId,
        int $tagId
    ): Renderable {
        $account = $this->accountsService->getAccount($accountId);
        $tag = $this->tagsService->getTag($tagId);

        return view('dashboard.tags.view')
            ->with('account', $account)
            ->with('tag', $tag);
    }

    public function postView(
        int $accountId,
        int $tagId,
        TagRequest $request
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $tag = $this->tagsService->updateTag(
                $tagId,
                $validatedInput['name'],
                $validatedInput['regex'],
                $validatedInput['hex_code']
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Update Tag ' . $e->getMessage());
        }

        Session::flash('success', 'Updated Tag');

        return redirect('/dashboard/accounts/' . $accountId . '/tags');
    }

    public function getDelete(
        int $accountId,
        int $tagId
    ): RedirectResponse {
        try {
            $this->tagsService->deleteTag($tagId);
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Delete Tag ' . $e->getMessage());
        }

        Session::flash('success', 'Deleted Tag');

        return redirect('/dashboard/accounts/' . $accountId . '/tags');
    }

    public function getProcess(
        int $accountId
    ): RedirectResponse {
        ProcessTagsJob::dispatch($accountId);

        Session::flash('success', 'Tags will be processed onto transactions in the background');

        return redirect('/dashboard/accounts/' . $accountId . '/tags');
    }
}
