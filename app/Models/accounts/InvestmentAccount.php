<?php

namespace App\Models\accounts;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestmentAccount extends Model
{
    use HasFactory;

    protected $table = 'investment_accounts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'account_number',
        'currency',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function asset():HasMany
    {
        return $this->hasMany(Asset::class);
    }
    public function deposit(float $amount):void
    {
        $this->currency_amount+=($amount*100);
    }
    public function withdraw(float $amount):void
    {
        $this->currency_amount-=($amount*100);
    }
}
