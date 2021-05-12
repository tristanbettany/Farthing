<?php

namespace App\Interfaces;

use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;

interface TemplatesInterface
{
    public function getTemplate($templateId): Template;

    public function getTemplatesQuery(int $accountId): Builder;

    public function orderTemplates(Builder $templatesQuery): Builder;

    public function updateTemplate(
        int $accountId,
        int $templateId,
        string $name,
        float $amount,
        int $occurances,
        string $occuranceSyntax
    ): Template;

    public function addTemplate(
        int $accountId,
        float $amount,
        int $occurances,
        string $occuranceSyntax,
        string $name
    ): Template;

    public function generateTemplateTransactions(
        int $accountId,
        Template $templateModel
    ): void;

    public function removeTemplateTransactions($templateId): void;

    public function deactivateTemplate(
        int $accountId,
        int $templateId
    ): void;

    public function activateTemplate(
        int $accountId,
        int $templateId
    ): void;

    public function deleteTemplate(
        int $accountId,
        int $templateId
    ): void;
}
