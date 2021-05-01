<?php

namespace App\Http\Controllers;

use App\Services\AccountsService;
use App\Services\TemplatesService;
use Illuminate\Contracts\Support\Renderable;

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
}
