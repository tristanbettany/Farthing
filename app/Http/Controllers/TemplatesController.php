<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateRequest;
use App\Services\AccountsService;
use App\Services\TemplatesService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Exception;

class TemplatesController extends Controller
{
    public function getIndex(
        int $accountId,
        AccountsService $accountsService,
        TemplatesService $templatesService
    ): Renderable {
        $account = $accountsService->getAccount($accountId);

        $templatesQuery = $templatesService->getTemplatesQuery($account);

        $templatesQuery = $templatesService->orderTemplates($templatesQuery);

        return view('dashboard.templates.index')
            ->with('templates', $templatesService->paginateRecords($templatesQuery))
            ->with('account', $account);
    }

    public function postIndex(
        int $accountId,
        TemplateRequest $request,
        TemplatesService $templatesService
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $templatesService->addTemplate(
                $accountId,
                (float) $validatedInput['amount'],
                (int) $validatedInput['occurances'],
                $validatedInput['occurance_syntax'],
                $validatedInput['name'],
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Add Template ' . $e->getMessage());
        }

        Session::flash('success', 'Added Template');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }
}
