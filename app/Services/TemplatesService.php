<?php

namespace App\Services;

use App\Models\AccountModel;
use App\Models\TemplateModel;
use Illuminate\Database\Eloquent\Builder;

final class TemplatesService extends AbstractService
{
    public function getTemplatesQuery(AccountModel $account): Builder
    {
        return TemplateModel::query()
            ->where('account_id', $account->id);
    }

    public function orderTemplates(Builder $templatesQuery): Builder
    {
        return $templatesQuery->orderByDesc('created_at');
    }
}
