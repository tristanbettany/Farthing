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
use DateTimeImmutable;

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

    public function addTransaction(
        int $accountId,
        DateTimeImmutable $date,
        float $amount,
        string $type,
        string $name
    ): TransactionModel {
        $massAssignment = [
            'account_id' => $accountId,
            'name' => $name,
            'amount' => $amount,
            'date' => $date,
        ];

        if ($type === TransactionModel::TYPE_FUTURE) {
            $massAssignment['is_future'] = true;
        }

        if ($type === TransactionModel::TYPE_PENDING) {
            $massAssignment['is_pending'] = true;
        }

        $transaction = TransactionModel::create($massAssignment);

        $this->recalculateRunningTotals($accountId);

        return $transaction->fresh();
    }

    public function recalculateRunningTotals(int $accountId): void
    {
        $lastCashedTransaction = TransactionModel::query()
            ->where('account_id', $accountId)
            ->where('is_cashed', true)
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->limit(1)
            ->first();

        $otherTransactions = TransactionModel::query()
            ->where('account_id', $accountId)
            ->where('is_cashed', false)
            ->orderBy('date', 'ASC')
            ->orderBy('id', 'ASC')
            ->get();

        if ($lastCashedTransaction === null) {
            $lastRunningTotal = 0.00;
        } else {
            $lastRunningTotal = $lastCashedTransaction->running_total;
        }

        foreach($otherTransactions as $transaction) {
            $transaction->running_total = $lastRunningTotal + $transaction->amount;
            $transaction->save();

            $lastRunningTotal = $transaction->running_total;
        }
    }
}
