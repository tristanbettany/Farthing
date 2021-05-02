<?php

namespace App\Parsers;

use Illuminate\Http\UploadedFile;

abstract class AbstractTransactionParser
{
    protected UploadedFile $transactionsFile;
    protected array $rows;

    public function __construct(UploadedFile $transactionsFile)
    {
        $this->transactionsFile = $transactionsFile;

        $this->load();
    }

    public function load()
    {
        $this->rows = array_map(
            'str_getcsv',
            file($this->transactionsFile->getRealPath())
        );
    }
}
