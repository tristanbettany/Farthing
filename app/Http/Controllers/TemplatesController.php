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

        $templatesQuery = $templatesService->getTemplatesQuery($accountId);

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

    public function getDeactivate(
        int $accountId,
        int $templateId,
        TemplatesService $templatesService
    ): RedirectResponse {
        try {
            $templatesService->deactivateTemplate(
                $accountId,
                $templateId
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Deactivate Template ' . $e->getMessage());
        }

        Session::flash('success', 'Deactivated Template');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }

    public function getDeactivateAll(
        int $accountId,
        TemplatesService $templatesService
    ): RedirectResponse {
        try {
            $templates = $templatesService->getTemplatesQuery($accountId)
                ->get();

            foreach ($templates as $template) {
                $templatesService->deactivateTemplate(
                    $accountId,
                    $template->id
                );
            }
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Deactivate All Templates ' . $e->getMessage());
        }

        Session::flash('success', 'Deactivated All Templates');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }

    public function getActivate(
        int $accountId,
        int $templateId,
        TemplatesService $templatesService
    ): RedirectResponse {
        try {
            $templatesService->activateTemplate(
                $accountId,
                $templateId
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Activate Template ' . $e->getMessage());
        }

        Session::flash('success', 'Activated Template');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }

    public function getActivateAll(
        int $accountId,
        TemplatesService $templatesService
    ): RedirectResponse {
        try {
            $templates = $templatesService->getTemplatesQuery($accountId)
                ->get();

            foreach ($templates as $template) {
                $templatesService->activateTemplate(
                    $accountId,
                    $template->id
                );
            }
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Activate All Templates ' . $e->getMessage());
        }

        Session::flash('success', 'Activated All Templates');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }

    public function getDelete(
        int $accountId,
        int $templateId,
        TemplatesService $templatesService
    ): RedirectResponse {
        try {
            $templatesService->deleteTemplate(
                $accountId,
                $templateId
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Delete Template ' . $e->getMessage());
        }

        Session::flash('success', 'Deleted Template');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }

    public function getView(
        int $accountId,
        int $templateId,
        AccountsService $accountsService,
        TemplatesService $templatesService
    ): Renderable {
        $account = $accountsService->getAccount($accountId);
        $template = $templatesService->getTemplate($templateId);

        return view('dashboard.templates.view')
            ->with('account', $account)
            ->with('template', $template);
    }

    public function postView(
        int $accountId,
        int $templateId,
        TemplateRequest $request,
        TemplatesService $templatesService
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $template = $templatesService->updateTemplate(
                $accountId,
                $templateId,
                $validatedInput['name'],
                (float) $validatedInput['amount'],
                (int) $validatedInput['occurances'],
                $validatedInput['occurance_syntax']
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Update Template ' . $e->getMessage());
        }

        Session::flash('success', 'Updated Template');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }
}
