<?php
declare(strict_types=1);

namespace App\Transfers;

use App\Api\CurrencyRates;
use App\Models\accounts\DebitAccount;
use App\Models\User;

class Transfer
{
    private float $amount;
    private DebitAccount $senderAcc;
    private DebitAccount $receiverAcc;

    public function __construct(User $user, string $receiverAccNumber, float $amount)
    {
        $this->amount = $amount;
        $this->senderAcc = $user->debitAccount()->get()->first();
        $this->receiverAcc = DebitAccount::where('account_number', $receiverAccNumber)->get()->first();
    }

    public function make(): void
    {
        $this->senderAcc->withdraw($this->amount);
        $this->senderAcc->update();
        if (false === $this->checkCurrencyCompatibility()) {
            $this->amount = round($this->amount * $this->getRate(), 2);
        }
        $this->receiverAcc->deposit($this->amount);
        $this->receiverAcc->update();
    }

    private function checkCurrencyCompatibility(): bool
    {
        return $this->senderAcc->currency === $this->receiverAcc->currency;
    }

    private function getRate(): float
    {
        return CurrencyRates::getRate(
            $this->senderAcc->currency,
            $this->receiverAcc->currency,
        );
    }
}
