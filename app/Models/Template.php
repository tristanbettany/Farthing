<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Template extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'templates';

    protected $fillable = [
        'account_id',
        'name',
        'amount',
        'occurances',
        'occurance_syntax',
    ];

    protected $casts = [
        'amount' => 'float',
        'occurances' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
