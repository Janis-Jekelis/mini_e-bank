<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Amount implements Rule
{

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value):bool
    {
       $funds=Auth::user()->debitAccount->amount;
        return ($value*100)<=$funds;
    }

    public function message():string
    {
        return 'Insufficient funds';
    }
}
