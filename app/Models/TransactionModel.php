<?php

namespace App\Models;

use App\Models\Pivots\TransactionTagPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TransactionModel extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'transactions';

    protected $fillable = [
        'account_id',
        'name',
        'amount',
        'date',
        'running_total',
    ];

    protected $casts = [
        'is_cashed' => 'boolean',
        'is_pending' => 'boolean',
        'is_future' => 'boolean',
        'amount' => 'float',
        'running_total' => 'float',
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(AccountModel::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            TagModel::class,
            TransactionTagPivot::class,
            'transaction_id',
            'tag_id',
        );
    }
}
