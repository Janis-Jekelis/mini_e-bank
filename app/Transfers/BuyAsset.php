<?php
declare(strict_types=1);

namespace App\Transfers;

use App\Api\CurrencyRates;
use App\Models\accounts\InvestmentAccount;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BuyAsset
{
    private User $user;
    private string $name;
    private float $amount;

    public function __construct(
        User   $user,
        string $name,
        float  $amount
    )
    {
        $this->user = $user;
        $this->name = $name;
        $this->amount = $amount;
    }

    public function buy(): void
    {
        $account = $this->user->investmentAccount()->get()->first();
        $rate = $this->getRate();
        $asset = Asset::firstOrNew([
            'name' => $this->name,
        ]);
        $asset->amount += $this->amount;
        $asset->open_rate = $rate;
        $asset->investmentAccount()->associate($account);
        $asset->save();
        $account->withdraw(round($this->getRate() * $this->amount), 2);
        $account->update();
    }

    public function getRate(): float
    {
        return CurrencyRates::getRate($this->user->currency, $this->name);
    }
}
