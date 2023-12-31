<?php

namespace App\Models\accounts;

use App\Interfaces\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebitAccount extends Model
{
    use HasFactory;

    protected $table = 'debit_accounts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'account_number',
        'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deposit(float $amount):void
    {
        $this->amount+=($amount*100);
    }
    public function withdraw(float $amount):void
    {
        $this->amount-=($amount*100);
    }
}
