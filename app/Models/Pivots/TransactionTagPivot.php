<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TransactionTagPivot extends Pivot
{
    public $incrementing = true;

    protected $table = 'transactions_tags';

    protected $fillable = [
        'transaction_id',
        'tag_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
