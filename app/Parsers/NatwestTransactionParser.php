<?php

namespace App\Parsers;

use App\Interfaces\TransactionParserInterface;
use DateTimeImmutable;

final class NatwestTransactionParser extends AbstractTransactionParser implements TransactionParserInterface
{
    public function parse(): array
    {
        $this->rows = array_reverse($this->rows);

        $parsedRows = [];
        foreach($this->rows as $row) {
            if (empty($row) === true || count($row) === 1 || $row[0] === 'Date') {
                continue;
            }

            $row[0] = str_replace('/', '-', $row[0]);

            $parsedRows[] = [
                'name' => $row[2],
                'amount' => $row[3],
                'is_cashed' => true,
                'date' => new DateTimeImmutable($row[0]),
                'running_total' => $row[4],
            ];
        }

        return $parsedRows;
    }
}
