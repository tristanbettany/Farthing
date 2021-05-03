<?php

namespace App\Services;

use App\Models\AccountModel;
use App\Models\TemplateModel;
use App\Models\TransactionModel;
use Cron\CronExpression;
use Illuminate\Database\Eloquent\Builder;

final class TemplatesService extends AbstractService
{
    private TransactionsService $transactionsService;

    public function __construct(TransactionsService $transactionsService)
    {
        $this->transactionsService = $transactionsService;
    }

    public function getTemplatesQuery(AccountModel $account): Builder
    {
        return TemplateModel::query()
            ->where('account_id', $account->id);
    }

    public function orderTemplates(Builder $templatesQuery): Builder
    {
        return $templatesQuery->orderByDesc('created_at');
    }

    public function addTemplate(
        int $accountId,
        float $amount,
        int $occurances,
        string $occuranceSyntax,
        string $name
    ): TemplateModel {
        $template = TemplateModel::create([
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
        TemplateModel $templateModel
    ): void {
        $dates = (new CronExpression($templateModel->occurance_syntax))
            ->getMultipleRunDates($templateModel->occurances);

        if (empty($dates) === false) {
            foreach ($dates as $date) {
                $this->transactionsService->addTransaction(
                    $accountId,
                    $date,
                    $templateModel->amount,
                    TransactionModel::TYPE_FUTURE,
                    $templateModel->name,
                    $templateModel->id
                );
            }
        }
    }
}
