<?php

namespace App\Services;

use App\Models\AccountModel;
use App\Models\Pivots\TransactionTagPivot;
use App\Models\TagModel;
use App\Models\TransactionModel;
use App\Parsers\NatwestTransactionParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Exception;

final class TransactionsService extends AbstractService
{
    public function getTransactionsQuery(AccountModel $account): Builder
    {
        return TransactionModel::query()
            ->where('account_id', $account->id);
    }

    public function orderTransactions(Builder $transactionsQuery): Builder
    {
        return $transactionsQuery->orderByDesc('date')
            ->orderByDesc('id');
    }

    public function uploadTransactions(
        int $accountId,
        string $bank,
        UploadedFile $file
    ): void {
        if ($bank === 'Natwest') {
            $parser = new NatwestTransactionParser($file);
            $rows = $parser->parse();
        }

        if (empty($rows) === false) {
            $tags = TagModel::query()
                ->where('account_id', $accountId)
                ->get();

            foreach ($rows as $row) {
                $row['account_id'] = $accountId;
                $transaction = TransactionModel::create($row);

                foreach ($tags as $tag) {
                    $match = preg_match('/' . $tag->regex . '/', $transaction->name);
                    if ($match === 1) {
                        TransactionTagPivot::create([
                            'transaction_id' => $transaction->id,
                            'tag_id' => $tag->id,
                        ]);
                    }
                }
            }
        } else {
            throw new Exception('Nothing to upload');
        }
    }
}
