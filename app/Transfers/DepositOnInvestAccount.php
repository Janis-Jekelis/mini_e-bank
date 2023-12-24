<?php
declare(strict_types=1);

namespace App\Transfers;

use App\Models\accounts\DebitAccount;
use App\Models\accounts\InvestmentAccount;
use App\Models\User;

class DepositOnInvestAccount
{

    private float $amount;
    private DebitAccount $debitAcc;
    private InvestmentAccount $investAcc;

    public function __construct(User $user, float $amount)
    {
        $this->amount = $amount;
        $this->debitAcc = $user->debitAccount()->get()->first();
        $this->investAcc = $user->investmentAccount()->get()->first();
    }

    public function make()
    {
        $this->debitAcc->withdraw($this->amount);
        $this->debitAcc->update();
        $this->investAcc->deposit($this->amount);
        $this->investAcc->update();
    }
}

