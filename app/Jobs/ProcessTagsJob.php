<?php

namespace App\Jobs;

use App\Models\Pivots\TransactionTag;
use App\Services\AccountsServiceService;
use App\Services\TagsServiceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTagsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private int $accountId
    ) {}

    public function handle(): void
    {
        /** @var AccountsServiceService $accountsService */
        $accountsService = app()->get(AccountsServiceService::class);
        /** @var TagsServiceService $tagsService */
        $tagsService = app()->get(TagsServiceService::class);

        $account = $accountsService->getAccount($this->accountId);
        $tagsService->dropTags($account->id);

        foreach ($account->transactions as $transaction) {
            $tagsService->matchTags(
                $tagsService->getTagsQuery($this->accountId)->get(),
                $transaction->name,
                function ($tag) use ($transaction) {
                    TransactionTag::create([
                        'transaction_id' => $transaction->id,
                        'tag_id' => $tag->id,
                    ]);
                }
            );
        }
    }
}
