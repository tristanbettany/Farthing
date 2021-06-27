<?php

namespace App\Models;

use App\Models\Pivots\TransactionTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tag extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'tags';

    protected $fillable = [
        'account_id',
        'name',
        'regex',
        'hex_code',
        'is_light_text',
    ];

    protected $casts = [
        'is_light_text' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(
            Transaction::class,
            TransactionTag::class,
            'tag_id',
            'transaction_id',
        );
    }

    public function getTruncatedName()
    {
        return substr($this->name, 0, 10);
    }
}
