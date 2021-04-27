<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AccountModel extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'accounts';

    protected $fillable = [
        'account_number',
        'sort_code',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(TransactionModel::class);
    }

    public function templates()
    {
        return $this->hasMany(TemplateModel::class);
    }

    public function tags()
    {
        return $this->hasMany(TagModel::class);
    }
}
