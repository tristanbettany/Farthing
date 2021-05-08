<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AbstractService
{
    protected int $paginationSize = 25;

    public function paginateRecords(
        Builder $query,
        int $page = null
    ): LengthAwarePaginator {
        return $query->paginate(
            $this->paginationSize,
            ['*'],
            'page',
            $page
        );
    }
}
