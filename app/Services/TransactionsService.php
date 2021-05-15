<?php

namespace App\Services;

use App\Interfaces\TagsServiceInterface;
use App\Interfaces\TransactionsServiceInterface;
use App\Models\Pivots\TransactionTag;
use App\Models\Transaction;
use App\Parsers\AbstractTransactionParser;
use App\Parsers\NatwestTransactionParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Exception;
use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use DateTime;

final class TransactionsService extends AbstractService implements TransactionsServiceInterface
{
    public function __construct(
        private TagsServiceInterface $tagsService
    ) {}

    public function getTransaction(int $transactionId): Transaction
    {
        return Transaction::where('id', $transactionId)
            ->firstOrFail();
    }

    public function getTransactionsQuery(int $accountId): Builder
    {
        return Transaction::query()
            ->where('account_id', $accountId);
    }

    public function filterTransactionsByDate(
        Builder $transactionsQuery,
        DateTimeInterface $from,
        DateTimeInterface $to
    ): Builder {
        return $transactionsQuery
            ->where('date', '>=', $from)
            ->where('date', '<=', $to);
    }

    public function orderTransactions(Builder $transactionsQuery): Builder
    {
        return $transactionsQuery->orderByDesc('date')
            ->orderByDesc('id');
    }

    public function getExistingTemplateTransaction(
        int $accountId,
        int $templateId,
        string $name,
        float $amount,
        DateTimeInterface $date
    ): ?Transaction {
        return $this->getTransactionsQuery($accountId)
            ->where('template_id', $templateId)
            ->where('name', $name)
            ->where('amount', $amount)
            ->where('date', $date)
            ->first();
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
            $tags = $this->tagsService->getTagsQuery($accountId)->get();

            foreach ($rows as $row) {
                $row['account_id'] = $accountId;
                $transaction = Transaction::create($row);

                $this->tagsService->matchTags(
                    $tags,
                    $transaction->name,
                    function ($tag) use ($transaction) {
                        TransactionTag::create([
                            'transaction_id' => $transaction->id,
                            'tag_id' => $tag->id,
                        ]);
                    }
                );
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
    ): Transaction {
        $transaction = $this->getTransaction($transactionId);

        $transaction->name = $name;
        $transaction->amount = $amount;
        $transaction->date = $date;

        $transaction->save();

        return $transaction;
    }

    public function deleteTransaction(int $transactionId): void
    {
        $transaction = $this->getTransaction($transactionId);

        TransactionTag::query()
            ->where('transaction_id', $transactionId)
            ->delete();

        $transaction->delete();
    }

    public function addTransaction(
        int $accountId,
        DateTimeInterface $date,
        float $amount,
        string $type,
        string $name,
        int $templateId = null
    ): Transaction {
        $massAssignment = [
            'account_id' => $accountId,
            'name' => $name,
            'amount' => $amount,
            'date' => $date,
        ];

        if ($type === Transaction::TYPE_FUTURE) {
            $massAssignment['is_future'] = true;
        }

        if ($type === Transaction::TYPE_PENDING) {
            $massAssignment['is_pending'] = true;
        }

        if ($type === Transaction::TYPE_CASHED) {
            $massAssignment['is_cashed'] = true;
        }

        if ($templateId !== null) {
            $massAssignment['template_id'] = $templateId;
        }

        $transaction = Transaction::create($massAssignment);

        return $transaction->fresh();
    }

    public function countUncashedTransactions(int $accountId): int
    {
        return Transaction::query()
            ->where('account_id', $accountId)
            ->where('is_cashed', false)
            ->orderBy('date', 'ASC')
            ->orderBy('id', 'ASC')
            ->count();
    }

    public function determineStartPage(int $accountId): int
    {
        $uncashedCount = $this->countUncashedTransactions($accountId);

        $uncashedCount = $uncashedCount + 2;

        return ceil($uncashedCount / $this->paginationSize);
    }

    public function recalculateRunningTotals(int $accountId): void
    {
        $lastCashedTransaction = Transaction::query()
            ->where('account_id', $accountId)
            ->where('is_cashed', true)
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->limit(1)
            ->first();

        $otherTransactions = Transaction::query()
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

        $rowValues=[];
        foreach($otherTransactions as $transaction) {
            $newRunningTotal = $lastRunningTotal + $transaction->amount;

            $rowValues[] = sprintf("
                (%s, %s, '%s', '%s', %s, '%s')
            ",
                $transaction->id,
                $newRunningTotal,
                $accountId,
                $transaction->name,
                $transaction->amount,
                $transaction->date
            );

            $lastRunningTotal = $newRunningTotal;
        }

        if (empty($rowValues) === false) {
            $sql = sprintf("
                INSERT INTO transactions
                (`id`, `running_total`, `account_id`, `name`, `amount`, `date`)
                VALUES %s
                ON DUPLICATE KEY UPDATE
                `running_total`=VALUES(`running_total`);
            ",
                implode(',', $rowValues)
            );

            DB::statement($sql);
        }
    }

    public function getMonthlyCalculations(
        int $accountId,
        int $months
    ): array {
        $calculations = [];
        $date = new DateTime('first day of this month midnight');

        $from = $date;
        $to = $date->modify('+1 month')
            ->modify('-1 day');

        $rangeCalculations = $this->getCalculationsForRange(
            $accountId,
            $from,
            $to
        );

        $calculations[] = [
            'from' => $from,
            'to' => $to,
            'calculations' => $rangeCalculations,
        ];

        for ($i = 1; $i <= $months; $i++) {
            $from = new DateTime('first day of this month midnight');
            $to = new DateTime('first day of this month midnight');

            $from->modify('-'. $i .' month');
            $to->modify('-'. $i .' month')
                ->modify('+1 month')
                ->modify('-1 day');

            $rangeCalculations = $this->getCalculationsForRange(
                $accountId,
                $from,
                $to
            );

            $calculations[] = [
                'from' => $from,
                'to' => $to,
                'calculations' => $rangeCalculations,
            ];
        }

        return $calculations;
    }

    public function getCalculationsForRange(
        int $accountId,
        DateTimeInterface $from,
        DateTimeInterface $to
    ): array {
        $transactions = $this->getTransactionsQuery($accountId)
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get();

        if (
            empty($transactions) === true
            || $transactions->count() < 1
        ) {
            return [
                'start' => null,
                'end' => null,
                'diff' => null,
            ];
        }

        $firstTransaction = $transactions->first();
        $lastTransaction = $transactions->last();

        return [
            'start' => $firstTransaction->running_total,
            'end' => $lastTransaction->running_total,
            'diff' => $lastTransaction->running_total - $firstTransaction->running_total,
        ];
    }
}
