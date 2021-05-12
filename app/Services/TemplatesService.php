<?php

namespace App\Services;

use App\Models\Template;
use App\Models\Transaction;
use Cron\CronExpression;
use Illuminate\Database\Eloquent\Builder;

final class TemplatesService extends AbstractService
{
    public function __construct(
        private TransactionsService $transactionsService
    ) {}

    public function getTemplate($templateId): Template
    {
        return Template::where('id', $templateId)
            ->firstOrFail();
    }

    public function getTemplatesQuery(int $accountId): Builder
    {
        return Template::query()
            ->where('account_id', $accountId);
    }

    public function orderTemplates(Builder $templatesQuery): Builder
    {
        return $templatesQuery->orderByDesc('created_at');
    }

    public function updateTemplate(
        int $accountId,
        int $templateId,
        string $name,
        float $amount,
        int $occurances,
        string $occuranceSyntax
    ): Template {
        $template = $this->getTemplate($templateId);

        $template->name = $name;
        $template->amount = $amount;
        $template->occurances = $occurances;
        $template->occurance_syntax = $occuranceSyntax;

        $template->save();

        $this->deactivateTemplate(
            $accountId,
            $templateId
        );

        $this->activateTemplate(
            $accountId,
            $templateId
        );

        return $template;
    }

    public function addTemplate(
        int $accountId,
        float $amount,
        int $occurances,
        string $occuranceSyntax,
        string $name
    ): Template {
        $template = Template::create([
            'account_id' => $accountId,
            'amount' => $amount,
            'occurances' => $occurances,
            'occurance_syntax' => $occuranceSyntax,
            'name' => $name,
        ]);

        $this->generateTemplateTransactions(
            $accountId,
            $template
        );

        $this->transactionsService->recalculateRunningTotals($accountId);

        return $template;
    }

    public function generateTemplateTransactions(
        int $accountId,
        Template $templateModel
    ): void {
        $dates = (new CronExpression($templateModel->occurance_syntax))
            ->getMultipleRunDates($templateModel->occurances);

        if (empty($dates) === false) {
            foreach ($dates as $date) {
                $existingTransaction = $this->transactionsService->getExistingTemplateTransaction(
                        $accountId,
                        $templateModel->id,
                        $templateModel->name,
                        $templateModel->amount,
                        $date
                    );

                if(empty($existingTransaction) === true) {
                    $this->transactionsService->addTransaction(
                        $accountId,
                        $date,
                        $templateModel->amount,
                        Transaction::TYPE_FUTURE,
                        $templateModel->name,
                        $templateModel->id
                    );
                }
            }
        }
    }

    public function removeTemplateTransactions($templateId): void
    {
        Transaction::query()
            ->where('template_id', $templateId)
            ->delete();
    }

    public function deactivateTemplate(
        int $accountId,
        int $templateId
    ): void {
        $this->removeTemplateTransactions($templateId);

        $this->transactionsService->recalculateRunningTotals($accountId);

        $template = $this->getTemplate($templateId);
        $template->is_active = false;
        $template->save();
    }

    public function activateTemplate(
        int $accountId,
        int $templateId
    ): void {
        $template = $this->getTemplate($templateId);

        $this->generateTemplateTransactions(
            $accountId,
            $template
        );

        $this->transactionsService->recalculateRunningTotals($accountId);

        $template->is_active = true;
        $template->save();
    }

    public function deleteTemplate(
        int $accountId,
        int $templateId
    ): void {
        $this->removeTemplateTransactions($templateId);

        $template = $this->getTemplate($templateId);
        $template->delete();

        $this->transactionsService->recalculateRunningTotals($accountId);
    }
}
