<?php

namespace App\Models;

use App\Models\Pivots\TransactionTagPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TagModel extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'tags';

    protected $fillable = [
        'account_id',
        'name',
        'regex',
        'hex_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(AccountModel::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(
            TransactionModel::class,
            TransactionTagPivot::class,
            'tag_id',
            'transaction_id',
        );
    }

    public function getTruncatedName()
    {
        return substr($this->name, 0, 10);
    }
}
