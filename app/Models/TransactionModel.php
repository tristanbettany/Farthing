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
        'is_cashed',
        'is_pending',
        'is_future',
        'template_id',
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

    public const TYPE_FUTURE = 'Future';
    public const TYPE_PENDING = 'Pending';
    public const TYPE_CASHED = 'Cashed';

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

    public function template()
    {
        return $this->belongsTo(TemplateModel::class);
    }

    public function getTruncatedName()
    {
        return substr($this->name, 0, 40);
    }
}
