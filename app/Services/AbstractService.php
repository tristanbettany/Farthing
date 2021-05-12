<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AbstractService implements ServiceInterface
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
