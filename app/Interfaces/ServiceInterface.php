<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

interface ServiceInterface
{
    public function paginateRecords(
        Builder $query,
        int $page = null
    ): LengthAwarePaginator;
}
