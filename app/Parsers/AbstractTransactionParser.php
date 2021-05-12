<?php

namespace App\Parsers;

use Illuminate\Http\UploadedFile;

abstract class AbstractTransactionParser
{
    public const PARSER_NATWEST = 'Natwest CSV';

    protected array $rows;

    public function __construct(
        protected UploadedFile $transactionsFile
    ) {
        $this->load();
    }

    protected function load()
    {
        $this->rows = array_map(
            'str_getcsv',
            file($this->transactionsFile->getRealPath())
        );
    }
}
