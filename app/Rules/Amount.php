<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Amount implements Rule
{
    private float $accountFunds;
    private float $rate;

    public function __construct(float $accountFunds, ?float $rate = 1)
    {
        $this->accountFunds = $accountFunds;
        $this->rate = $rate;
    }

    public function passes($attribute, $value): bool
    {

        return ($value * 100 * $this->rate) <= $this->accountFunds;
    }

    public function message(): string
    {
        return 'Insufficient funds';
    }
}
