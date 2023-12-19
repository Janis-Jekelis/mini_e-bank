<?php

namespace App\Models\accounts;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebitAccount extends Model
{
    use HasFactory;

    protected $table = 'debit_accounts';
    protected $primaryKey = 'id';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
