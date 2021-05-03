<?php

namespace App\Services;

use App\Models\AccountModel;
use App\Models\Pivots\TransactionTagPivot;
use App\Models\TagModel;
use App\Models\TransactionModel;
use App\Parsers\AbstractTransactionParser;
use App\Parsers\NatwestTransactionParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Exception;
use DateTimeInterface;

final class TransactionsService extends AbstractService
{
    public function getTransaction(int $transactionId): TransactionModel
    {
        return TransactionModel::where('id', $transactionId)
            ->firstOrFail();
    }

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
        if ($bank === AbstractTransactionParser::PARSER_NATWEST) {
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

    public function updateTransaction(
        int $transactionId,
        string $name,
        float $amount,
        DateTimeInterface $date
    ): TransactionModel {
        $transaction = $this->getTransaction($transactionId);

        $transaction->name = $name;
        $transaction->amount = $amount;
        $transaction->date = $date;

        $transaction->save();

        return $transaction;
    }

    public function addTransaction(
        int $accountId,
        DateTimeInterface $date,
        float $amount,
        string $type,
        string $name,
        int $templateId = null
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

        if ($type === TransactionModel::TYPE_CASHED) {
            $massAssignment['is_cashed'] = true;
        }

        if ($templateId !== null) {
            $massAssignment['template_id'] = $templateId;
        }

        $transaction = TransactionModel::create($massAssignment);

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
