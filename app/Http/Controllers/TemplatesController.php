<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateRequest;
use App\Services\AccountsServiceService;
use App\Services\TemplatesServiceService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Exception;

class TemplatesController extends Controller
{
    public function __construct(
        private AccountsServiceService $accountsService,
        private TemplatesServiceService $templatesService
    ){}

    public function getIndex(int $accountId): Renderable
    {
        $account = $this->accountsService->getAccount($accountId);

        $templatesQuery = $this->templatesService->getTemplatesQuery($accountId);

        $templatesQuery = $this->templatesService->orderTemplates($templatesQuery);

        return view('dashboard.templates.index')
            ->with('templates', $this->templatesService->paginateRecords($templatesQuery))
            ->with('account', $account);
    }

    public function postIndex(
        int $accountId,
        TemplateRequest $request
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $this->templatesService->addTemplate(
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
        int $templateId
    ): RedirectResponse {
        try {
            $this->templatesService->deactivateTemplate(
                $accountId,
                $templateId
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Deactivate Template ' . $e->getMessage());
        }

        Session::flash('success', 'Deactivated Template');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }

    public function getDeactivateAll(int $accountId): RedirectResponse
    {
        try {
            $templates = $this->templatesService->getTemplatesQuery($accountId)
                ->get();

            foreach ($templates as $template) {
                $this->templatesService->deactivateTemplate(
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
        int $templateId
    ): RedirectResponse {
        try {
            $this->templatesService->activateTemplate(
                $accountId,
                $templateId
            );
        } catch (Exception $e) {
            Session::flash('error', 'Failed To Activate Template ' . $e->getMessage());
        }

        Session::flash('success', 'Activated Template');

        return redirect('/dashboard/accounts/' . $accountId . '/templates');
    }

    public function getActivateAll(int $accountId): RedirectResponse
    {
        try {
            $templates = $this->templatesService->getTemplatesQuery($accountId)
                ->get();

            foreach ($templates as $template) {
                $this->templatesService->activateTemplate(
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
        int $templateId
    ): RedirectResponse {
        try {
            $this->templatesService->deleteTemplate(
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
        int $templateId
    ): Renderable {
        $account = $this->accountsService->getAccount($accountId);
        $template = $this->templatesService->getTemplate($templateId);

        return view('dashboard.templates.view')
            ->with('account', $account)
            ->with('template', $template);
    }

    public function postView(
        int $accountId,
        int $templateId,
        TemplateRequest $request
    ): RedirectResponse {
        $validatedInput = $request->validated();

        try {
            $template = $this->templatesService->updateTemplate(
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
