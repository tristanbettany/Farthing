<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Notifications\Notifiable;

class TransactionTagPivot extends Pivot
{
    use HasFactory;
    use Notifiable;

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
