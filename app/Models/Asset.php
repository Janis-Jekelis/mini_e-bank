<?php

namespace App\Models;

use App\Api\CurrencyRates;
use App\Models\accounts\InvestmentAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'amount',
        'open_rate'
    ];

    public function investmentAccount(): BelongsTo
    {
        return $this->belongsTo(InvestmentAccount::class);
    }

    public function getCurrentRateAndValue(): array
    {
        $rate = (CurrencyRates::getRate(Auth::user()->currency, $this->name));
        return [round($rate, 2), round($rate * $this->amount, 2)];
    }

    public function sell(float $amount): void
    {
       $value=round(($this->getCurrentRateAndValue()[0])*$amount,2);
        $account = $this->investmentAccount()->get()->first();
        if ($this->amount >= $amount) {
            $this->amount -= $amount;
            $account->deposit($value);
            $account->update();
            $this->update();
            if ($this->amount == 0) {
                $this->delete();
            }
        }

    }
}
