<?php

namespace App\Interfaces;

use App\Models\Transaction;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;

interface TransactionsInterface
{
    public function getTransaction(int $transactionId): Transaction;

    public function getTransactionsQuery(int $accountId): Builder;

    public function filterTransactionsByDate(
        Builder $transactionsQuery,
        DateTimeInterface $from,
        DateTimeInterface $to
    ): Builder;

    public function orderTransactions(Builder $transactionsQuery): Builder;

    public function getExistingTemplateTransaction(
        int $accountId,
        int $templateId,
        string $name,
        float $amount,
        DateTimeInterface $date
    ): ?Transaction;

    public function uploadTransactions(
        int $accountId,
        string $bank,
        UploadedFile $file
    ): void;

    public function updateTransaction(
        int $transactionId,
        string $name,
        float $amount,
        DateTimeInterface $date
    ): Transaction;

    public function deleteTransaction(int $transactionId): void;

    public function addTransaction(
        int $accountId,
        DateTimeInterface $date,
        float $amount,
        string $type,
        string $name,
        int $templateId = null
    ): Transaction;

    public function countUncashedTransactions(int $accountId): int;

    public function determineStartPage(int $accountId): int;

    public function recalculateRunningTotals(int $accountId): void;
}
