<?php

namespace App\Interfaces;

interface TransactionParserInterface
{
    /**
     * Must return an array of rows compatible
     * with mass assignment for transaction model
     *
     * @return array
     */
    public function parse(): array;
}
