<?php
declare(strict_types=1);

namespace App\Transfers;

use App\Models\accounts\DebitAccount;
use App\Models\User;

class DepositOnDebitAccount
{
    public static function make(User $user, float $amount): void
    {
        $debitAcc = $user->debitAccount()->get()->first();
        $debitAcc->deposit($amount);
        $debitAcc->update();
    }
}
