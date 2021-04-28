<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AbstractService
{
    private int $paginationSize = 25;

    public function paginateRecords(Builder $query): LengthAwarePaginator
    {
        return $query->paginate($this->paginationSize);
    }
}
